@php
    $statusLabels = [
        'open' => 'פתוח', 'assigned' => 'הוקצה', 'in_progress' => 'בטיפול',
        'resolved' => 'טופל', 'closed' => 'סגור',
    ];
@endphp
<div class="card stat-card mt-4">
    <div class="card-body p-4">
        <h6 class="text-muted mb-3">היסטוריית סטטוס</h6>
        @forelse($ticket->statusLogs->sortByDesc('created_at') as $log)
            <div class="d-flex justify-content-between border-bottom py-2">
                <div>
                    <span class="text-muted">{{ $statusLabels[$log->old_status] ?? $log->old_status }}</span>
                    <i class="bi bi-arrow-left mx-1"></i>
                    <span class="fw-semibold">{{ $statusLabels[$log->new_status] ?? $log->new_status }}</span>
                    @if($log->note)
                        <div class="small text-muted">{{ $log->note }}</div>
                    @endif
                </div>
                <div class="text-muted small text-start">
                    {{ $log->changer->name ?? '' }}<br>
                    {{ $log->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">אין שינויי סטטוס עדיין.</p>
        @endforelse
    </div>
</div>
