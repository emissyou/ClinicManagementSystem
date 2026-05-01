@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Doctor</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $doctor->specialization) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Consultation Fee</label>
            <input type="number" step="0.01" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Qualifications</label>
            <textarea name="qualifications" class="form-control">{{ old('qualifications', $doctor->qualifications) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Clinic Assignment</label>
            <input type="text" name="clinic_assignment" class="form-control" value="{{ old('clinic_assignment', $doctor->clinic_assignment) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Available Days</label>
            <div class="d-flex flex-wrap gap-3">
                @php($selectedDays = old('available_days', $doctor->available_days ?? []))
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <label class="form-check-label">
                        <input type="checkbox" name="available_days[]" value="{{ $day }}" @checked(in_array($day, $selectedDays))>
                        {{ $day }}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Available Start Time</label>
            <input type="time" name="available_start_time" class="form-control" value="{{ old('available_start_time', $doctor->available_start_time ? \Illuminate\Support\Carbon::parse($doctor->available_start_time)->format('H:i') : '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Available End Time</label>
            <input type="time" name="available_end_time" class="form-control" value="{{ old('available_end_time', $doctor->available_end_time ? \Illuminate\Support\Carbon::parse($doctor->available_end_time)->format('H:i') : '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Schedule Notes</label>
            <textarea name="schedule_notes" class="form-control">{{ old('schedule_notes', $doctor->schedule_notes) }}</textarea>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection