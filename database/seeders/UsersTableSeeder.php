<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample user data
        $users = [
            [
                'name' => 'DONI',
                'email' => 'doni@mail.com',
                'password' => Hash::make('123456'),
                'nip' => '1234',
                'jabatan' => 'DIREKTUR',
                'role' => 'direktur'
            ],
            [
                'name' => 'DONO',
                'email' => 'dono@mail.com',
                'password' => Hash::make('123456'),
                'nip' => '1235',
                'jabatan' => 'FINANCE',
                'role' => 'finance'
            ],
            [
                'name' => 'DONA',
                'email' => 'dona@mail.com',
                'password' => Hash::make('123456'),
                'nip' => '1236',
                'jabatan' => 'STAFF',
                'role' => 'staff'
            ],
        ];

        // Create users using the data array
        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
