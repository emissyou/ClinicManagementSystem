<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $start = Carbon::instance(fake()->dateTimeBetween('+1 day', '+7 days'));
        $end = (clone $start)->addMinutes(30);
        $additional = [
            ['name' => 'Lab Test', 'amount' => 25.00],
        ];

        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'service_type' => fake()->randomElement(['General Check-up', 'Specialist Consultation', 'Follow-up', 'Lab Test']),
            'start_time' => $start,
            'end_time' => $end,
            'status' => fake()->randomElement(['Pending', 'Confirmed', 'Completed', 'Cancelled']),
            'reason' => fake()->sentence(),
            'fee' => fake()->randomFloat(2, 50, 250),
            'additional_services' => $additional,
            'additional_services_total' => 25.00,
            'subtotal' => 75.00,
            'total_amount' => 75.00,
        ];
    }
}