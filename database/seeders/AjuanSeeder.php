<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AjuanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Generate 50 rows of fake data
        foreach (range(1, 50) as $index) {
            // Random month between January (1) and April (4)
            $month = $faker->numberBetween(1, 4);
            // Generate a date in 2025, with random month from 1 to 4
            $tanggal = '2025-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($faker->numberBetween(1, 28), 2, '0', STR_PAD_LEFT);

            DB::table('ajuan')->insert([
                'nama' => $faker->name,
                'asal' => $faker->city,
                'whatsapp' => $faker->phoneNumber,
                'jenis' => $faker->randomElement([1, 2]),
                'tanggal' => $tanggal,
                'jam' => $faker->time,
                'status' => $faker->randomElement([1, 2, 3]),
            ]);
        }
    }
}



