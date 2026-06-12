@extends('layouts.app')

@section('title', 'קטגוריות - CampusFix')
@section('page-title', 'קטגוריות')

@section('content')
@php
    $priorityLabels = ['low' => 'נמוכה', 'medium' => 'בינונית', 'high' => 'גבוהה', 'critical' => 'קריטית'];
@endphp
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">קטגוריות</h5>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> קטגוריה חדשה</a>
</div>

<div class="card stat-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>שם</th>
                    <th>תיאור</th>
                    <th>עדיפות ברירת מחדל</th>
                    <th>קריאות</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-muted">{{ $category->description ?? '—' }}</td>
                        <td>{{ $priorityLabels[$category->default_priority] ?? $category->default_priority }}</td>
                        <td>{{ $category->tickets_count }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">עריכה</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('למחוק את הקטגוריה?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">מחיקה</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
