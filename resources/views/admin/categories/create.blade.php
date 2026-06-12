@extends('layouts.app')

@section('title', 'קטגוריה חדשה - CampusFix')
@section('page-title', 'קטגוריה חדשה')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-right"></i> חזרה לקטגוריות</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">שם <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="תקלת חשמל, תקלת מחשב...">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">תיאור</label>
                        <textarea name="description" rows="2" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">עדיפות ברירת מחדל <span class="text-danger">*</span></label>
                        <select name="default_priority" class="form-select @error('default_priority') is-invalid @enderror">
                            @foreach(['low' => 'נמוכה', 'medium' => 'בינונית', 'high' => 'גבוהה', 'critical' => 'קריטית'] as $val => $label)
                                <option value="{{ $val }}" {{ old('default_priority', 'medium') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('default_priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">שמירה</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">ביטול</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
