<?php

namespace App\Http\Controllers;

use App\Models\RuangPodcast;
use App\Models\TataTertib;
use App\Services\KalenderService;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function beranda(Request $request, KalenderService $kalender)
    {
        return view('guest.beranda', $kalender->susun($request) + [
            'tataTertib' => TataTertib::where('status_aktif', true)->orderBy('id')->get(),
        ]);
    }

    public function ruang(Request $request)
    {
        $ruang = RuangPodcast::withCount('fasilitas')
            ->when($request->q, fn ($q, $v) => $q->where('nama_ruang', 'like', "%{$v}%"))
            ->when($request->lokasi, fn ($q, $v) => $q->where('lokasi', $v))
            ->orderBy('nama_ruang')
            ->paginate(6)
            ->withQueryString();

        $lokasiList = RuangPodcast::orderBy('lokasi')->distinct()->pluck('lokasi');

        return view('guest.ruang', compact('ruang', 'lokasiList'));
    }

    public function show(RuangPodcast $ruang)
    {
        $ruang->load('fasilitas');

        return view('guest.ruang-detail', compact('ruang'));
    }
}