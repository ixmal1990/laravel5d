<?php

namespace Database\Factories;

use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'payment_code' => 'PAY-' . strtoupper($this->faker->bothify('#####??')),
            'lease_id' => Lease::factory(),
            'period_month' => now()->format('Y-m'),
            'amount' => 1200000.00,
            'method' => $this->faker->randomElement(['cash', 'qris', 'bank_transfer', 'e_wallet']),
            'status' => 'paid',
            'paid_at' => now(),
        ];
    }
}
