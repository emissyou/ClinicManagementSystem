@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Invoice - Appointment #{{ $appointment->id }}</h3>

    <div class="mb-3">
        @if($appointment->transactions->first())
            <a href="{{ route('billing.receipt', $appointment->transactions->first()) }}" class="btn btn-outline-secondary btn-sm">Open Receipt</a>
        @endif
        <a href="{{ route('billing.reports') }}" class="btn btn-outline-primary btn-sm">Revenue Reports</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
            <p><strong>Doctor:</strong> {{ $appointment->doctor->name }}</p>
            <p><strong>Service Type:</strong> {{ $appointment->service_type }}</p>
            <p><strong>Scheduled:</strong> {{ optional($appointment->start_time)->format('Y-m-d H:i') }} - {{ optional($appointment->end_time)->format('H:i') }}</p>
            <p><strong>Consultation Fee:</strong> {{ number_format($appointment->fee,2) }}</p>
            <p><strong>Additional Services:</strong> {{ number_format($appointment->additional_services_total ?? 0,2) }}</p>
            <p><strong>Invoice Total:</strong> {{ number_format($invoiceTotal,2) }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5>Transactions</h5>
            <ul>
                @foreach($appointment->transactions as $t)
                    <li>
                        {{ $t->type }}: {{ number_format($t->amount,2) }} ({{ $t->status }})
                        @if($t->receipt_number)
                            - <a href="{{ route('billing.receipt', $t) }}">{{ $t->receipt_number }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
            <p><strong>Paid:</strong> {{ number_format($paid,2) }}</p>
            <p><strong>Refunded:</strong> {{ number_format($refunded,2) }}</p>
            <p><strong>Balance:</strong> {{ number_format($balance,2) }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Record Payment / Refund</h5>
            <form action="{{ route('billing.store') }}" method="POST">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="payment">Payment</option>
                        <option value="refund">Refund</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="completed">
                </div>
                <div class="mb-3">
                    <label>Reference</label>
                    <input type="text" name="reference" class="form-control" placeholder="Optional external reference">
                </div>
                <div class="mb-3">
                    <label>Paid At</label>
                    <input type="datetime-local" name="paid_at" class="form-control">
                </div>
                <button class="btn btn-primary">Record</button>
            </form>
        </div>
    </div>
</div>
@endsection
