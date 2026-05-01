<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Doctor>
 */
class DoctorFactory extends Factory
{
    public function definition(): array
    {
        $days = fake()->randomElements(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], fake()->numberBetween(3, 6));

        return [
            'name' => fake()->name(),
            'specialization' => fake()->randomElement(['General Physician', 'Dentist', 'Cardiologist', 'Pediatrician']),
            'consultation_fee' => fake()->randomFloat(2, 50, 250),
            'qualifications' => fake()->sentence(),
            'clinic_assignment' => fake()->randomElement(['Main Clinic', 'Wing A', 'Wing B']),
            'available_days' => $days,
            'available_start_time' => '09:00',
            'available_end_time' => '17:00',
            'schedule_notes' => fake()->sentence(),
        ];
    }
}