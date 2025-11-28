<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'suryaputra24si@pcr.ac.id',
            'password' => Hash::make('suryaputra24si'),
        ]);

        // Create additional dummy users for pagination testing
        for ($i = 2; $i <= 15; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
