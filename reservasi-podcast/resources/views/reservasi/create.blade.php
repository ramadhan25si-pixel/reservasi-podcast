@extends('layouts.app')

@section('title', 'Form Reservasi')

@section('content')
<h2>FORM PENGAJUAN RESERVASI RUANG PODCAST</h2>

@if ($errors->any())
    <div class="alert-error">
        <strong>Periksa kembali isian Anda:</strong>
        <ul>
            @foreach ($errors->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('reservations.store') }}" class="form">
    @csrf

    <div class="row">
        <label for="ruang_id">Pilih Ruangan</label>
        <select name="ruang_id" id="ruang_id" required>
            <option value="">-- Pilih ruangan --</option>
            @foreach ($ruang as $r)
                <option value="{{ $r->id }}" @selected(old('ruang_id') == $r->id)>{{ $r->nama_ruang }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <label for="tanggal_reservasi">Tanggal Reservasi</label>
        <input type="date" name="tanggal_reservasi" id="tanggal_reservasi"
               min="{{ now()->toDateString() }}" value="{{ old('tanggal_reservasi') }}" required>
    </div>

    <div class="row">
        <label>Waktu / Slot Jam</label>
        <div class="inline">
            <span>Waktu Mulai</span>
            <select name="waktu_mulai" required>
                @foreach ($jam as $j)
                    <option value="{{ $j }}" @selected(old('waktu_mulai', '09:00') == $j)>{{ $j }}</option>
                @endforeach
            </select>
            <span>s/d Waktu Selesai</span>
            <select name="waktu_selesai" required>
                @foreach ($jam as $j)
                    <option value="{{ $j }}" @selected(old('waktu_selesai', '11:00') == $j)>{{ $j }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <label for="keperluan">Keperluan</label>
        <input type="text" name="keperluan" id="keperluan" maxlength="255"
               placeholder="Contoh: Project MK Komunikasi Digital - Wawancara"
               value="{{ old('keperluan') }}" required>
    </div>

    <div class="box">
        <strong>PILIH FASILITAS TAMBAHAN:</strong>
        <p class="meta" id="fas-info">Pilih ruangan untuk melihat fasilitas yang tersedia.</p>
        <div class="fas-list">
            @foreach ($fasilitas as $f)
                <label class="fas" data-ruang="{{ $f->ruang_id }}">
                    <input type="checkbox" class="fas-cek" @checked(old('fasilitas.' . $f->id) !== null)>
                    {{ $f->nama_fasilitas }} (stok {{ $f->jumlah }}) Qty:
                    <input type="number" class="fas-qty" name="fasilitas[{{ $f->id }}]"
                           min="1" max="{{ $f->jumlah }}" value="{{ old('fasilitas.' . $f->id, 1) }}" disabled>
                </label>
            @endforeach
        </div>
    </div>

    <div class="box">
        <strong>TATA TERTIB PENGGUNAAN RUANG PODCAST</strong>
        <ol class="aturan">
            @foreach ($tataTertib as $aturan)
                <li>{{ $aturan->isi_aturan }}</li>
            @endforeach
        </ol>
    </div>

    <label class="setuju">
        <input type="checkbox" name="setuju" value="1" @checked(old('setuju'))>
        Saya telah membaca, memahami, dan menyetujui seluruh tata tertib di atas.
    </label>

    <div class="aksi">
        <a href="{{ route('dashboard') }}" class="btn-sm">Batal</a>
        <button type="submit" class="btn-primary" style="margin-top:0; border:0; cursor:pointer;">Kirim Reservasi</button>
    </div>
</form>

<script>
    const ruang = document.getElementById('ruang_id');
    const items = document.querySelectorAll('.fas');
    const info  = document.getElementById('fas-info');

    function aturFasilitas() {
        let ada = false;
        items.forEach(el => {
            const cocok = ruang.value !== '' && el.dataset.ruang === ruang.value;
            const cek = el.querySelector('.fas-cek');
            const qty = el.querySelector('.fas-qty');
            el.style.display = cocok ? '' : 'none';
            if (!cocok) cek.checked = false;
            qty.disabled = !(cocok && cek.checked);
            if (cocok) ada = true;
        });
        info.style.display = ada ? 'none' : '';
        info.textContent = ruang.value === ''
            ? 'Pilih ruangan untuk melihat fasilitas yang tersedia.'
            : 'Belum ada fasilitas untuk ruang ini.';
    }

    ruang.addEventListener('change', aturFasilitas);
    items.forEach(el => el.querySelector('.fas-cek').addEventListener('change', aturFasilitas));
    aturFasilitas();
</script>
@endsection