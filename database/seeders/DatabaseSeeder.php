<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama' => 'revitalis',
            'username' => 'refi',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Waiter',
            'username' => 'waiter',
            'password' => Hash::make('12345678'),
            'role' => 'waiter',
        ]);

        User::create([
            'nama' => 'Kasir',
            'username' => 'kasir',
            'password' => Hash::make('12345678'),
            'role' => 'kasir',
        ]);

        User::create([
            'nama' => 'Owner',
            'username' => 'owner',
            'password' => Hash::make('12345678'),
            'role' => 'owner',
        ]);
    }
}
