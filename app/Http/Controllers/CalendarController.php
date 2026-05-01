<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->integer('month', Carbon::now()->month);
        $year = $request->integer('year', Carbon::now()->year);

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $appointments = Appointment::with('patient','doctor')
            ->whereBetween('start_time', [$start, $end])
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn ($appointment) => $appointment->start_time->format('Y-m-d'));

        return view('calendar.index', [
            'month' => $start,
            'appointmentsByDay' => $appointments,
        ]);
    }
}
