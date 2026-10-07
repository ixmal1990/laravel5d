<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'room_number' => 'Room ' . strtoupper($this->faker->bothify('?-###')),
            'room_type' => $this->faker->randomElement(['Deluxe AC', 'Standard Fan', 'VIP Balcony']),
            'monthly_rate' => $this->faker->randomElement([800000.00, 1200000.00, 1500000.00, 2000000.00]),
            'status' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
            'size_m2' => $this->faker->numberBetween(12, 24),
        ];
    }
}
