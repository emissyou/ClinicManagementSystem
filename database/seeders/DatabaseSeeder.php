<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $patients = Patient::factory()->count(10)->create();
        $doctors = Doctor::factory()->count(5)->create();

        $appointments = collect();
        foreach (range(1, 12) as $i) {
            $consultationFee = fake()->randomFloat(2, 50, 250);
            $serviceAmount = 25.00;
            $totalAmount = $consultationFee + $serviceAmount;

            $appointments->push(Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'service_type' => fake()->randomElement(['General Check-up', 'Specialist Consultation', 'Follow-up', 'Lab Test']),
                'start_time' => now()->addDays($i)->setHour(9 + ($i % 6))->setMinute(0),
                'end_time' => now()->addDays($i)->setHour(9 + ($i % 6))->setMinute(30),
                'status' => fake()->randomElement(['Pending', 'Confirmed', 'Completed']),
                'reason' => fake()->sentence(),
                'fee' => $consultationFee,
                'additional_services' => [['name' => 'Lab Test', 'amount' => $serviceAmount]],
                'additional_services_total' => $serviceAmount,
                'subtotal' => $totalAmount,
                'total_amount' => $totalAmount,
            ]));
        }

        foreach ($appointments->take(8) as $appointment) {
            Transaction::create([
                'appointment_id' => $appointment->id,
                'receipt_number' => 'RCP-' . strtoupper(fake()->bothify('??####')),
                'reference' => 'REF-' . strtoupper(fake()->bothify('??####')),
                'amount' => min($appointment->fee, fake()->randomFloat(2, 10, $appointment->fee)),
                'type' => 'payment',
                'status' => 'completed',
                'paid_at' => now(),
                'notes' => 'Seed payment',
            ]);
        }
    }
}
