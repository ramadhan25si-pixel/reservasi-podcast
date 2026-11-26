<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservasiRequest;
use App\Models\Fasilitas;
use App\Models\PersetujuanTataTertib;
use App\Models\Reservasi;
use App\Models\RuangPodcast;
use App\Models\TataTertib;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function create()
    {
        return view('reservasi.create', [
            'ruang'      => RuangPodcast::where('status_ruang', 'tersedia')->orderBy('nama_ruang')->get(),
            'fasilitas'  => Fasilitas::orderBy('nama_fasilitas')->get(),
            'tataTertib' => TataTertib::where('status_aktif', true)->orderBy('id')->get(),
            'jam'        => Reservasi::JAM_OPERASIONAL,
        ]);
    }

    public function store(StoreReservasiRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $reservasi = Reservasi::create([
                'user_id'           => auth()->id(),
                'ruang_id'          => $data['ruang_id'],
                'tanggal_reservasi' => $data['tanggal_reservasi'],
                'waktu_mulai'       => $data['waktu_mulai'],
                'waktu_selesai'     => $data['waktu_selesai'],
                'keperluan'         => $data['keperluan'],
                'status_reservasi'  => 'pending',
                'tanggal_pengajuan' => now(),
            ]);

            // Fasilitas tambahan (tabel pivot detail_reservasi_fasilitas)
            foreach ($data['fasilitas'] ?? [] as $fasilitasId => $qty) {
                $reservasi->fasilitas()->attach($fasilitasId, ['jumlah_digunakan' => $qty]);
            }

            // Catat persetujuan tiap aturan yang aktif
            foreach (TataTertib::where('status_aktif', true)->get() as $aturan) {
                PersetujuanTataTertib::create([
                    'user_id'             => auth()->id(),
                    'tata_tertib_id'      => $aturan->id,
                    'reservasi_id'        => $reservasi->id,
                    'tanggal_persetujuan' => now(),
                    'status_persetujuan'  => true,
                ]);
            }
        });

        return redirect()->route('dashboard')
            ->with('success', 'Reservasi berhasil diajukan dan menunggu verifikasi admin.');
    }
}