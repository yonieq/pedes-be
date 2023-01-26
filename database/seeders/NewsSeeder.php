<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
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
            News::create([
                'title' => $faker->sentence,
                'category_news_id' => $faker->numberBetween(1, 10),
                'description' => $faker->paragraph,
                'is_active' => $faker->boolean,
                'image' => $faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            ]);
        }
    }
}