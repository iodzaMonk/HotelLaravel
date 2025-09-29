<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $hotel = new Hotel;
            $hotel->hotel_name = $faker->name;
            $hotel->hotel_address = $faker->address;
            $hotel->save();
        }
    }
}