<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    /**
     * Display a listing of all tutors for parents to browse.
     *
     * @return \Illuminate\Http\Response
     */
    public function browse()
    {
        // Get all tutors with their profiles
        $tutors = User::where('user_type', 'tutor')
            ->whereHas('tutorProfile')
            ->with(['tutorProfile'])
            ->get();
            
        return view('parent.browse-tutors', compact('tutors'));
    }
}