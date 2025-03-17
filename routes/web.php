<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
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
})->name('tutor.dashboard')->middleware('auth');

Route::get('/tutor/messages', function() {
    return view('tutor.messages');
})->name('tutor.messages')->middleware('auth');

Route::get('/tutor/bookings', function() {
    return view('tutor.bookings');
})->name('tutor.bookings')->middleware('auth');

Route::get('/tutor/resources', function() {
    return view('tutor.resources');
})->name('tutor.resources')->middleware('auth');

Route::get('/tutor/availability', function() {
    return 'Tutor Availability';
})->name('tutor.availability')->middleware('auth');

Route::get('/tutor/sessions', function() {
    return 'Tutor Sessions';
})->name('tutor.sessions')->middleware('auth');

Route::get('/parent/dashboard', function() {
    return view('parent.dashboard');
})->name('parent.dashboard')->middleware('auth');

Route::get('/parent/messages', function() {
    return view('parent.messages');
})->name('parent.messages')->middleware('auth');

Route::get('/parent/bookings', function() {
    return view('parent.bookings');
})->name('parent.bookings')->middleware('auth');

Route::get('/parent/payments', function() {
    return view('parent.payments');
})->name('parent.payments')->middleware('auth');

Route::get('/parent/find-tutors', function() {
    return 'Find Tutors';
})->name('parent.find-tutors')->middleware('auth');

Route::get('/parent/sessions', function() {
    return 'Parent Sessions';
})->name('parent.sessions')->middleware('auth');

Route::get('/tutor/profile/edit', [AuthController::class, 'editProfile'])->name('tutor.profile.edit')->middleware('auth');
Route::put('/tutor/profile/update', [AuthController::class, 'updateProfile'])->name('tutor.profile.update')->middleware('auth');

// Child Management Routes
Route::get('/children/create', function() {
    return view('parent.create_child');
})->name('child.create')->middleware('auth');
Route::post('/children', [App\Http\Controllers\ChildController::class, 'store'])->name('child.store');
Route::get('/children/{child}/edit', [App\Http\Controllers\ChildController::class, 'edit'])->name('child.edit');
Route::put('/children/{child}', [App\Http\Controllers\ChildController::class, 'update'])->name('child.update');
Route::delete('/children/{child}', [App\Http\Controllers\ChildController::class, 'destroy'])->name('child.destroy');

// Message Routes
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/compose', [MessagesController::class, 'compose'])->name('messages.compose');
    Route::get('/messages/{user}', [MessagesController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
    Route::get('/messages/search', [MessagesController::class, 'search'])->name('messages.search');
});
