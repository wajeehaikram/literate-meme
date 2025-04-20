<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TutoringSession;

class BookingsController extends Controller
{
    public function tutorBookings()
    {
        $user = Auth::user();
        $upcoming = TutoringSession::where('tutor_id', $user->id)
            ->where('status', 'scheduled')
            // ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        $past = TutoringSession::where('tutor_id', $user->id)
            ->where('status', 'scheduled')
            ->where('start_time', '<', now())
            ->orderByDesc('start_time')
            ->get();
        return view('tutor.bookings', compact('upcoming', 'past'));
    }

    public function parentBookings()
    {
        $user = Auth::user();
        $upcoming = TutoringSession::where('parent_id', $user->id)
            ->where('status', 'scheduled')
            // ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        $past = TutoringSession::where('parent_id', $user->id)
            ->where('status', 'scheduled')
            ->where('start_time', '<', now())
            ->orderByDesc('start_time')
            ->get();
        return view('parent.bookings', compact('upcoming', 'past'));
    }
}
