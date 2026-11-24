@extends('layouts.app')

@section('title', 'Daftar Ruang Podcast')

@section('content')
<h2>DAFTAR RUANG PODCAST</h2>

<form method="GET" action="{{ route('ruang.index') }}" class="search">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama ruang...">
    <select name="lokasi">
        <option value="">Semua Lokasi</option>
        @foreach ($lokasiList as $lok)
            <option value="{{ $lok }}" @selected(request('lokasi') == $lok)>{{ $lok }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-sm">Cari</button>
</form>

<div class="grid">
    @forelse ($ruang as $r)
        <div class="card">
            <h3>{{ $r->nama_ruang }}</h3>
            <p class="meta">{{ $r->lokasi }}, kapasitas {{ $r->kapasitas }} orang</p>
            <p class="meta">{{ $r->fasilitas_count }} jenis fasilitas</p>
            <p><x-slot-badge :status="$r->status_ruang" /></p>
            <a class="btn-sm" href="{{ route('ruang.show', $r) }}">Lihat detail</a>
        </div>
    @empty
        <p>Tidak ada ruang yang cocok dengan pencarian.</p>
    @endforelse
</div>

@if ($ruang->hasPages())
    <div class="pager-bottom">
        @if ($ruang->onFirstPage())
            <span class="btn-sm disabled">&lt;</span>
        @else
            <a class="btn-sm" href="{{ $ruang->previousPageUrl() }}">&lt;</a>
        @endif

        <span>Halaman {{ $ruang->currentPage() }} dari {{ $ruang->lastPage() }}</span>

        @if ($ruang->hasMorePages())
            <a class="btn-sm" href="{{ $ruang->nextPageUrl() }}">&gt;</a>
        @else
            <span class="btn-sm disabled">&gt;</span>
        @endif
    </div>
@endif
@endsection