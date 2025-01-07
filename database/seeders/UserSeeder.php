<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Insert Admin and Staff users
        DB::table('users')->insert([
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'staff',
            ]
        ]);

        // Insert 10 random users
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'nama' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
