@extends('layouts.auth')

@section('title', 'התחברות - CampusFix')

@section('content')
<div class="auth-card card">
    <div class="auth-header">
        <i class="bi bi-tools fs-2 mb-2 d-block"></i>
        <h4 class="mb-0">CampusFix</h4>
        <small class="opacity-75">מערכת ניהול תקלות במכללה</small>
    </div>

    <div class="card-body p-4">
        <h5 class="mb-4 text-center text-muted">התחברות למערכת</h5>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="identity_number" class="form-label fw-semibold">
                    <i class="bi bi-person-badge me-1"></i> מספר זהות
                </label>
                <input
                    type="text"
                    class="form-control form-control-lg @error('identity_number') is-invalid @enderror"
                    id="identity_number"
                    name="identity_number"
                    value="{{ old('identity_number') }}"
                    placeholder="הזן מספר זהות"
                    autofocus
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    <i class="bi bi-lock me-1"></i> סיסמה
                </label>
                <input
                    type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="הזן סיסמה"
                    required
                >
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">זכור אותי</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> התחבר
            </button>
        </form>
    </div>
</div>
@endsection