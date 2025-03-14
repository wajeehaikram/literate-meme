@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative isolate overflow-hidden bg-gradient-to-b from-indigo-100/20">
        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">Online Tutoring Platform</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Welcome to LearnScape</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Connect with qualified tutors and schedule your learning sessions today. Our platform makes it easy to find the perfect tutor for your needs.
                </p>
                
                @guest
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <span onclick="window.location='{{ route('login') }}'" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-pointer">Log in</span>
                    <div class="relative inline-block text-left">
                        <button type="button" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dropdown-toggle" id="registerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Register <span class="ml-1 text-xs inline-block align-middle">▼</span>
                        </button>
                        <div class="dropdown-menu absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" aria-labelledby="registerDropdown">
                            <div class="py-1">
                                <span onclick="window.location='{{ route('register.tutor') }}'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">As Tutor</span>
                                <span onclick="window.location='{{ route('register.parent') }}'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">As Parent</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </div>
    
    <!-- Main Content Card -->
    <div class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">
                <!-- Tabs Navigation -->
                <div class="bg-gray-800 rounded-t-lg overflow-hidden">
                    <div class="flex">
                        <button class="bg-indigo-600 text-white px-6 py-3 font-medium">Online Learning</button>
                        <button class="bg-gray-800 text-white px-6 py-3 font-medium">Flexible Schedule</button>
                    </div>
                </div>
                
                <!-- Main Content Card -->
                <div class="bg-indigo-600 text-white rounded-b-lg p-12">
                    <h2 class="text-3xl font-bold mb-6">Find the Perfect Tutor</h2>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Qualified tutors in various subjects</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Personalised learning experience</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Flexible scheduling options</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Track your progress</span>
                        </li>
                    </ul>
                    
                    @guest
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <span onclick="window.location='{{ route('login') }}'" class="bg-white text-indigo-700 px-6 py-2 rounded-md font-medium hover:bg-gray-100 transition-colors cursor-pointer">Log in</span>
                        <div class="relative inline-block text-left">
                            <button type="button" class="bg-indigo-700 text-white px-6 py-2 rounded-md font-medium hover:bg-indigo-800 transition-colors dropdown-toggle" id="registerDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                Register <span class="ml-1 text-xs inline-block align-middle">▼</span>
                            </button>
                            <div class="dropdown-menu absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" aria-labelledby="registerDropdown2">
                                <div class="py-1">
                                    <span onclick="window.location='{{ route('register.tutor') }}'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">As Tutor</span>
                                    <span onclick="window.location='{{ route('register.parent') }}'" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer">As Parent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center mb-16">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">Simple Process</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">How LearnScape Works</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Our platform makes it easy to connect with tutors and start learning in just a few simple steps.
                </p>
            </div>

            <div class="mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-y-8 gap-x-8 md:grid-cols-3">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-xl px-6 py-8 shadow-sm hover:shadow-lg transition-all duration-300 text-center">
                        <div class="mx-auto rounded-full bg-indigo-100 w-12 h-12 flex items-center justify-center mb-4">
                            <span class="text-indigo-800 font-bold">1</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Create an Account</h3>
                        <p class="text-gray-600">Sign up as a parent or student to access our platform's features and start your learning journey.</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-white rounded-xl px-6 py-8 shadow-sm hover:shadow-lg transition-all duration-300 text-center">
                        <div class="mx-auto rounded-full bg-indigo-100 w-12 h-12 flex items-center justify-center mb-4">
                            <span class="text-indigo-800 font-bold">2</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Find Your Tutor</h3>
                        <p class="text-gray-600">Browse through our qualified tutors, filter by subject, availability, and read reviews to find your perfect match.</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-white rounded-xl px-6 py-8 shadow-sm hover:shadow-lg transition-all duration-300 text-center">
                        <div class="mx-auto rounded-full bg-indigo-100 w-12 h-12 flex items-center justify-center mb-4">
                            <span class="text-indigo-800 font-bold">3</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Schedule Sessions</h3>
                        <p class="text-gray-600">Book sessions at times that work for you, manage your calendar, and start learning at your own pace.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-indigo-700 py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Ready to Start Learning?</h2>
                <p class="mt-6 text-lg leading-8 text-indigo-200">
                    Join thousands of students who have improved their grades and confidence through our platform.
                </p>
                @guest
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <span onclick="window.location='{{ route('login') }}'" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white cursor-pointer">Get Started Today</span>
                    <span onclick="window.location='{{ route('about') }}'" class="text-sm font-semibold leading-6 text-white cursor-pointer">Learn more <span aria-hidden="true" class="inline-block align-middle">→</span></span>
                </div>
                @endguest
            </div>
        </div>
    </div>

    @auth
    <!-- Features Section for Authenticated Users -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Manage Your Learning Journey</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Access all the tools you need to make the most of your tutoring experience.
                </p>
            </div>
            
            <div class="mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-y-8 gap-x-6 md:grid-cols-2">
                    <!-- Feature 1 -->
                    <div class="bg-indigo-50 rounded-xl px-6 py-8 shadow-sm hover:shadow-lg hover:bg-indigo-100 transition-all duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Find and Book Sessions</h3>
                        <p class="text-gray-600">Browse available tutors, view their schedules, and book sessions that fit your availability.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-indigo-50 rounded-xl px-6 py-8 shadow-sm hover:shadow-lg hover:bg-indigo-100 transition-all duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Track Your Progress</h3>
                        <p class="text-gray-600">Monitor your learning journey, view past sessions, and track your improvement over time.</p>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>
@endsection