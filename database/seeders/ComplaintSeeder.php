<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            Complaint::create([
                'title' => $faker->sentence,
                'category_complaint_id' => $faker->numberBetween(1, 10),
                'description' => $faker->paragraph,
                'status' => 'Waiting',
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'user_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}