<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Console;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Console>
 */
class ConsoleFactory extends Factory
{
    protected $model = Console::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'serial_number' => 'PS-' . strtoupper($this->faker->bothify('??###??')),
            'name' => 'Console Unit ' . $this->faker->numberBetween(1, 99),
            'status' => $this->faker->randomElement(['available', 'rented', 'maintenance']),
            'daily_rate' => $this->faker->randomElement([50000.00, 75000.00, 100000.00, 150000.00]),
            'condition' => $this->faker->randomElement(['excellent', 'good', 'fair']),
        ];
    }
}
