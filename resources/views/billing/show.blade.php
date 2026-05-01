@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Transaction #{{ $transaction->id }}</h3>
        <a href="{{ route('billing.receipt', $transaction) }}" class="btn btn-outline-primary btn-sm">Receipt</a>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Receipt Number:</strong> {{ $transaction->receipt_number ?? 'N/A' }}</p>
            <p><strong>Appointment ID:</strong> {{ $transaction->appointment_id ?? 'N/A' }}</p>
            <p><strong>Patient:</strong> {{ $transaction->appointment->patient->name ?? 'N/A' }}</p>
            <p><strong>Doctor:</strong> {{ $transaction->appointment->doctor->name ?? 'N/A' }}</p>
            <p><strong>Type:</strong> {{ $transaction->type }}</p>
            <p><strong>Amount:</strong> {{ number_format($transaction->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ $transaction->status }}</p>
            <p><strong>Paid At:</strong> {{ $transaction->paid_at }}</p>
            <p><strong>Notes:</strong><br>{!! nl2br(e($transaction->notes)) !!}</p>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Transaction #{{ $transaction->id }}</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Appointment ID:</strong> {{ $transaction->appointment_id ?? 'N/A' }}</p>
            <p><strong>Type:</strong> {{ $transaction->type }}</p>
            <p><strong>Amount:</strong> {{ number_format($transaction->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ $transaction->status }}</p>
            <p><strong>Paid At:</strong> {{ $transaction->paid_at }}</p>
            <p><strong>Notes:</strong><br>{!! nl2br(e($transaction->notes)) !!}</p>
        </div>
    </div>
</div>
@endsection
