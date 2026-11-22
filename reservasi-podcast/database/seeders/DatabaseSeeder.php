<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Mahasiswa
        User::updateOrCreate(
            ['email' => 'mahasiswa@pcr.ac.id'],
            [
                'name' => 'Mahasiswa PCR',
                'password' => Hash::make('12345678'),
                //'role' => 'mahasiswa', // Hapus tanda // jika di tabel users ada kolom role
            ]
        );

        // Akun Dosen
        User::updateOrCreate(
            ['email' => 'dosen@pcr.ac.id'],
            [
                'name' => 'Dosen PCR',
                'password' => Hash::make('12345678'),
                //'role' => 'dosen', // Hapus tanda // jika di tabel users ada kolom role
            ]
        );
        $this->call(RoomSeeder::class);
    }
}