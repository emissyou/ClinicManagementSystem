@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mx-auto" style="max-width: 700px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Digital Receipt</strong>
            <span>{{ $receiptNumber }}</span>
        </div>
        <div class="card-body">
            <p><strong>Patient:</strong> {{ $transaction->appointment->patient->name ?? 'N/A' }}</p>
            <p><strong>Doctor:</strong> {{ $transaction->appointment->doctor->name ?? 'N/A' }}</p>
            <p><strong>Amount:</strong> {{ number_format($transaction->amount, 2) }}</p>
            <p><strong>Type:</strong> {{ $transaction->type }}</p>
            <p><strong>Status:</strong> {{ $transaction->status }}</p>
            <p><strong>Reference:</strong> {{ $transaction->reference ?? 'N/A' }}</p>
            <p><strong>Paid At:</strong> {{ $transaction->paid_at }}</p>
            <p><strong>Notes:</strong><br>{!! nl2br(e($transaction->notes)) !!}</p>
        </div>
    </div>
</div>
@endsection