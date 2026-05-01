@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Patient</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Sex</label>
            <select name="sex" class="form-control" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Emergency Contact</label>
            <input type="text" name="emer_con" value="{{ old('emer_con') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Medical History</label>
            <textarea name="medical_history" class="form-control">{{ old('medical_history') }}</textarea>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('patients.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
