@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Dashboard</h3>
        <div>
            <a href="{{ route('calendar.index') }}" class="btn btn-sm btn-outline-primary">Calendar</a>
            <a href="{{ route('billing.reports') }}" class="btn btn-sm btn-outline-secondary">Reports</a>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Today's Appointments</div><div class="h4">{{ $todayAppointmentCount }}</div></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Today Patients</div><div class="h4">{{ $todayPatientCount }}</div></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Available Doctors</div><div class="h4">{{ $availableDoctors }} / {{ $totalDoctors }}</div></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Completed Visits</div><div class="h4">{{ $completedVisitsCount }}</div></div></div></div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Today's Appointments</div>
        <div class="card-body">
            @if($appointmentsToday->isEmpty())
                <p>No appointments scheduled for today.</p>
            @else
                <table class="table">
                    <thead>
                        <tr><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @foreach($appointmentsToday as $appt)
                            <tr>
                                <td>{{ optional($appt->start_time)->format('H:i') }} - {{ optional($appt->end_time)->format('H:i') }}</td>
                                <td>{{ $appt->patient->name }}</td>
                                <td>{{ $appt->doctor->name }}</td>
                                <td>{{ $appt->status }}</td>
                                <td><a href="{{ route('billing.invoice', $appt) }}" class="btn btn-sm btn-outline-primary">Invoice</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Upcoming Appointments</div>
                <div class="card-body">
                    <ul class="mb-0">
                        @foreach($upcomingAppointments as $appt)
                            <li>{{ $appt->start_time->format('M d, H:i') }} - {{ $appt->patient->name }} / {{ $appt->doctor->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Doctor Availability Today</div>
                <div class="card-body">
                    <ul class="mb-0">
                        @foreach($doctorAvailability as $doctorName => $available)
                            <li>{{ $doctorName }}: {{ $available ? 'Available' : 'Booked' }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
