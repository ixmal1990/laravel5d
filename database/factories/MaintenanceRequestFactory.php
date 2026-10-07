<?php

namespace Database\Factories;

use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceRequest>
 */
class MaintenanceRequestFactory extends Factory
{
    protected $model = MaintenanceRequest::class;

    public function definition(): array
    {
        return [
            'ticket_code' => 'TCK-' . strtoupper($this->faker->bothify('#####??')),
            'room_id' => Room::factory(),
            'tenant_id' => User::factory()->state(['role' => 'tenant']),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved']),
            'resolved_at' => null,
        ];
    }
}
