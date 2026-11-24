<div class="toolbar">
    <form method="GET" action="{{ url()->current() }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
        <label for="ruang">Filter Ruangan:</label>
        <select name="ruang" id="ruang" onchange="this.form.submit()">
            <option value="">All Ruang</option>
            @foreach ($semuaRuang as $r)
                <option value="{{ $r->id }}" @selected(request('ruang') == $r->id)>{{ $r->nama_ruang }}</option>
            @endforeach
        </select>

        <label for="lokasi">Lokasi:</label>
        <select name="lokasi" id="lokasi" onchange="this.form.submit()">
            <option value="">Semua Lokasi</option>
            @foreach ($lokasiList as $lok)
                <option value="{{ $lok }}" @selected(request('lokasi') == $lok)>{{ $lok }}</option>
            @endforeach
        </select>

        <label for="start">Tanggal:</label>
        <input type="date" name="start" id="start" value="{{ request('start') }}" onchange="this.form.submit()">
    </form>

    <div class="pager">
        <a class="btn-sm" href="{{ url()->current() }}?{{ http_build_query(array_filter(['start' => $prevStart, 'ruang' => request('ruang'), 'lokasi' => request('lokasi')])) }}">&lt;</a>
        <strong>{{ $monthLabel }}</strong>
        <a class="btn-sm" href="{{ url()->current() }}?{{ http_build_query(array_filter(['start' => $nextStart, 'ruang' => request('ruang'), 'lokasi' => request('lokasi')])) }}">&gt;</a>
    </div>
</div>

<div class="table-wrap">
    <table class="calendar">
        <thead>
            <tr>
                @foreach ($days as $day)
                    <th>{{ $day->locale('id')->translatedFormat('l') }} ({{ $day->format('d/m') }})</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($slots as $slot)
                <tr>
                    @foreach ($days as $day)
                        @php $cell = $cells[$day->toDateString()][$slot['start']]; @endphp
                        <td>
                            <div class="time">{{ $slot['start'] }} - {{ $slot['end'] }}</div>
                            <x-slot-badge :status="$cell['status']" :free="$cell['free']" />
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@auth
    <a href="{{ route('reservations.create') }}" class="btn-primary">+ AJUKAN RESERVASI RUANG PODCAST</a>
@else
    <a href="{{ route('login') }}" class="btn-primary">MASUK UNTUK MENGAJUKAN RESERVASI</a>
@endauth