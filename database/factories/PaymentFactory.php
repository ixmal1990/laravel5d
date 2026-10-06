<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Rental;
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
            'rental_id' => Rental::factory(),
            'method' => $this->faker->randomElement(['cash', 'qris', 'bank_transfer', 'e_wallet']),
            'amount' => $this->faker->randomElement([100000.00, 150000.00, 200000.00]),
            'status' => 'paid',
            'paid_at' => now(),
        ];
    }
}
