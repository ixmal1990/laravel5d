<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    protected $model = Rental::class;

    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('-1 month', 'now');
        $endTime = (clone $startTime)->modify('+2 days');

        return [
            'rental_code' => 'RNT-' . strtoupper($this->faker->bothify('#####??')),
            'user_id' => User::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'total_price' => $this->faker->randomElement([100000.00, 150000.00, 200000.00, 300000.00]),
            'deposit_amount' => 50000.00,
            'status' => $this->faker->randomElement(['pending', 'active', 'completed', 'late', 'cancelled']),
        ];
    }
}
