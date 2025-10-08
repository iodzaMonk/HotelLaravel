<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hotels = Hotel::all()->pluck('id')->toArray();
        return [
            'room_nb' => fake()->randomNumber(),
            'room_type' => fake()->name(),
            'hotel_id' => fake()->randomElement($hotels),
        ];
    }
}