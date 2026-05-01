@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Doctor</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('doctors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Consultation Fee</label>
            <input type="number" step="0.01" name="consultation_fee" class="form-control" value="{{ old('consultation_fee') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Qualifications</label>
            <textarea name="qualifications" class="form-control">{{ old('qualifications') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Clinic Assignment</label>
            <input type="text" name="clinic_assignment" class="form-control" value="{{ old('clinic_assignment') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Available Days</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <label class="form-check-label">
                        <input type="checkbox" name="available_days[]" value="{{ $day }}" @checked(in_array($day, old('available_days', [])))>
                        {{ $day }}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Available Start Time</label>
            <input type="time" name="available_start_time" class="form-control" value="{{ old('available_start_time') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Available End Time</label>
            <input type="time" name="available_end_time" class="form-control" value="{{ old('available_end_time') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Schedule Notes</label>
            <textarea name="schedule_notes" class="form-control">{{ old('schedule_notes') }}</textarea>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('doctors.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection