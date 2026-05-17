<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $typeIds = RoomType::query()->pluck('id', 'name');

        $rooms = [
            [
                'name' => 'Standard 101',
                'hourly_rate' => 25.00,
                'max_pax' => 2,
                'is_available' => true,
                'room_type_id' => $typeIds['Standard'] ?? null,
                'description' => 'Simple and quiet room with a queen bed.',
                'photo' => null,
            ],
            [
                'name' => 'Standard 102',
                'hourly_rate' => 25.00,
                'max_pax' => 2,
                'is_available' => true,
                'room_type_id' => $typeIds['Standard'] ?? null,
                'description' => 'Budget-friendly room with desk space.',
                'photo' => null,
            ],
            [
                'name' => 'Deluxe 201',
                'hourly_rate' => 40.00,
                'max_pax' => 3,
                'is_available' => true,
                'room_type_id' => $typeIds['Deluxe'] ?? null,
                'description' => 'Larger room with lounge chair and minibar.',
                'photo' => null,
            ],
            [
                'name' => 'Deluxe 202',
                'hourly_rate' => 42.50,
                'max_pax' => 3,
                'is_available' => false,
                'room_type_id' => $typeIds['Deluxe'] ?? null,
                'description' => 'Corner room with extra daylight.',
                'photo' => null,
            ],
            [
                'name' => 'Suite 301',
                'hourly_rate' => 65.00,
                'max_pax' => 4,
                'is_available' => true,
                'room_type_id' => $typeIds['Suite'] ?? null,
                'description' => 'Suite with living area and work desk.',
                'photo' => null,
            ],
            [
                'name' => 'Conference A',
                'hourly_rate' => 80.00,
                'max_pax' => 10,
                'is_available' => true,
                'room_type_id' => $typeIds['Conference'] ?? null,
                'description' => 'Boardroom-style space with projector.',
                'photo' => null,
            ],
        ];

        foreach ($rooms as $room) {
            if ($room['room_type_id'] === null) {
                continue;
            }

            Room::create($room);
        }
    }
}
