<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Reservasi Podcast')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <a href="{{ route('beranda') }}" class="brand">
            <span class="logo">LOGO PCR</span>
            <strong>SISTEM RESERVASI PODCAST</strong>
        </a>
        <nav>
            @auth
                <a href="{{ route('dashboard') }}">Jadwal</a>
                <a href="{{ route('ruang.index') }}">Ruang</a>
                <a href="{{ route('reservations.index') }}">Reservasi Saya</a>
                <details class="user-menu">
                    <summary>{{ auth()->user()->name }} ▾</summary>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </details>
            @else
                <a href="{{ route('beranda') }}">Jadwal</a>
                <a href="{{ route('ruang.index') }}">Ruang</a>
                <a href="{{ route('login') }}" class="nav-login">Masuk</a>
            @endauth
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>