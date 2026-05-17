<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'Standard',
                'description' => 'Cozy room for quick stays and solo travelers.',
            ],
            [
                'name' => 'Deluxe',
                'description' => 'Spacious room with premium amenities and city views.',
            ],
            [
                'name' => 'Suite',
                'description' => 'Separate living space ideal for families or longer stays.',
            ],
            [
                'name' => 'Conference',
                'description' => 'Meeting-ready room equipped for small teams.',
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
