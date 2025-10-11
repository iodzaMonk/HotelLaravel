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
        return [
            'room_number' => fake()->unique()->numberBetween(100, 999),
            'room_type' => fake()->randomElement(['Single', 'Double', 'Suite', 'Deluxe']),
            'price_per_night' => fake()->numberBetween(80, 500),
        ];
    }

    public function forHotel(?Hotel $hotel = null): static
    {
        return $this->for($hotel ?? Hotel::factory());
    }
}
