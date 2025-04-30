<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\TutorProfile;
use App\Models\ParentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->isTutor()) {
                return redirect()->intended('tutor/dashboard');
            } else {
                return redirect()->intended('parent/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function registerTutor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'subjects' => 'required|array',
            'age_groups' => 'required|array',

            'qualifications' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'tutor',
        ]);

        TutorProfile::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'subjects' => $request->subjects,
            'age_groups' => $request->age_groups,
            'qualifications' => $request->qualifications,
            'hourly_rate' => $request->hourly_rate,
        ]);

        Auth::login($user);

        return redirect()->route('tutor.dashboard');
    }

    public function registerParent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string',
            'additional_info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'parent',
        ]);

        ParentProfile::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'additional_info' => $request->additional_info,
        ]);

        Auth::login($user);

        return redirect()->route('parent.dashboard');
    }

    public function editProfile()
    {
        $user = Auth::user();
        $tutorProfile = TutorProfile::where('user_id', $user->id)->first();
        $subjects = Subject::all();
        
        return view('tutor.edit_profile', compact('tutorProfile', 'subjects'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'current_password' => 'required_with:password',
            'password' => 'nullable|min:8|confirmed',
            'bio' => 'nullable|string',
            'subjects' => 'nullable|array',
            'qualifications' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $tutorProfile = TutorProfile::where('user_id', $user->id)->first();
        $tutorProfile->update([
            'bio' => $request->bio,
            'subjects' => $request->subjects,
            'qualifications' => $request->filled('qualifications') ? explode('\n', $request->qualifications) : [],
        ]);

        return redirect()->route('tutor.dashboard')->with('status', 'Profile updated successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}