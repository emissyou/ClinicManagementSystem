@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Revenue Reports</h3>
        <a href="{{ route('billing.index') }}" class="btn btn-link">Back to Billing</a>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">Revenue by Doctor</div>
                <div class="card-body">
                    <ul class="mb-0">
                        @forelse($revenueByDoctor as $row)
                            <li>{{ $row->doctor_name }}: {{ number_format($row->revenue, 2) }}</li>
                        @empty
                            <li>No revenue yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">Revenue by Service Type</div>
                <div class="card-body">
                    <ul class="mb-0">
                        @forelse($revenueByServiceType as $row)
                            <li>{{ $row->service_type ?? 'Unassigned' }}: {{ number_format($row->revenue, 2) }}</li>
                        @empty
                            <li>No revenue yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection