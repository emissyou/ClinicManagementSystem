@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Patient: {{ $patient->name }}</h3>
        <div>
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('patients.index') }}" class="btn btn-link">Back</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>DOB:</strong> {{ optional($patient->dob)->format('Y-m-d') }}</p>
            <p><strong>Sex:</strong> {{ $patient->sex }}</p>
            <p><strong>Emergency Contact:</strong> {{ $patient->emer_con }}</p>
            <p><strong>Phone:</strong> {{ $patient->phone }}</p>
            <p><strong>Email:</strong> {{ $patient->email }}</p>
            <p><strong>Address:</strong> {{ $patient->address }}</p>
            <p><strong>Medical History:</strong><br>{{ nl2br(e($patient->medical_history)) }}</p>
        </div>
    </div>

    <h5>Appointments</h5>
    <div class="card">
        <div class="card-body">
            @if($patient->appointments->isEmpty())
                <p>No appointments yet.</p>
            @else
                <table class="table">
                    <thead>
                        <tr><th>Date</th><th>Doctor</th><th>Service</th><th>Status</th><th>Amount</th></tr>
                    </thead>
                    <tbody>
                        @foreach($patient->appointments as $appt)
                            <tr>
                                <td>{{ $appt->start_time->format('Y-m-d H:i') }}</td>
                                <td>{{ $appt->doctor->name ?? 'N/A' }}</td>
                                <td>{{ $appt->service_type }}</td>
                                <td>{{ $appt->status }}</td>
                                <td>{{ number_format($appt->total_amount ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <h5 class="mt-4">Visit History</h5>
    <div class="card">
        <div class="card-body">
            @php($completed = $patient->appointments->where('status', 'Completed'))
            @if($completed->isEmpty())
                <p class="mb-0">No completed visits yet.</p>
            @else
                <ul class="mb-0">
                    @foreach($completed as $visit)
                        <li>{{ $visit->start_time->format('Y-m-d H:i') }} - {{ $visit->doctor->name ?? 'Doctor' }} ({{ $visit->service_type }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
