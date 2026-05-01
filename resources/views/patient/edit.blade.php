@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Patient</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.update', $patient) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', $patient->name) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" value="{{ optional($patient->dob)->format('Y-m-d') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Sex</label>
            <select name="sex" class="form-control" required>
                <option value="">Select</option>
                <option value="Male" {{ $patient->sex=='Male' ? 'selected':'' }}>Male</option>
                <option value="Female" {{ $patient->sex=='Female' ? 'selected':'' }}>Female</option>
                <option value="Other" {{ $patient->sex=='Other' ? 'selected':'' }}>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Emergency Contact</label>
            <input type="text" name="emer_con" value="{{ old('emer_con', $patient->emer_con) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $patient->email) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $patient->address) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Medical History</label>
            <textarea name="medical_history" class="form-control">{{ old('medical_history', $patient->medical_history) }}</textarea>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('patients.show', $patient) }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
