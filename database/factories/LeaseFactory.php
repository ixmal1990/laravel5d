<?php

namespace Database\Factories;

use App\Models\Lease;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lease>
 */
class LeaseFactory extends Factory
{
    protected $model = Lease::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $endDate = (clone $startDate)->modify('+6 months');

        return [
            'lease_code' => 'LSE-' . strtoupper($this->faker->bothify('#####??')),
            'tenant_id' => User::factory()->state(['role' => 'tenant']),
            'room_id' => Room::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'monthly_rent_snapshot' => 1200000.00,
            'deposit_amount' => 500000.00,
            'status' => $this->faker->randomElement(['pending', 'active', 'completed', 'terminated']),
        ];
    }
}
