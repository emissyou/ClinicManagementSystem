@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Doctors</h3>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add Doctor</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Fee</th>
                        <th>Clinic</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr>
                            <td><a href="{{ route('doctors.show', $doctor) }}">{{ $doctor->name }}</a></td>
                            <td>{{ $doctor->specialization }}</td>
                            <td>{{ number_format($doctor->consultation_fee ?? 0, 2) }}</td>
                            <td>{{ $doctor->clinic_assignment }}</td>
                            <td class="text-end">
                                <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this doctor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No doctors found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $doctors->links() }}</div>
</div>
@endsection
