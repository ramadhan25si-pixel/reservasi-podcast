@extends('layouts.app')

@section('title', 'Jadwal Ruang Podcast PCR')

@section('content')
<h2>KALENDER KETERSEDIAAN RUANG PODCAST</h2>
<p class="meta">Jadwal bisa dilihat tanpa login. Masuk dengan akun kampus untuk mengajukan reservasi.</p>

@include('partials.kalender')

@if ($tataTertib->isNotEmpty())
    <h3 style="margin-top:32px;">TATA TERTIB PENGGUNAAN RUANG PODCAST</h3>
    <ol class="aturan">
        @foreach ($tataTertib as $aturan)
            <li>{{ $aturan->isi_aturan }}</li>
        @endforeach
    </ol>
@endif
@endsection