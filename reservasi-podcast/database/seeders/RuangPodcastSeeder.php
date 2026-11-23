<?php

namespace Database\Seeders;

use App\Models\Reservasi;
use App\Models\RuangPodcast;
use App\Models\TataTertib;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RuangPodcastSeeder extends Seeder
{
    public function run(): void
    {
        $studio1 = RuangPodcast::create([
            'nama_ruang' => 'Ruang Podcast Studio 1', 'lokasi' => 'Gedung PCR Lantai 1', // sesuaikan
            'kapasitas' => 4, 'deskripsi' => 'Studio podcast utama.', 'status_ruang' => 'tersedia',
        ]);
        $studio2 = RuangPodcast::create([
            'nama_ruang' => 'Ruang Podcast Studio 2', 'lokasi' => 'Gedung PCR Lantai 2', // sesuaikan
            'kapasitas' => 6, 'deskripsi' => 'Studio podcast tambahan.', 'status_ruang' => 'maintenance',
        ]);

        // Jumlah stok sesuaikan dengan kondisi sebenarnya
        foreach ([['Mic Podcast', 4], ['Headset Studio', 4], ['Clip-on Wireless', 2],
                  ['Lighting Softbox', 1], ['Camera Mirrorless', 1]] as [$nama, $jumlah]) {
            $studio1->fasilitas()->create(['nama_fasilitas' => $nama, 'jumlah' => $jumlah, 'kondisi' => 'baik']);
        }

        foreach ([
            'Menjaga kebersihan dan dilarang membawa makanan/minuman ke meja alat.',
            'Wajib melakukan unggah foto kondisi ruangan SEBELUM & SESUDAH dipakai.',
            'Pengguna bertanggung jawab penuh atas kerusakan/kehilangan alat.',
        ] as $i => $isi) {
            TataTertib::create(['judul_aturan' => 'Aturan ' . ($i + 1), 'isi_aturan' => $isi]);
        }

        $mhs = User::where('email', 'mahasiswa@pcr.ac.id')->first();
        $senin = now()->isWeekend() ? now()->next(Carbon::MONDAY) : now()->startOfWeek();

        Reservasi::create([
            'user_id' => $mhs->id, 'ruang_id' => $studio1->id,
            'tanggal_reservasi' => $senin->copy()->addDay(),
            'waktu_mulai' => '08:00', 'waktu_selesai' => '10:00',
            'keperluan' => 'Project MK Komunikasi Digital - Wawancara', 'status_reservasi' => 'disetujui',
        ]);
        Reservasi::create([
            'user_id' => $mhs->id, 'ruang_id' => $studio1->id,
            'tanggal_reservasi' => $senin->copy()->addDays(2),
            'waktu_mulai' => '10:00', 'waktu_selesai' => '12:00',
            'keperluan' => 'Rekaman podcast kelompok', 'status_reservasi' => 'pending',
        ]);
    }
}