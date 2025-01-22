<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role_id' => 1,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user1',
                'email' => 'user1@example.com',
                'role_id' => 2,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user2',
                'email' => 'user2@example.com',
                'role_id' => 2,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user3',
                'email' => 'user3@example.com',
                'role_id' => 2,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'user4',
                'email' => 'user4@example.com',
                'role_id' => 2,
                'password' => Hash::make('password'),
            ],
        ];
        foreach ($user as $user) {
            User::create($user);
        }
    }
}
