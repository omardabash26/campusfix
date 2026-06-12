@extends('layouts.app')

@section('title', 'לוח בקרה - CampusFix')
@section('page-title', 'לוח בקרה')

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-ticket me-1"></i> סה"כ קריאות</div>
                <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-clock me-1"></i> קריאות פתוחות</div>
                <div class="fs-3 fw-bold">{{ $stats['open'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-wrench me-1"></i> בטיפול</div>
                <div class="fs-3 fw-bold">{{ $stats['in_progress'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small mb-1"><i class="bi bi-check2 me-1"></i> טופלו</div>
                <div class="fs-3 fw-bold">{{ $stats['resolved'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Tickets Table --}}
<div class="card stat-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold">קריאות אחרונות</h6>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-outline-primary">
            כל הקריאות <i class="bi bi-arrow-left ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-end">
                <thead class="table-light">
                    <tr>
                        <th>מספר קריאה</th>
                        <th>כותרת</th>
                        <th>מיקום</th>
                        <th>עדיפות</th>
                        <th>סטטוס</th>
                        <th>תאריך</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTickets as $ticket)
                    <tr>
                        <td class="fw-semibold">{{ $ticket->ticket_number }}</td>
                        <td>{{ Str::limit($ticket->title, 30) }}</td>
                        <td>{{ $ticket->location->name }}</td>
                        <td>
                            <span class="badge bg-{{ $ticket->priorityColor() }}">
                                {{ $ticket->priorityLabel() }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $ticket->statusColor() }}">
                                {{ $ticket->statusLabel() }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.tickets.show', $ticket) }}"
                               class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">אין קריאות עדיין</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection