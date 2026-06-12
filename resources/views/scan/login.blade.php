@extends('layouts.auth')

@section('title', 'פתיחת קריאה - CampusFix')

@section('content')
<div class="auth-card card">
    <div class="auth-header">
        <i class="bi bi-qr-code-scan fs-2 mb-2 d-block"></i>
        <h4 class="mb-0">CampusFix</h4>
        <small class="opacity-75">פתיחת קריאה מהירה</small>
    </div>

    <div class="card-body p-4">
        <div class="alert alert-info d-flex align-items-center">
            <i class="bi bi-geo-alt-fill fs-4 me-2"></i>
            <div>
                <div class="fw-bold">{{ $location->name }}</div>
                <div class="small">{{ $location->building }}@if($location->floor) · קומה {{ $location->floor }} @endif</div>
            </div>
        </div>

        <p class="text-muted text-center small mb-4">התחבר כדי לדווח על תקלה במיקום זה</p>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('scan.verify', $token) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold"><i class="bi bi-person-badge me-1"></i> מספר זהות</label>
                <input type="text" name="identity_number" value="{{ old('identity_number') }}"
                       class="form-control form-control-lg" placeholder="הזן מספר זהות" autofocus required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold"><i class="bi bi-lock me-1"></i> סיסמה</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="הזן סיסמה" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-arrow-left-circle me-1"></i> המשך
            </button>
        </form>
    </div>
</div>
@endsection
