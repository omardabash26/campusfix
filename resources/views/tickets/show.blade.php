@extends('layouts.app')

@section('title', $ticket->ticket_number . ' - CampusFix')
@section('page-title', 'פרטי קריאה')

@section('content')
<div class="mb-3">
    <a href="{{ route('tickets.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-right"></i> חזרה לקריאות שלי
    </a>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted small">{{ $ticket->ticket_number }}</div>
                        <h5 class="mb-0">{{ $ticket->title }}</h5>
                    </div>
                    <span class="badge bg-{{ $ticket->statusColor() }} fs-6">
                        {{ $ticket->statusLabel() }}
                    </span>
                </div>

                <hr>

                <h6 class="text-muted">תיאור התקלה</h6>
                <p style="white-space: pre-line;">{{ $ticket->description }}</p>

                @if($ticket->solution)
                    <div class="alert alert-success mt-3 mb-0">
                        <h6 class="mb-1"><i class="bi bi-check-circle"></i> פתרון</h6>
                        <span style="white-space: pre-line;">{{ $ticket->solution }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card stat-card">
            <div class="card-body p-4">
                <h6 class="text-muted mb-3">פרטים</h6>

                <div class="mb-3">
                    <div class="text-muted small">עדיפות</div>
                    <span class="badge bg-{{ $ticket->priorityColor() }}">{{ $ticket->priorityLabel() }}</span>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">קטגוריה</div>
                    <div>{{ $ticket->category->name }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">מיקום</div>
                    <div>{{ $ticket->location->name }} ({{ $ticket->location->building }})</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">טכנאי מטפל</div>
                    <div>{{ $ticket->technician->name ?? 'טרם הוקצה' }}</div>
                </div>

                <div>
                    <div class="text-muted small">נפתחה בתאריך</div>
                    <div>{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
