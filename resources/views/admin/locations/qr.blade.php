@extends('layouts.app')

@section('title', 'קוד QR - CampusFix')
@section('page-title', 'קוד QR למיקום')

@section('styles')
<style>
    @media print {
        #sidebar, #topbar, .no-print { display: none !important; }
        #main { margin: 0 !important; }
        .qr-sheet { box-shadow: none !important; border: 1px solid #ddd; }
    }
    .qr-sheet { max-width: 360px; margin: 0 auto; }
</style>
@endsection

@section('content')
<div class="mb-3 no-print">
    <a href="{{ route('admin.locations.index') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-right"></i> חזרה למיקומים</a>
</div>

<div class="card stat-card qr-sheet">
    <div class="card-body text-center p-4">
        <h4 class="fw-bold mb-1">{{ $location->name }}</h4>
        <div class="text-muted mb-3">
            {{ $location->building }}@if($location->floor) · קומה {{ $location->floor }} @endif
        </div>

        <div id="qrcode" class="d-flex justify-content-center my-3"></div>

        <div class="text-muted small mb-3">סרוק כדי לדווח על תקלה במיקום זה</div>
        <div class="fw-bold">CampusFix</div>
    </div>
</div>

<div class="text-center mt-4 no-print">
    <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer me-1"></i> הדפסה</button>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs@master/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById("qrcode"), {
        text: "{{ $url }}",
        width: 220,
        height: 220,
    });
</script>
@endsection
