<div class="card stat-card mt-4">
    <div class="card-body p-4">
        <h6 class="text-muted mb-3">תגובות</h6>

        <div class="mb-3">
            @forelse($ticket->comments as $comment)
                <div class="border rounded p-3 mb-2 bg-light">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">{{ $comment->user->name }}</span>
                        <span class="text-muted small">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div style="white-space: pre-line;">{{ $comment->comment }}</div>
                </div>
            @empty
                <p class="text-muted mb-0">אין תגובות עדיין.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ $commentRoute }}">
            @csrf
            <div class="mb-2">
                <textarea name="comment" rows="2" class="form-control @error('comment') is-invalid @enderror"
                          placeholder="כתוב תגובה...">{{ old('comment') }}</textarea>
                @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-sm btn-primary">שליחת תגובה</button>
            </div>
        </form>
    </div>
</div>
