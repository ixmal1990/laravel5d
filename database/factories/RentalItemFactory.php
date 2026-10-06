<?php

namespace Database\Factories;

use App\Models\Console;
use App\Models\Rental;
use App\Models\RentalItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RentalItem>
 */
class RentalItemFactory extends Factory
{
    protected $model = RentalItem::class;

    public function definition(): array
    {
        $rate = $this->faker->randomElement([50000.00, 75000.00, 100000.00]);
        $days = $this->faker->numberBetween(1, 3);
        return [
            'rental_id' => Rental::factory(),
            'console_id' => Console::factory(),
            'duration_days' => $days,
            'daily_rate_snapshot' => $rate,
            'subtotal' => $rate * $days,
            'late_fee' => 0.00,
        ];
    }
}
