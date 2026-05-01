@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Calendar - {{ $month->format('F Y') }}</h3>
        <div>
            <a href="{{ route('calendar.index', ['month' => $month->copy()->subMonth()->month, 'year' => $month->copy()->subMonth()->year]) }}" class="btn btn-sm btn-outline-secondary">Prev</a>
            <a href="{{ route('calendar.index', ['month' => $month->copy()->addMonth()->month, 'year' => $month->copy()->addMonth()->year]) }}" class="btn btn-sm btn-outline-secondary">Next</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @foreach(range(1, $month->daysInMonth) as $day)
                @php($dateKey = $month->copy()->day($day)->format('Y-m-d'))
                <div class="border rounded p-2 mb-2">
                    <strong>{{ $month->copy()->day($day)->format('D, M j') }}</strong>
                    @if(($appointmentsByDay[$dateKey] ?? collect())->isEmpty())
                        <div class="text-muted">No consultations</div>
                    @else
                        <ul class="mb-0">
                            @foreach($appointmentsByDay[$dateKey] as $appointment)
                                <li>{{ $appointment->start_time->format('H:i') }} - {{ $appointment->patient->name }} / {{ $appointment->doctor->name }} ({{ $appointment->status }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
