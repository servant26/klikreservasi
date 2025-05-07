<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AjuanSeeder extends Seeder
{
    public function run()
    {
        $userIds = DB::table('users')->pluck('id')->toArray(); // Ambil seluruh user_id

        $count = 0;
        while ($count < 100) {
            $tanggal = $this->getRandomWeekday();
            $dayName = Carbon::parse($tanggal)->format('l');

            // Tentukan jam berdasarkan hari
            $jamOptions = ['08:00:00', '08:15:00', '08:30:00', '08:45:00']; // Jam fix yang tersedia
            if (in_array($dayName, ['Monday', 'Tuesday', 'Wednesday', 'Thursday'])) {
                $jam = $jamOptions[array_rand($jamOptions)]; // Pilih jam secara acak dari opsi yang ada
            } elseif ($dayName == 'Friday') {
                $jam = $jamOptions[array_rand($jamOptions)]; // Pilih jam secara acak dari opsi yang ada
            } else {
                continue; // Skip Sabtu-Minggu
            }

            $jenis = rand(1, 2); // Jenis 1 atau 2

            DB::table('ajuan')->insert([
                'user_id' => $userIds[array_rand($userIds)], // Pilih user secara acak
                'jumlah_orang' => rand(1, 10), // Jumlah orang antara 1 hingga 10
                'jenis' => $jenis,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'status' => 2, // Set status selalu menjadi 2 (Sudah ditanggapi)
                'surat' => 'surat_' . Str::random(5) . '.pdf', // Surat acak
                'deskripsi' => $jenis == 1 
                    ? 'Ini deskripsi untuk reservasi pada tanggal ' . $tanggal 
                    : 'Ini deskripsi kunjungan biasa pada tanggal ' . $tanggal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $count++;
        }
    }

    private function getRandomWeekday()
    {
        do {
            $date = Carbon::create(2025, 1, 1)->addDays(rand(0, 364));
        } while (in_array($date->format('l'), ['Saturday', 'Sunday']));
        return $date->format('Y-m-d');
    }
}
