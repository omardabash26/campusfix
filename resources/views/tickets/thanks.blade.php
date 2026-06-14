@extends('layouts.app')

@section('title', 'הקריאה התקבלה - CampusFix')
@section('page-title', 'הקריאה התקבלה')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card stat-card">
            <div class="card-body text-center p-5">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3.5rem;"></i>
                <h4 class="mt-3">הקריאה נשלחה בהצלחה</h4>
                <p class="text-muted mb-1">מספר הקריאה שלך</p>
                <div class="fs-4 fw-bold mb-4">{{ $ticketNumber }}</div>
                <p class="text-muted">הצוות הטכני יטפל בתקלה בהקדם. תודה על הדיווח!</p>

                <div class="d-flex gap-2 justify-content-center mt-4">
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> פתיחת קריאה נוספת
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-light">סיום</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
