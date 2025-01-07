<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AjuanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $userIds = DB::table('users')->pluck('id'); // Get all user IDs from `users` table

        $statuses = [1, 2];  // Hanya status 1 dan 2
        $statusCounts = [1 => 0, 2 => 0]; // Inisialisasi jumlah status 1 dan 2

        // Generate 15 entries for the `ajuan` table
        for ($i = 1; $i <= 15; $i++) {
            // Pastikan ada 7 entri dengan status 1 dan 8 entri dengan status 2
            $status = $statusCounts[1] < 7 ? 1 : 2;
            $statusCounts[$status]++;

            // Generate random WhatsApp number starting with 08
            $whatsapp = '08' . $faker->unique()->numerify('##########');

            // Generate "Universitas" followed by a city name
            $asal = 'Universitas ' . $faker->city;

            // Generate date that is not on Saturday or Sunday
            $tanggal = $this->generateWeekdayDate('2025-01-01', '2025-01-31');

            // Generate time between 08:00 and 16:00 with random minutes
            $jam = $faker->dateTimeBetween('08:00:00', '16:00:00')->format('H') . ':' . $faker->randomElement(['00', '15', '30', '45']);

            DB::table('ajuan')->insert([
                'user_id' => $faker->randomElement($userIds),
                'nama' => $faker->name,
                'asal' => $asal, // Universitas City
                'whatsapp' => $whatsapp,
                'jumlah_orang' => $faker->numberBetween(10, 50),
                'jenis' => $faker->randomElement([1, 2]),
                'tanggal' => $tanggal,
                'jam' => $jam,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Function to generate a date between two dates that is not on a weekend
    private function generateWeekdayDate($startDate, $endDate)
    {
        $faker = Faker::create();
        $date = $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');

        // Loop until a weekday is found (not Saturday or Sunday)
        while (in_array(date('N', strtotime($date)), [6, 7])) {
            $date = $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
        }

        return $date;
    }
}
