@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Schedule Appointment</h3>
    @if($errors->any())
        <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Patient</label>
            <select name="patient_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Doctor</label>
            <select name="doctor_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($doctors as $d)
                    <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->specialization }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Service Type</label>
            <select name="service_type" class="form-control" required>
                <option value="">Select</option>
                <option value="General Check-up">General Check-up</option>
                <option value="Specialist Consultation">Specialist Consultation</option>
                <option value="Follow-up">Follow-up</option>
                <option value="Lab Test">Lab Test</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Start</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>End</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Reason</label>
            <textarea name="reason" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Additional Services</label>
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="additional_services[0][name]" class="form-control" placeholder="Service name">
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" name="additional_services[0][amount]" class="form-control" placeholder="Amount">
                </div>
                <div class="col-md-8">
                    <input type="text" name="additional_services[1][name]" class="form-control" placeholder="Service name">
                </div>
                <div class="col-md-4">
                    <input type="number" step="0.01" name="additional_services[1][amount]" class="form-control" placeholder="Amount">
                </div>
            </div>
        </div>
        <button class="btn btn-primary">Schedule</button>
    </form>
</div>
@endsection
