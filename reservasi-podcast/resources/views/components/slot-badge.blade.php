@props(['status' => 'tersedia', 'free' => null])

@php
    $map = [
        'tersedia'    => ['TERSEDIA', 'badge-free'],
        'disetujui'   => ['BOOKED', 'badge-booked'],
        'pending'     => ['PENDING', 'badge-pending'],
        'maintenance' => ['MAINTENANCE', 'badge-maint'],
    ];
    [$label, $class] = $map[$status] ?? $map['tersedia'];
@endphp

<span class="badge {{ $class }}">{{ $label }}</span>
@if ($status === 'tersedia' && $free !== null)
    <small class="muted">{{ $free }} ruang kosong</small>
@endif
