@extends('layouts.app')

@section('title', 'משתמשים - CampusFix')
@section('page-title', 'משתמשים')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">משתמשים</h5>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> משתמש חדש</a>
</div>

<div class="card stat-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>שם</th>
                    <th>מספר זהות</th>
                    <th>אימייל</th>
                    <th>תפקיד</th>
                    <th>סטטוס</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->identity_number }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ match($user->role) { 'admin' => 'מנהל', 'technician' => 'טכנאי', 'student' => 'סטודנט', 'lecturer' => 'מרצה', default => $user->role } }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">פעיל</span>
                            @else
                                <span class="badge bg-danger">לא פעיל</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">עריכה</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('למחוק את המשתמש?')">
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
