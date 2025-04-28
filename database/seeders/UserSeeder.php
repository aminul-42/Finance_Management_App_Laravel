<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'profile_picture' => 'profile_pictures/alice.jpg',
        ]);

        User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'profile_picture' => 'profile_pictures/bob.jpg',
        ]);
    }
}