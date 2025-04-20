<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\BookingsController;

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
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
Route::get('/tutor/dashboard', function() {
    $user = Auth::user();
    $unreadMessages = collect();
    $recentMessages = collect();
    if ($user) {
        $unreadMessages = App\Models\Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->get();
        $recentMessages = App\Models\Message::with('sender')
            ->where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
    return view('tutor.dashboard', compact('unreadMessages', 'recentMessages'));
})->name('tutor.dashboard')->middleware('auth');

Route::get('/tutor/messages', [MessagesController::class, 'index'])->name('tutor.messages')->middleware('auth');

Route::get('/tutor/bookings', [BookingsController::class, 'tutorBookings'])->name('tutor.bookings')->middleware('auth');

Route::get('/tutor/resources', function() {
    return view('tutor.resources');
})->name('tutor.resources')->middleware('auth');

use App\Http\Controllers\TutorSimpleAvailabilityController;

Route::middleware(['auth'])->group(function () {
    // Removed tutor availability routes
    Route::post('/tutor/availability/simple', [TutorSimpleAvailabilityController::class, 'store'])->name('tutor.availability.simple.store');
});

Route::get('/tutor/sessions', function() {
    return 'Tutor Sessions';
})->name('tutor.sessions')->middleware('auth');

Route::get('/parent/dashboard', function() {
    $tutors = App\Models\User::whereHas('tutorProfile')
        ->with(['tutorProfile'])
        ->get();
    return view('parent.dashboard', compact('tutors'));
})->name('parent.dashboard')->middleware('auth');

Route::get('/parent/messages', [MessagesController::class, 'index'])->name('parent.messages')->middleware('auth');

Route::get('/parent/bookings', [BookingsController::class, 'parentBookings'])->name('parent.bookings')->middleware('auth');

Route::get('/parent/payments', [App\Http\Controllers\PaymentController::class, 'showPayments'])->name('parent.payments')->middleware('auth');
Route::get('/parent/add-card', [App\Http\Controllers\PaymentController::class, 'showAddCard'])->name('parent.add-card')->middleware('auth');

Route::get('/parent/find-tutors', function() {
    return 'Find Tutors';
})->name('parent.find-tutors')->middleware('auth');

Route::get('/parent/browse-tutors', [\App\Http\Controllers\TutorController::class, 'browse'])->name('parent.browse-tutors')->middleware('auth');

Route::get('/parent/sessions', function() {
    return 'Parent Sessions';
})->name('parent.sessions')->middleware('auth');

Route::get('/tutor/profile/edit', [AuthController::class, 'editProfile'])->name('tutor.profile.edit')->middleware('auth');
Route::put('/tutor/profile/update', [AuthController::class, 'updateProfile'])->name('tutor.profile.update')->middleware('auth');

// Child Management Routes
Route::middleware('auth')->group(function () {
    Route::get('/parent/children/create', [App\Http\Controllers\ChildController::class, 'create'])->name('parent.children.create');
    Route::post('/parent/children', [App\Http\Controllers\ChildController::class, 'store'])->name('parent.children.store');
    Route::get('/parent/children/{child}/edit', [App\Http\Controllers\ChildController::class, 'edit'])->name('parent.children.edit');
    Route::put('/parent/children/{child}', [App\Http\Controllers\ChildController::class, 'update'])->name('parent.children.update');
    Route::delete('/parent/children/{child}', [App\Http\Controllers\ChildController::class, 'destroy'])->name('parent.children.destroy');
});

// Message Routes
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
    Route::get('/messages/{user}', [MessagesController::class, 'show'])->name('messages.show');
    // Search route kept for backward compatibility
    Route::get('/messages/search', [MessagesController::class, 'search'])->name('messages.search');
    Route::post('/messages/send-suggestion', [MessagesController::class, 'sendSuggestion'])->name('messages.sendSuggestion');
    Route::post('/messages/suggest-booking', [MessagesController::class, 'suggestBooking'])->name('messages.suggestBooking');
    Route::post('/messages/{message}/booking-response', [MessagesController::class, 'bookingResponse'])->name('messages.bookingResponse');
});

// Payment Routes
Route::post('/payment/intent', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('payment.intent');
Route::post('/payment/store', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store')->middleware('auth');
Route::post('/stripe/webhook', [App\Http\Controllers\PaymentController::class, 'handleWebhook'])->name('stripe.webhook');

Route::get('/stripe', [StripeController::class, 'index'])->name('stripe.index');
Route::post('/stripe/charge', [StripeController::class, 'charge'])->name('stripe.charge');
Route::get('/payment/success', function() {
    return view('payment.success');
})->name('payment.success');
