<?php

namespace App\Http\Controllers;

use App\Models\User;
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

            if (Auth::user()->isTutor()) {
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
            'hourly_rate' => 'required|numeric|min:0',
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
            'hourly_rate' => $request->hourly_rate,
            'qualifications' => $request->qualifications,
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}