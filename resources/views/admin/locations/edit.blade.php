@extends('layouts.app')

@section('title', 'עריכת מיקום - CampusFix')
@section('page-title', 'עריכת מיקום')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.locations.index') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-right"></i> חזרה למיקומים</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.locations.update', $location) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">שם <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $location->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">בניין <span class="text-danger">*</span></label>
                            <input type="text" name="building" value="{{ old('building', $location->building) }}" class="form-control @error('building') is-invalid @enderror">
                            @error('building') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">קומה</label>
                            <input type="text" name="floor" value="{{ old('floor', $location->floor) }}" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">תיאור</label>
                        <textarea name="description" rows="2" class="form-control">{{ old('description', $location->description) }}</textarea>
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">מיקום פעיל</label>
                    </div>
                    <button type="submit" class="btn btn-primary">שמירה</button>
                    <a href="{{ route('admin.locations.index') }}" class="btn btn-light">ביטול</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
