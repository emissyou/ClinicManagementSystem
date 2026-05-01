@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Billing Center</h3>
        <a href="{{ route('billing.reports') }}" class="btn btn-primary">Revenue Reports</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Appointment</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->appointment_id ?? 'N/A' }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td class="text-end">
                                <a href="{{ route('billing.show', $transaction) }}" class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No transactions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $transactions->links() }}</div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Revenue by Doctor</div>
                <div class="card-body">
                    <ul class="mb-0">
                        @foreach($revenueByDoctor as $row)
                            <li>{{ $row->doctor_name }}: {{ number_format($row->revenue, 2) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Revenue by Service Type</div>
                <div class="card-body">
                    <ul class="mb-0">
                        @foreach($revenueByServiceType as $row)
                            <li>{{ $row->service_type ?? 'Unassigned' }}: {{ number_format($row->revenue, 2) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
