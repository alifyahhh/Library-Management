<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Librarian (admin)
        User::updateOrCreate(
            ['email' => 'librarian@demo.com'],
            [
                'name' => 'Librarian Demo',
                'password' => Hash::make('password'),
                'role' => 'librarian',
            ]
        );

        // Member 1
        User::updateOrCreate(
            ['email' => 'member1@demo.com'],
            [
                'name' => 'Member One',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );

        // Member 2
        User::updateOrCreate(
            ['email' => 'member2@demo.com'],
            [
                'name' => 'Member Two',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );
    }
}
