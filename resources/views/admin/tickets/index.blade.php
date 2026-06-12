@extends('layouts.app')

@section('title', 'כל הקריאות - CampusFix')
@section('page-title', 'כל הקריאות')

@section('content')
<div class="card stat-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">חיפוש</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="מספר קריאה או כותרת">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">סטטוס</label>
                <select name="status" class="form-select">
                    <option value="">הכל</option>
                    @foreach(['open' => 'פתוח', 'assigned' => 'הוקצה', 'in_progress' => 'בטיפול', 'resolved' => 'טופל', 'closed' => 'סגור'] as $val => $label)
                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">עדיפות</label>
                <select name="priority" class="form-select">
                    <option value="">הכל</option>
                    @foreach(['low' => 'נמוכה', 'medium' => 'בינונית', 'high' => 'גבוהה', 'critical' => 'קריטית'] as $val => $label)
                        <option value="{{ $val }}" {{ request('priority') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">סינון</button>
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-light">איפוס</a>
            </div>
        </form>
    </div>
</div>

<div class="card stat-card">
    @if($tickets->isEmpty())
        <div class="card-body text-center py-5 text-muted">אין קריאות התואמות לסינון.</div>
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
                        <th>טכנאי</th>
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
                            <td>{{ $ticket->technician->name ?? '—' }}</td>
                            <td><a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">ניהול</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
