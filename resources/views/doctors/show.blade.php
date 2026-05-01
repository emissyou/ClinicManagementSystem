@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Doctor: {{ $doctor->name }}</h3>
        <div>
            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('doctors.index') }}" class="btn btn-link">Back</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
            <p><strong>Consultation Fee:</strong> {{ number_format($doctor->consultation_fee ?? 0, 2) }}</p>
            <p><strong>Qualifications:</strong><br>{!! nl2br(e($doctor->qualifications)) !!}</p>
            <p><strong>Clinic Assignment:</strong> {{ $doctor->clinic_assignment }}</p>
            <p><strong>Available Days:</strong> {{ implode(', ', $doctor->available_days ?? []) ?: 'Not set' }}</p>
            <p><strong>Available Time:</strong>
                @if($doctor->available_start_time && $doctor->available_end_time)
                    {{ \Illuminate\Support\Carbon::parse($doctor->available_start_time)->format('H:i') }} - {{ \Illuminate\Support\Carbon::parse($doctor->available_end_time)->format('H:i') }}
                @else
                    Not set
                @endif
            </p>
            <p><strong>Schedule Notes:</strong><br>{!! nl2br(e($doctor->schedule_notes)) !!}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Appointments</div>
        <div class="card-body">
            @if($doctor->appointments->isEmpty())
                <p class="mb-0">No appointments yet.</p>
            @else
                <ul class="mb-0">
                    @foreach($doctor->appointments as $appointment)
                        <li>{{ $appointment->start_time }} - {{ $appointment->patient->name ?? 'Patient' }} ({{ $appointment->status }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection