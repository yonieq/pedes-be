<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'is_admin' => true,
                'password' => Hash::make('password'),
                'NIK' => '1234567890123456',
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'is_admin' => false,
                'password' => Hash::make('password'),
                'NIK' => $faker->unique()->numberBetween(1000000000000000, 9999999999999999),
            ]);
        }
    }
}