@extends('layouts.app')

@section('title', 'פתיחת קריאה חדשה - CampusFix')
@section('page-title', 'פתיחת קריאה חדשה')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @if(!empty($scanLocation))
            <div class="alert alert-info d-flex align-items-center">
                <i class="bi bi-qr-code-scan fs-4 me-2"></i>
                <div>פתיחת קריאה עבור <span class="fw-bold">{{ $scanLocation->name }}</span> ({{ $scanLocation->building }}@if($scanLocation->floor) · קומה {{ $scanLocation->floor }} @endif)</div>
            </div>
        @endif
        <div class="card stat-card">
            <div class="card-body p-4">
                <h5 class="mb-4">פרטי התקלה</h5>

                <form method="POST" action="{{ route('tickets.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">כותרת <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="לדוגמה: המקרן בכיתה לא עובד">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">קטגוריה <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">בחר קטגוריה...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">עדיפות <span class="text-danger">*</span></label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>נמוכה</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>בינונית</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>גבוהה</option>
                                <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>קריטית</option>
                            </select>
                            @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">מיקום <span class="text-danger">*</span></label>
                            @if(!empty($scanLocation))
                                <input type="hidden" name="location_id" value="{{ $scanLocation->id }}">
                                <input type="text" class="form-control" value="{{ $scanLocation->name }} ({{ $scanLocation->building }})" disabled>
                            @else
                                <select name="location_id" class="form-select @error('location_id') is-invalid @enderror">
                                    <option value="">בחר מיקום...</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                            {{ $location->name }} ({{ $location->building }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">תיאור התקלה <span class="text-danger">*</span></label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="תאר מה קרה, מתי, ואיך זה משפיע...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> שליחת הקריאה
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
