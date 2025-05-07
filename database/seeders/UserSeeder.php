<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $cities = [
        'Jakarta',
        'Surabaya',
        'Bandung',
        'Medan',
        'Yogyakarta',
        'Semarang',
        'Makassar',
        'Palembang',
        'Denpasar',
        'Malang',
        'Tangerang',
        'Bekasi',
        'Depok',
        'Bogor',
        'Batam',
        'Bali',
        'Balikpapan',
        'Cirebon',
        'Makasar',
        'Padang',
        'Pontianak',
        'Samarinda',
        'Manado',
        'Pekanbaru',
        'Lampung'
    ];

    public function run()
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Staff
        DB::table('users')->insert([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 100 User Biasa
        for ($i = 1; $i <= 100; $i++) {
            $whatsapp = '+62' . rand(812, 859) . rand(1000000, 9999999); // Nomor WhatsApp Indonesia
            $asal = $this->cities[array_rand($this->cities)]; // Ambil asal kota dari daftar

            DB::table('users')->insert([
                'name' => 'User' . $i,
                'email' => $i . '@gmail.com',
                'whatsapp' => $whatsapp,
                'asal' => $asal,
                'role' => 'user',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
