<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@test.com',
                'role' => 'admin',
                'is_active' => true,
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'user',
                'email' => 'user@test.com',
                'role' => 'user',
                'is_active' => true,
                'password' => Hash::make('user123'),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
