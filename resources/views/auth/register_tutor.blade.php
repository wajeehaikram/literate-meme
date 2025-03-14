@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
    <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Register as a Tutor
            </h1>
            <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('register.tutor.submit') }}">
                @csrf
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Full Name</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                </div>
                
                <div>
                    <label for="bio" class="block mb-2 text-sm font-medium text-gray-900">Bio</label>
                    <textarea name="bio" id="bio" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">{{ old('bio') }}</textarea>
                    @error('bio')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Subjects</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="Mathematics" id="subject_math" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="subject_math" class="ml-2 text-sm font-medium text-gray-900">Mathematics</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="English" id="subject_english" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="subject_english" class="ml-2 text-sm font-medium text-gray-900">English</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="Science" id="subject_science" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="subject_science" class="ml-2 text-sm font-medium text-gray-900">Science</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="History" id="subject_history" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="subject_history" class="ml-2 text-sm font-medium text-gray-900">History</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="Geography" id="subject_geography" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="subject_geography" class="ml-2 text-sm font-medium text-gray-900">Geography</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="Computer Science" id="subject_cs" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="subject_cs" class="ml-2 text-sm font-medium text-gray-900">Computer Science</label>
                        </div>
                    </div>
                    @error('subjects')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Age Groups</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="age_groups[]" value="Primary School" id="age_primary" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="age_primary" class="ml-2 text-sm font-medium text-gray-900">Primary School (4-11)</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="age_groups[]" value="Secondary School" id="age_secondary" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="age_secondary" class="ml-2 text-sm font-medium text-gray-900">Secondary School (11-16)</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="age_groups[]" value="Sixth Form" id="age_sixth" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="age_sixth" class="ml-2 text-sm font-medium text-gray-900">Sixth Form (16-18)</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="age_groups[]" value="University" id="age_university" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="age_university" class="ml-2 text-sm font-medium text-gray-900">University (18+)</label>
                        </div>
                    </div>
                    @error('age_groups')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="hourly_rate" class="block mb-2 text-sm font-medium text-gray-900">Hourly Rate (£)</label>
                    <input type="number" name="hourly_rate" id="hourly_rate" min="0" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" value="{{ old('hourly_rate') }}" required>
                    @error('hourly_rate')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Qualifications</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="qualifications[]" value="Bachelor's Degree" id="qual_bachelors" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="qual_bachelors" class="ml-2 text-sm font-medium text-gray-900">Bachelor's Degree</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="qualifications[]" value="Master's Degree" id="qual_masters" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="qual_masters" class="ml-2 text-sm font-medium text-gray-900">Master's Degree</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="qualifications[]" value="PhD" id="qual_phd" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="qual_phd" class="ml-2 text-sm font-medium text-gray-900">PhD</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="qualifications[]" value="Teaching Certificate" id="qual_teaching" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="qual_teaching" class="ml-2 text-sm font-medium text-gray-900">Teaching Certificate</label>
                        </div>
                    </div>
                    @error('qualifications')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create Account</button>
                <p class="text-sm font-light text-gray-500 text-center">
                    Already have an account? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection