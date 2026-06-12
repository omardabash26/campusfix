@extends('layouts.auth')

@section('title', 'אימות קוד - CampusFix')

@section('content')
<div class="auth-card card">
    <div class="auth-header">
        <i class="bi bi-shield-lock fs-2 mb-2 d-block"></i>
        <h4 class="mb-0">אימות זהות</h4>
        <small class="opacity-75">הזן את הקוד שנשלח אליך</small>
    </div>

    <div class="card-body p-4">
        @php $phone = $user->phone ? '••• ••• ' . substr(preg_replace('/\D/', '', $user->phone), -3) : 'מספר הטלפון שלך'; @endphp

        <p class="text-muted text-center mb-3">
            שלחנו קוד בן 4 ספרות אל<br>
            <span class="fw-semibold text-dark">{{ $phone }}</span>
        </p>

        <div class="alert alert-warning text-center">
            <div class="small mb-1">קוד לצורך הדגמה</div>
            <div class="fs-3 fw-bold" style="letter-spacing: 6px;">{{ $demoCode }}</div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('scan.otp.verify', $token) }}">
            @csrf
            <div class="mb-4">
                <input type="text" name="otp" class="form-control form-control-lg text-center"
                       style="letter-spacing: 6px; font-size: 1.5rem;" maxlength="4" placeholder="----" autofocus required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-check2-circle me-1"></i> אימות וכניסה
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('scan.show', $token) }}" class="text-muted small text-decoration-none">חזרה</a>
        </div>
    </div>
</div>
@endsection
