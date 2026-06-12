@extends('layouts.app')

@section('title', $ticket->ticket_number . ' - CampusFix')
@section('page-title', 'ניהול קריאה')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.tickets.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-right"></i> חזרה לכל הקריאות
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card stat-card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="text-muted small">{{ $ticket->ticket_number }}</div>
                        <h5 class="mb-0">{{ $ticket->title }}</h5>
                    </div>
                    <span class="badge bg-{{ $ticket->statusColor() }} fs-6">{{ $ticket->statusLabel() }}</span>
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

        @include('partials.comments', ['commentRoute' => route('admin.tickets.comments.store', $ticket)])
        @include('partials.status_logs')
    </div>

    <div class="col-lg-4">
        <div class="card stat-card mb-4">
            <div class="card-body p-4">
                <h6 class="text-muted mb-3">פרטים</h6>
                <div class="mb-2"><div class="text-muted small">מדווח</div>{{ $ticket->reporter->name }}</div>
                <div class="mb-2"><div class="text-muted small">עדיפות</div><span class="badge bg-{{ $ticket->priorityColor() }}">{{ $ticket->priorityLabel() }}</span></div>
                <div class="mb-2"><div class="text-muted small">קטגוריה</div>{{ $ticket->category->name }}</div>
                <div class="mb-2"><div class="text-muted small">מיקום</div>{{ $ticket->location->name }} ({{ $ticket->location->building }})</div>
                <div><div class="text-muted small">נפתחה</div>{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <div class="card stat-card mb-4">
            <div class="card-body p-4">
                <h6 class="text-muted mb-3">הקצאת טכנאי</h6>
                <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <select name="assigned_to" class="form-select">
                            <option value="">בחר טכנאי...</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                    {{ $tech->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">שמירת הקצאה</button>
                </form>
            </div>
        </div>

        <div class="card stat-card">
            <div class="card-body p-4">
                <h6 class="text-muted mb-3">שינוי סטטוס</h6>
                <form method="POST" action="{{ route('admin.tickets.status', $ticket) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach(['open' => 'פתוח', 'assigned' => 'הוקצה', 'in_progress' => 'בטיפול', 'resolved' => 'טופל', 'closed' => 'סגור'] as $val => $label)
                                <option value="{{ $val }}" {{ $ticket->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="note" class="form-control" placeholder="הערה (לא חובה)">
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100">עדכון סטטוס</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
