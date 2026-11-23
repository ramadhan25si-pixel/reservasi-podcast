<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    User::updateOrCreate(
        ['email' => 'mahasiswa@pcr.ac.id'],
        ['name' => 'Farrel', 'nim' => '2557301075', 'password' => Hash::make('12345678'), 'role' => 'mahasiswa']
    );

    User::updateOrCreate(
        ['email' => 'admin@pcr.ac.id'],
        ['name' => 'Admin PCR', 'password' => Hash::make('12345678'), 'role' => 'admin']
    );

    $this->call(RuangPodcastSeeder::class);
}
}