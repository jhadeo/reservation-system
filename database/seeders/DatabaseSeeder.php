<?php

namespace Database\Seeders;

use App\AccountType;
use App\Models\User;
use Database\Seeders\RoomSeeder;
use Database\Seeders\RoomTypeSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'phone' => '09170000001',
            'email' => 'admin@example.com',
            'password' => 'password',
            'account_type' => AccountType::Admin,
        ]);

        User::create([
            'first_name' => 'Reservation',
            'last_name' => 'Staff',
            'phone' => '09170000002',
            'email' => 'staff@example.com',
            'password' => 'password',
            'account_type' => AccountType::Staff,
        ]);
        User::create([
            'first_name' => 'Hotel',
            'last_name' => 'Client',
            'phone' => '09170000003',
            'email' => 'client@example.com',
            'password' => 'password',
            'account_type' => AccountType::Client,
        ]);

        // $this->call([
        //     RoomTypeSeeder::class,
        //     RoomSeeder::class,
        // ]);
    }
}
