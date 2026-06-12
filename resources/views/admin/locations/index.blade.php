@extends('layouts.app')

@section('title', 'מיקומים - CampusFix')
@section('page-title', 'מיקומים')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">מיקומים</h5>
    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> מיקום חדש</a>
</div>

<div class="card stat-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>שם</th>
                    <th>בניין</th>
                    <th>קומה</th>
                    <th>סטטוס</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td class="fw-semibold">{{ $location->name }}</td>
                        <td>{{ $location->building }}</td>
                        <td>{{ $location->floor ?? '—' }}</td>
                        <td>
                            @if($location->is_active)
                                <span class="badge bg-success">פעיל</span>
                            @else
                                <span class="badge bg-danger">לא פעיל</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.locations.qr', $location) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-qr-code"></i> QR</a>
                            <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-outline-secondary">עריכה</a>
                            <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" class="d-inline" onsubmit="return confirm('למחוק את המיקום?')">
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
