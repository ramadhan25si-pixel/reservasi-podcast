@extends('layouts.app')

@section('title', $ruang->nama_ruang)

@section('content')
<a href="{{ route('ruang.index') }}" class="btn-sm">&lt; Kembali</a>

<h2 style="margin-top:16px;">{{ $ruang->nama_ruang }}</h2>
<p class="meta">{{ $ruang->lokasi }}, kapasitas {{ $ruang->kapasitas }} orang</p>
<p><x-slot-badge :status="$ruang->status_ruang" /></p>
<p>{{ $ruang->deskripsi ?? 'Belum ada deskripsi.' }}</p>

<h3>Fasilitas</h3>
<div class="table-wrap">
    <table class="calendar">
        <thead>
            <tr><th>Nama fasilitas</th><th>Jumlah</th><th>Kondisi</th></tr>
        </thead>
        <tbody>
            @forelse ($ruang->fasilitas as $f)
                <tr>
                    <td>{{ $f->nama_fasilitas }}</td>
                    <td>{{ $f->jumlah }}</td>
                    <td>{{ ucfirst($f->kondisi) }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Belum ada data fasilitas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@auth
    <a href="{{ route('reservations.create') }}" class="btn-primary">+ AJUKAN RESERVASI</a>
@else
    <a href="{{ route('login') }}" class="btn-primary">MASUK UNTUK MENGAJUKAN RESERVASI</a>
@endauth
@endsection