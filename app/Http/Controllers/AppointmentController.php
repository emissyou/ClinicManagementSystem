<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient','doctor'])->orderBy('start_time')->paginate(20);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        return view('appointments.create', compact('patients','doctors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'service_type' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'reason' => 'nullable|string',
            'additional_services' => 'nullable|array',
            'additional_services.*.name' => 'nullable|string',
            'additional_services.*.amount' => 'nullable|numeric|min:0',
        ]);

        $start = Carbon::parse($data['start_time']);
        $end = Carbon::parse($data['end_time']);
        $doctor = Doctor::findOrFail($data['doctor_id']);

        $this->ensureDoctorAvailable($doctor, $start, $end);

        // Conflict check: same doctor overlapping
        $conflict = Appointment::where('doctor_id', $data['doctor_id'])
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end])
                  ->orWhere(function($q2) use ($start, $end) {
                      $q2->where('start_time', '<=', $start)
                         ->where('end_time', '>=', $end);
                  });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'Selected time conflicts with existing appointment for this doctor.'])->withInput();
        }

        $additionalServices = array_values(array_filter($data['additional_services'] ?? [], function ($item) {
            return ! empty($item['name']) && isset($item['amount']);
        }));
        $additionalServicesTotal = collect($additionalServices)->sum(fn ($item) => (float) $item['amount']);
        $subtotal = (float) $doctor->consultation_fee + $additionalServicesTotal;

        $appointment = Appointment::create([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $data['doctor_id'],
            'service_type' => $data['service_type'],
            'start_time' => $start,
            'end_time' => $end,
            'reason' => $data['reason'] ?? null,
            'status' => 'Pending',
            'fee' => $doctor->consultation_fee ?? 0,
            'additional_services' => $additionalServices,
            'additional_services_total' => $additionalServicesTotal,
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
        ]);

        return redirect()->route('appointments.index')->with('success','Appointment scheduled.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load('patient','doctor','transactions');
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();
        return view('appointments.edit', compact('appointment','patients','doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'service_type' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|string',
            'reason' => 'nullable|string',
            'additional_services' => 'nullable|array',
            'additional_services.*.name' => 'nullable|string',
            'additional_services.*.amount' => 'nullable|numeric|min:0',
        ]);

        $start = Carbon::parse($data['start_time']);
        $end = Carbon::parse($data['end_time']);
        $doctor = Doctor::findOrFail($data['doctor_id']);

        $this->ensureDoctorAvailable($doctor, $start, $end);

        $conflict = Appointment::where('doctor_id', $data['doctor_id'])
            ->where('id','!=',$appointment->id)
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end])
                  ->orWhere(function($q2) use ($start, $end) {
                      $q2->where('start_time', '<=', $start)
                         ->where('end_time', '>=', $end);
                  });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['start_time' => 'Selected time conflicts with existing appointment for this doctor.'])->withInput();
        }

        $additionalServices = array_values(array_filter($data['additional_services'] ?? [], function ($item) {
            return ! empty($item['name']) && isset($item['amount']);
        }));
        $additionalServicesTotal = collect($additionalServices)->sum(fn ($item) => (float) $item['amount']);
        $subtotal = (float) $doctor->consultation_fee + $additionalServicesTotal;

        $appointment->update([
            'patient_id' => $data['patient_id'],
            'doctor_id' => $data['doctor_id'],
            'service_type' => $data['service_type'],
            'start_time' => $start,
            'end_time' => $end,
            'status' => $data['status'],
            'reason' => $data['reason'] ?? null,
            'additional_services' => $additionalServices,
            'additional_services_total' => $additionalServicesTotal,
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
            'fee' => $doctor->consultation_fee ?? 0,
        ]);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment updated.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success','Appointment cancelled.');
    }

    private function ensureDoctorAvailable(Doctor $doctor, Carbon $start, Carbon $end): void
    {
        if ($doctor->available_days && count($doctor->available_days)) {
            $day = strtolower($start->format('l'));
            $availableDays = collect($doctor->available_days)->map(fn ($value) => strtolower($value))->all();

            if (! in_array($day, $availableDays, true)) {
                throw ValidationException::withMessages([
                    'start_time' => 'The selected doctor is not available on this day.',
                ]);
            }
        }

        if ($doctor->available_start_time && $doctor->available_end_time) {
            $startTime = Carbon::parse($doctor->available_start_time)->format('H:i');
            $endTime = Carbon::parse($doctor->available_end_time)->format('H:i');
            $appointmentStart = $start->format('H:i');
            $appointmentEnd = $end->format('H:i');

            if ($appointmentStart < $startTime || $appointmentEnd > $endTime) {
                throw ValidationException::withMessages([
                    'start_time' => 'The selected time is outside the doctor availability window.',
                ]);
            }
        }
    }
}
