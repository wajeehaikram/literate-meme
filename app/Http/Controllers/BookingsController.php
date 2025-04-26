<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function tutorBookings(Request $request)
    {
        $user = Auth::user();
        $tab = $request->input('tab', 'upcoming');
        // Get upcoming bookings
        $upcoming = TutoringSession::with(['student', 'child'])
            ->where('tutor_id', $user->id)
            ->where(function($query) {
                $query->where('status', 'scheduled')
                      ->orWhere('status', 'Scheduled');
            })
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        // Get past bookings
        $past = TutoringSession::with(['student', 'child'])
            ->where('tutor_id', $user->id)
            ->where(function($query) {
                $query->where('status', 'scheduled')
                      ->orWhere('status', 'completed');
            })
            ->where('start_time', '<', now())
            ->orderByDesc('start_time')
            ->get();
        // Get cancelled bookings
        $cancelled = TutoringSession::with(['student', 'child'])
            ->where('tutor_id', $user->id)
            ->where('status', 'cancelled')
            ->orderByDesc('start_time')
            ->get();
        return view('tutor.bookings', compact('upcoming', 'past', 'cancelled', 'tab'));
    }

    public function parentBookings(Request $request)
    {
        $user = Auth::user();
        $tab = $request->input('tab', 'upcoming');
        // Get upcoming bookings
        $upcoming = TutoringSession::with(['child', 'student'])
            ->where('parent_id', $user->id)
            ->where('status', 'scheduled')
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        // Get past bookings
        $past = TutoringSession::with(['child', 'student'])
            ->where('parent_id', $user->id)
            ->where('status', 'scheduled')
            ->where('start_time', '<', now())
            ->orderByDesc('start_time')
            ->get();
        // Get cancelled bookings
        $cancelled = TutoringSession::with(['child', 'student'])
            ->where('parent_id', $user->id)
            ->where('status', 'cancelled')
            ->orderByDesc('start_time')
            ->get();
        return view('parent.bookings', compact('upcoming', 'past', 'cancelled', 'tab'));
    }

    public function parentCancelBooking($id)
    {
        $booking = TutoringSession::findOrFail($id);
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('parent.bookings', ['tab' => 'cancelled']);
    }
    public function tutorCancelBooking($id)
    {
        $booking = TutoringSession::findOrFail($id);
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('tutor.bookings', ['tab' => 'cancelled']);
    }
}

