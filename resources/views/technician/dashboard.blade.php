@extends('layouts.app')

@section('title', 'הקריאות שלי - CampusFix')
@section('page-title', 'הקריאות שלי')

@section('content')
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-inbox me-1"></i> ממתינות לטיפול</div>
                <div class="fs-3 fw-bold">{{ $stats['assigned'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-wrench me-1"></i> בטיפול</div>
                <div class="fs-3 fw-bold">{{ $stats['in_progress'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-check2 me-1"></i> טופלו</div>
                <div class="fs-3 fw-bold">{{ $stats['resolved'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card stat-card">
    <div class="card-header bg-white fw-semibold py-3">הקריאות שהוקצו אליי</div>
    @if($tickets->isEmpty())
        <div class="card-body text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            אין קריאות מוקצות כרגע.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>מספר</th>
                        <th>כותרת</th>
                        <th>מדווח</th>
                        <th>מיקום</th>
                        <th>עדיפות</th>
                        <th>סטטוס</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td class="fw-semibold">{{ $ticket->ticket_number }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->reporter->name }}</td>
                            <td>{{ $ticket->location->name }}</td>
                            <td><span class="badge bg-{{ $ticket->priorityColor() }}">{{ $ticket->priorityLabel() }}</span></td>
                            <td><span class="badge bg-{{ $ticket->statusColor() }}">{{ $ticket->statusLabel() }}</span></td>
                            <td><a href="{{ route('technician.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">{{ in_array($ticket->status, ['resolved', 'closed']) ? 'צפייה' : 'טיפול' }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
