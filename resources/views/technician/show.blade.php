@extends('layouts.app')

@section('title', $ticket->ticket_number . ' - CampusFix')
@section('page-title', 'טיפול בקריאה')

@section('content')
<div class="mb-3">
    <a href="{{ route('technician.dashboard') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-right"></i> חזרה לקריאות שלי
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

        @if(!in_array($ticket->status, ['resolved', 'closed']))
            @include('partials.comments', ['commentRoute' => route('technician.tickets.comments.store', $ticket)])
        @endif
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

        @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
            <div class="card stat-card">
                <div class="card-body p-4">
                    <h6 class="text-muted mb-3">עדכון טיפול</h6>
                    <form method="POST" action="{{ route('technician.tickets.status', $ticket) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">סטטוס</label>
                            <select name="status" class="form-select" id="statusSelect">
                                <option value="assigned" {{ $ticket->status == 'assigned' ? 'selected' : '' }}>הוקצה</option>
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>בטיפול</option>
                                <option value="resolved">טופל (סגירה)</option>
                            </select>
                        </div>
                        <div class="mb-3" id="solutionBox" style="display:{{ $errors->has('solution') ? 'block' : 'none' }};">
                            <label class="form-label">תיאור הפתרון</label>
                            <textarea name="solution" rows="3" class="form-control @error('solution') is-invalid @enderror"
                                      placeholder="מה בוצע כדי לפתור את התקלה?">{{ old('solution') }}</textarea>
                            @error('solution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">שמירה</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    const sel = document.getElementById('statusSelect');
    const box = document.getElementById('solutionBox');
    function toggleSolution() {
        if (!sel) return;
        box.style.display = sel.value === 'resolved' ? 'block' : 'none';
    }
    if (sel) {
        sel.addEventListener('change', toggleSolution);
        toggleSolution();
    }
</script>
@endsection
