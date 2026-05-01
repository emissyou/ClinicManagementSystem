<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::factory(),
            'receipt_number' => 'RCP-' . strtoupper(fake()->bothify('??####')),
            'reference' => 'REF-' . strtoupper(fake()->bothify('??####')),
            'amount' => fake()->randomFloat(2, 10, 250),
            'type' => fake()->randomElement(['payment', 'refund']),
            'status' => 'completed',
            'paid_at' => now(),
            'notes' => fake()->sentence(),
        ];
    }
}