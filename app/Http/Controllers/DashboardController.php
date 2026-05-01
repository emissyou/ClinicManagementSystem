<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        $appointmentsToday = Appointment::with('patient','doctor')
            ->whereBetween('start_time', [$todayStart, $todayEnd])
            ->orderBy('start_time')
            ->get();

        $upcomingAppointments = Appointment::with('patient','doctor')
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        $todayPatientCount = $appointmentsToday->pluck('patient_id')->unique()->count();
        $completedVisitsCount = Appointment::where('status', 'Completed')->count();

        $doctors = Doctor::all();

        // count doctors with no appointments today as available
        $availableDoctors = $doctors->filter(function($doctor) use ($todayStart, $todayEnd) {
            return ! $doctor->appointments()->whereBetween('start_time', [$todayStart, $todayEnd])->exists();
        })->count();

        $doctorAvailability = $doctors->mapWithKeys(function ($doctor) use ($todayStart, $todayEnd) {
            $hasAppointment = $doctor->appointments()->whereBetween('start_time', [$todayStart, $todayEnd])->exists();
            return [$doctor->name => ! $hasAppointment];
        });

        return view('dashboard', [
            'appointmentsToday' => $appointmentsToday,
            'availableDoctors' => $availableDoctors,
            'totalDoctors' => $doctors->count(),
            'todayAppointmentCount' => $appointmentsToday->count(),
            'todayPatientCount' => $todayPatientCount,
            'completedVisitsCount' => $completedVisitsCount,
            'upcomingAppointments' => $upcomingAppointments,
            'doctorAvailability' => $doctorAvailability,
        ]);
    }
}
