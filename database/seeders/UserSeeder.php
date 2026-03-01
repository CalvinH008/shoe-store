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
                'address' => 'jalan mangga 1',
                'phone_number' => '081234567890',
                'role' => 'admin',
                'is_active' => true,
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'user',
                'email' => 'user@test.com',
                'address' => 'jalan mangga 2',
                'phone_number' => '089876543210',
                'role' => 'user',
                'is_active' => true,
                'password' => Hash::make('user123'),
            ]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
