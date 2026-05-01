<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('patients', PatientController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('billing/reports', [BillingController::class,'reports'])->name('billing.reports');
    Route::resource('billing', BillingController::class)->only(['index','show','store']);
    Route::get('billing/invoice/{appointment}', [BillingController::class,'invoice'])->name('billing.invoice');
    Route::get('billing/receipt/{transaction}', [BillingController::class,'receipt'])->name('billing.receipt');
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
});


require __DIR__ . '/auth.php';
