@extends('layouts.app')

@section('title', 'משתמש חדש - CampusFix')
@section('page-title', 'משתמש חדש')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-right"></i> חזרה למשתמשים</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card stat-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">שם מלא <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">מספר זהות <span class="text-danger">*</span></label>
                            <input type="text" name="identity_number" value="{{ old('identity_number') }}" class="form-control @error('identity_number') is-invalid @enderror">
                            @error('identity_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">אימייל <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">תפקיד <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                @foreach(['student' => 'סטודנט', 'lecturer' => 'מרצה', 'technician' => 'טכנאי', 'admin' => 'מנהל'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('role') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">טלפון</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">מחלקה</label>
                            <input type="text" name="department" value="{{ old('department') }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">סיסמה <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">חשבון פעיל</label>
                    </div>
                    <button type="submit" class="btn btn-primary">שמירה</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">ביטול</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
