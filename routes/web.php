<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ScanController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/scan/{token}', [ScanController::class, 'show'])->name('scan.show');
Route::post('/scan/{token}', [ScanController::class, 'verify'])->name('scan.verify');
Route::get('/scan/{token}/otp', [ScanController::class, 'otpForm'])->name('scan.otp');
Route::post('/scan/{token}/otp', [ScanController::class, 'otpVerify'])->name('scan.otp.verify');

Route::middleware(['auth', 'role:student,lecturer'])->group(function () {
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/thanks', [TicketController::class, 'thanks'])->name('tickets.thanks');
});

Route::middleware(['auth', 'role:technician'])->prefix('technician')->name('technician.')->group(function () {
    Route::get('/', [TechnicianController::class, 'index'])->name('dashboard');
    Route::get('/tickets/{ticket}', [TechnicianController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}/status', [TechnicianController::class, 'updateStatus'])->name('tickets.status');
    Route::post('/tickets/{ticket}/comments', [TechnicianController::class, 'addComment'])->name('tickets.comments.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tickets', [Admin\TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [Admin\TicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}/assign', [Admin\TicketController::class, 'assign'])->name('tickets.assign');
    Route::put('/tickets/{ticket}/status', [Admin\TicketController::class, 'updateStatus'])->name('tickets.status');
    Route::post('/tickets/{ticket}/comments', [Admin\TicketController::class, 'addComment'])->name('tickets.comments.store');

    Route::resource('users', Admin\UserController::class)->except(['show']);
    Route::get('/locations/{location}/qr', [Admin\LocationController::class, 'qr'])->name('locations.qr');
    Route::resource('locations', Admin\LocationController::class)->except(['show']);
    Route::resource('categories', Admin\CategoryController::class)->except(['show']);
});

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route(match(auth()->user()->role) {
            'admin'      => 'admin.dashboard',
            'technician' => 'technician.dashboard',
            default      => 'tickets.create',
          })
        : redirect()->route('login');
});
