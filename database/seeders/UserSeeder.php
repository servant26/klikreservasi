<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private $instansi = [
        // TK
        'TK Kartika Samarinda',
        'TK Negeri Pembina Samarinda',
        'TK Islam Al-Azhar Samarinda',
        'TK Al-Fath Samarinda',
        'TK Al-Kautsar Samarinda',

        // SD
        'SD Negeri 1 Samarinda',
        'SD Negeri 2 Samarinda',
        'SD Islam Al-Azhar 25 Samarinda',
        'SD Muhammadiyah 1 Samarinda',
        'SD Kristen Kalam Kudus Samarinda',

        // SMP
        'SMP Negeri 1 Samarinda',
        'SMP Negeri 2 Samarinda',
        'SMP Islam Al-Azhar 25 Samarinda',
        'SMP Muhammadiyah 1 Samarinda',
        'SMP Kristen Kalam Kudus Samarinda',

        // SMA / SMK / MA
        'SMA Negeri 1 Samarinda',
        'SMA Negeri 2 Samarinda',
        'SMK Negeri 1 Samarinda',
        'SMA Islam Al-Azhar 25 Samarinda',
        'MA Negeri 1 Samarinda',

        // Universitas
        'Universitas Mulawarman',
        'Politeknik Negeri Samarinda',
        'Universitas Muhammadiyah Kalimantan Timur',
        'STMIK SPB Airlangga Samarinda',
        'STIE Samarinda',

        // Instansi Pemerintahan
        'Dinas Kesehatan Kota Samarinda',
        'Dinas Pendidikan Kota Samarinda',
        'Dinas Perhubungan Kota Samarinda',
        'Dinas Pekerjaan Umum Kota Samarinda',
        'Dinas Sosial Kota Samarinda',
        'Dinas Pemuda dan Olahraga Kota Samarinda',
        'Dinas Lingkungan Hidup Kota Samarinda',
        'Badan Perencanaan Pembangunan Daerah Kota Samarinda',
        'Badan Kepegawaian Daerah Kota Samarinda'
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
            // Nomor WhatsApp dimulai dengan 08
            $whatsapp = '08' . rand(11, 58) . rand(1000000, 9999999); 
            $asal = $this->instansi[array_rand($this->instansi)]; // Pilih asal instansi dari daftar

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
