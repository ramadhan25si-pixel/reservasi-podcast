<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $a = Room::create(['name' => 'Podcast Room A', 'capacity' => 4]);
        $b = Room::create(['name' => 'Podcast Room B', 'capacity' => 6]);

        $monday = now()->isWeekend() ? now()->next(Carbon::MONDAY) : now()->startOfWeek();

        Reservation::create([
            'room_id' => $a->id, 'date' => $monday->copy()->addDay(),
            'start_time' => '08:00', 'end_time' => '10:00', 'status' => 'approved',
        ]);
        Reservation::create([
            'room_id' => $b->id, 'date' => $monday->copy()->addDay(),
            'start_time' => '08:00', 'end_time' => '10:00', 'status' => 'approved',
        ]);
        Reservation::create([
            'room_id' => $a->id, 'date' => $monday->copy()->addDays(3),
            'start_time' => '08:00', 'end_time' => '10:00', 'status' => 'maintenance',
        ]);
        Reservation::create([
            'room_id' => $a->id, 'date' => $monday->copy()->addDays(2),
            'start_time' => '10:00', 'end_time' => '12:00', 'status' => 'pending',
        ]);
    }
}