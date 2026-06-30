<?php

namespace Database\Seeders;

use App\AccountType;
use App\Models\User;
use App\RegistrationSource;
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

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'System',
                'last_name' => 'Admin',
                'phone' => '09170000001',
                'password' => 'password',
                'account_type' => AccountType::Admin,
                'registration_source' => RegistrationSource::Self,
            ]
        );

        $admin->update(['created_by' => $admin->id]);

        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'first_name' => 'Reservation',
                'last_name' => 'Staff',
                'phone' => '09170000002',
                'password' => 'password',
                'account_type' => AccountType::Staff,
                'registration_source' => RegistrationSource::Admin,
                'created_by' => $admin->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'client@example.com'],
            [
                'first_name' => 'Hotel',
                'last_name' => 'Client',
                'phone' => '09170000003',
                'password' => 'password',
                'account_type' => AccountType::Client,
                'registration_source' => RegistrationSource::Self,
                'created_by' => $admin->id,
            ]
        );

        $this->call([
            RoomTypeSeeder::class,
            RoomSeeder::class,
        ]);
    }
}
