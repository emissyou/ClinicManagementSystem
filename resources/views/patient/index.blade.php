@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Patient Directory</h3>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Add Patient</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Sex</th>
                        <th>Contact</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td><a href="{{ route('patients.show', $patient) }}">{{ $patient->name }}</a></td>
                            <td>{{ optional($patient->dob)->format('Y-m-d') }}</td>
                            <td>{{ $patient->sex }}</td>
                            <td>{{ $patient->emer_con ?? '' }}</td>
                            <td class="text-end">
                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('patients.destroy', $patient) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete patient?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No patients found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $patients->links() }}</div>
</div>
@endsection
