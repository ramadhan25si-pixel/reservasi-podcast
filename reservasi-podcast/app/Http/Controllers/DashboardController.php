<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\RuangPodcast;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private const SLOTS = [
        ['start' => '08:00', 'end' => '10:00'],
        ['start' => '10:00', 'end' => '12:00'],
        ['start' => '13:00', 'end' => '15:00'],
        ['start' => '15:00', 'end' => '17:00'],
    ];

    public function index(Request $request)
    {
        $request->validate([
            'start'  => ['nullable', 'date'],
            'ruang'  => ['nullable', 'exists:ruang_podcast,id'],
            'lokasi' => ['nullable', 'string', 'max:100'],
        ]);

        $base = $request->filled('start')
            ? Carbon::parse($request->start)
            : (now()->isWeekend() ? now()->next(Carbon::MONDAY) : now());

        $start = $base->copy()->startOfWeek(Carbon::MONDAY);
        $days  = collect(range(0, 4))->map(fn ($i) => $start->copy()->addDays($i));

        $semuaRuang  = RuangPodcast::orderBy('nama_ruang')->get();
        $lokasiList  = $semuaRuang->pluck('lokasi')->unique()->values();
        $ruangTampil = $semuaRuang
            ->when($request->ruang, fn ($c) => $c->where('id', (int) $request->ruang))
            ->when($request->lokasi, fn ($c) => $c->where('lokasi', $request->lokasi));

        $reservasi = Reservasi::whereBetween('tanggal_reservasi', [
                $days->first()->toDateString(), $days->last()->toDateString(),
            ])
            ->whereIn('ruang_id', $ruangTampil->pluck('id'))
            ->whereIn('status_reservasi', Reservasi::STATUS_MENGUNCI)
            ->get();

        $cells = [];
        foreach ($days as $day) {
            foreach (self::SLOTS as $slot) {
                $cells[$day->toDateString()][$slot['start']] = $this->statusSlot($ruangTampil, $reservasi, $day, $slot);
            }
        }

        return view('dashboard', [
            'days'        => $days,
            'slots'       => self::SLOTS,
            'cells'       => $cells,
            'semuaRuang'  => $semuaRuang,
            'lokasiList'  => $lokasiList,
            'prevStart'   => $start->copy()->subWeek()->toDateString(),
            'nextStart'   => $start->copy()->addWeek()->toDateString(),
            'monthLabel'  => $start->copy()->locale('id')->translatedFormat('F Y'),
        ]);
    }

    private function statusSlot($ruang, $reservasi, Carbon $day, array $slot): array
    {
        $aktif = $ruang->where('status_ruang', 'tersedia');

        if ($aktif->isEmpty()) {
            return ['status' => 'maintenance', 'free' => null];
        }

        // Overlap: reservasi bentrok dengan slot bila mulai < akhir slot dan selesai > awal slot
        $bentrok = $reservasi->filter(fn ($r) =>
            $r->tanggal_reservasi->isSameDay($day)
            && substr($r->waktu_mulai, 0, 5) < $slot['end']
            && substr($r->waktu_selesai, 0, 5) > $slot['start']
            && $aktif->contains('id', $r->ruang_id)
        );

        $free = $aktif->count() - $bentrok->pluck('ruang_id')->unique()->count();
        $tampilFree = $ruang->count() > 1;

        if ($free > 0) {
            return ['status' => 'tersedia', 'free' => $tampilFree ? $free : null];
        }

        $sudahDisetujui = $bentrok->contains(fn ($r) => $r->status_reservasi !== 'pending');

        return ['status' => $sudahDisetujui ? 'disetujui' : 'pending', 'free' => null];
    }
}
