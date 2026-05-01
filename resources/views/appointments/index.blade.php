@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Appointments</h3>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">New Appointment</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ optional($appointment->start_time)->format('Y-m-d H:i') }}</td>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->service_type }}</td>
                            <td>{{ $appointment->status }}</td>
                            <td class="text-end">
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this appointment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No appointments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $appointments->links() }}</div>
</div>
@endsection
