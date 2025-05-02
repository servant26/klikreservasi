<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AjuanSeeder extends Seeder
{
    public function run()
    {
        $userIds = DB::table('users')->pluck('id')->toArray();

        $count = 0;
        while ($count < 100) {
            $tanggal = $this->getRandomWeekday();
            $dayName = Carbon::parse($tanggal)->format('l');

            // Tentukan jam berdasarkan hari
            if (in_array($dayName, ['Monday', 'Tuesday', 'Wednesday', 'Thursday'])) {
                $jam = Carbon::createFromTime(rand(8, 15), rand(0, 59))->format('H:i:s');
            } elseif ($dayName == 'Friday') {
                $jam = Carbon::createFromTime(rand(8, 14), rand(0, 59))->format('H:i:s');
            } else {
                continue; // skip Sabtu-Minggu
            }

            $jenis = rand(1, 2);

            DB::table('ajuan')->insert([
                'user_id' => $userIds[array_rand($userIds)],
                'jumlah_orang' => rand(1, 10),
                'jenis' => $jenis,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'status' => rand(1, 3),
                'surat' => 'surat_' . Str::random(5) . '.pdf',
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
