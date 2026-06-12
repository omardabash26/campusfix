@extends('layouts.app')

@section('title', 'הקריאות שלי - CampusFix')
@section('page-title', 'הקריאות שלי')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">הקריאות שלי</h5>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> פתיחת קריאה חדשה
    </a>
</div>

@if($tickets->isEmpty())
    <div class="card stat-card">
        <div class="card-body text-center py-5">
            <i class="bi bi-ticket fs-1 text-primary mb-3 d-block"></i>
            <h6>עדיין לא פתחת קריאות</h6>
            <p class="text-muted">לחץ על "פתיחת קריאה חדשה" כדי לדווח על תקלה.</p>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus-lg"></i> פתיחת קריאה חדשה
            </a>
        </div>
    </div>
@else
    <div class="card stat-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
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
                    @foreach($tickets as $ticket)
                        <tr>
                            <td class="fw-semibold">{{ $ticket->ticket_number }}</td>
                            <td>{{ $ticket->title }}</td>
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
                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                    צפייה
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
