<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/register/tutor', function() {
    return view('auth.register_tutor');
})->name('register.tutor');
Route::post('/register/tutor', [AuthController::class, 'registerTutor'])->name('register.tutor.submit');

Route::get('/register/parent', function() {
    return view('auth.register_parent');
})->name('register.parent');
Route::post('/register/parent', [AuthController::class, 'registerParent'])->name('register.parent.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Placeholder routes for dashboard functionality
Route::get('/tutor/dashboard', function() {
    return view('tutor.dashboard');
})->name('tutor.dashboard');

Route::get('/tutor/messages', function() {
    return view('tutor.messages');
})->name('tutor.messages');

Route::get('/tutor/bookings', function() {
    return view('tutor.bookings');
})->name('tutor.bookings');

Route::get('/tutor/resources', function() {
    return view('tutor.resources');
})->name('tutor.resources');

Route::get('/tutor/availability', function() {
    return 'Tutor Availability';
})->name('tutor.availability');

Route::get('/tutor/sessions', function() {
    return 'Tutor Sessions';
})->name('tutor.sessions');

Route::get('/parent/dashboard', function() {
    return view('parent.dashboard');
})->name('parent.dashboard');

Route::get('/parent/messages', function() {
    return view('parent.messages');
})->name('parent.messages');

Route::get('/parent/bookings', function() {
    return view('parent.bookings');
})->name('parent.bookings');

Route::get('/parent/payments', function() {
    return view('parent.payments');
})->name('parent.payments');

Route::get('/parent/find-tutors', function() {
    return 'Find Tutors';
})->name('parent.find-tutors');

Route::get('/parent/sessions', function() {
    return 'Parent Sessions';
})->name('parent.sessions');

// Child Management Routes
Route::post('/children', [App\Http\Controllers\ChildController::class, 'store'])->name('child.store');
Route::get('/children/{child}/edit', [App\Http\Controllers\ChildController::class, 'edit'])->name('child.edit');
Route::put('/children/{child}', [App\Http\Controllers\ChildController::class, 'update'])->name('child.update');
Route::delete('/children/{child}', [App\Http\Controllers\ChildController::class, 'destroy'])->name('child.destroy');
