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

        $statuses = [1, 2, 3];
        $statusCounts = array_fill_keys($statuses, 0);

        // Generate 10 entries for the `ajuan` table
        for ($i = 1; $i <= 10; $i++) {
            // Ensure 10 entries for each status
            $status = collect($statuses)->first(fn($s) => $statusCounts[$s] < 10);
            $statusCounts[$status]++;

            // Generate random WhatsApp number starting with 08
            $whatsapp = '08' . $faker->unique()->numerify('##########');

            DB::table('ajuan')->insert([
                'user_id' => $faker->randomElement($userIds),
                'nama' => $faker->name,
                'asal' => $faker->city,
                'whatsapp' => $whatsapp,
                'jumlah_orang' => $faker->numberBetween(10, 50),
                'jenis' => $faker->randomElement([1, 2]),
                'tanggal' => $faker->dateTimeBetween('2025-01-01', '2025-01-31')->format('Y-m-d'),
                'jam' => $faker->dateTimeBetween('08:00:00', '16:00:00')->format('H') . ':' . $faker->randomElement(['00', '15', '30', '45']),
                'status' => $faker->randomElement([1, 2]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
