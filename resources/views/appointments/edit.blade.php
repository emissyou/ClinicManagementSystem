@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Appointment</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-control" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id) == $patient->id)>{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Doctor</label>
            <select name="doctor_id" class="form-control" required>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" @selected(old('doctor_id', $appointment->doctor_id) == $doctor->id)>{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Service Type</label>
            <select name="service_type" class="form-control" required>
                @foreach(['General Check-up','Specialist Consultation','Follow-up','Lab Test'] as $serviceType)
                    <option value="{{ $serviceType }}" @selected(old('service_type', $appointment->service_type) === $serviceType)>{{ $serviceType }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time', optional($appointment->start_time)->format('Y-m-d\TH:i')) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">End Time</label>
            <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time', optional($appointment->end_time)->format('Y-m-d\TH:i')) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control" required>
                @foreach(['Pending','Confirmed','Completed','Cancelled'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $appointment->status) === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Reason</label>
            <textarea name="reason" class="form-control">{{ old('reason', $appointment->reason) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Additional Services</label>
            @php($services = old('additional_services', $appointment->additional_services ?? []))
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="additional_services[0][name]" class="form-control" placeholder="Service name" value="{{ $services[0]['name'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" name="additional_services[0][amount]" class="form-control" placeholder="Amount" value="{{ $services[0]['amount'] ?? '' }}">
                </div>
                <div class="col-md-8">
                    <input type="text" name="additional_services[1][name]" class="form-control" placeholder="Service name" value="{{ $services[1]['name'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" name="additional_services[1][amount]" class="form-control" placeholder="Amount" value="{{ $services[1]['amount'] ?? '' }}">
                </div>
            </div>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection