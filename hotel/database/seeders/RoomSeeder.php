<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Hotel;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $hotels = Hotel::all()->pluck('id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            Room::create([
                'room_nb' => $faker->randomNumber(),
                'room_type' => $faker->monthName(),
                'hotel_id' => $faker->randomElement($hotels),
            ]);
        }
    }
}