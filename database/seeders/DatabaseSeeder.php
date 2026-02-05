<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);
        $customerRole = Role::query()->firstOrCreate(['name' => 'customer']);

        User::query()->firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'role_id' => $adminRole->id,
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test Customer',
                'role_id' => $customerRole->id,
                'password' => Hash::make('password'),
            ]
        );

        // Seed clothing products
        $this->call(ClothingSeeder::class);
    }
}
