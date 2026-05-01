@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Appointment #{{ $appointment->id }}</h3>
        <div>
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-secondary">Edit</a>
            <a href="{{ route('billing.invoice', $appointment) }}" class="btn btn-outline-primary">Invoice</a>
            <a href="{{ route('appointments.index') }}" class="btn btn-link">Back</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
            <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
            <p><strong>Service Type:</strong> {{ $appointment->service_type }}</p>
            <p><strong>Schedule:</strong> {{ optional($appointment->start_time)->format('Y-m-d H:i') }} - {{ optional($appointment->end_time)->format('Y-m-d H:i') }}</p>
            <p><strong>Status:</strong> {{ $appointment->status }}</p>
            <p><strong>Reason:</strong><br>{!! nl2br(e($appointment->reason)) !!}</p>
            <p><strong>Fee:</strong> {{ number_format($appointment->fee ?? 0, 2) }}</p>
            <p><strong>Additional Services:</strong> {{ number_format($appointment->additional_services_total ?? 0, 2) }}</p>
            <p><strong>Total:</strong> {{ number_format($appointment->total_amount ?? 0, 2) }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Transactions</div>
        <div class="card-body">
            @if($appointment->transactions->isEmpty())
                <p class="mb-0">No transactions recorded.</p>
            @else
                <ul class="mb-0">
                    @foreach($appointment->transactions as $transaction)
                        <li>{{ $transaction->type }} - {{ number_format($transaction->amount, 2) }} ({{ $transaction->status }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection