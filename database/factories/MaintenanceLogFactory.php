<?php

namespace Database\Factories;

use App\Models\Console;
use App\Models\MaintenanceLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceLog>
 */
class MaintenanceLogFactory extends Factory
{
    protected $model = MaintenanceLog::class;

    public function definition(): array
    {
        return [
            'console_id' => Console::factory(),
            'service_date' => $this->faker->date(),
            'technician_name' => $this->faker->name(),
            'cost' => $this->faker->randomElement([50000.00, 150000.00, 250000.00]),
            'issue_description' => $this->faker->sentence(),
            'action_taken' => $this->faker->sentence(),
        ];
    }
}
