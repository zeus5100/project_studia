<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => '101',
                'capacity' => 30,
                'description' => 'Sala języka polskiego',
            ],
            [
                'room_number' => '102',
                'capacity' => 25,
                'description' => 'Sala komputerowa',
            ],
            [
                'room_number' => '103',
                'capacity' => 20,
                'description' => 'Sala konferencyjna',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
