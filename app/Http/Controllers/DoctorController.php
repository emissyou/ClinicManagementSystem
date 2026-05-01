<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::paginate(15);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'specialization' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric',
            'qualifications' => 'nullable|string',
            'clinic_assignment' => 'nullable|string',
            'available_days' => 'nullable|array',
            'available_days.*' => 'string',
            'available_start_time' => 'nullable|date_format:H:i',
            'available_end_time' => 'nullable|date_format:H:i|after:available_start_time',
            'schedule_notes' => 'nullable|string',
        ]);

        $doctor = Doctor::create($data);
        return redirect()->route('doctors.index')->with('success', 'Doctor added.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('appointments');
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'specialization' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric',
            'qualifications' => 'nullable|string',
            'clinic_assignment' => 'nullable|string',
            'available_days' => 'nullable|array',
            'available_days.*' => 'string',
            'available_start_time' => 'nullable|date_format:H:i',
            'available_end_time' => 'nullable|date_format:H:i|after:available_start_time',
            'schedule_notes' => 'nullable|string',
        ]);
        $doctor->update($data);
        return redirect()->route('doctors.show', $doctor)->with('success', 'Doctor updated.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor removed.');
    }
}
