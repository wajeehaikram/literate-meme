<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LearnScape - About Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-indigo-600">LearnScape</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('about') }}" class="text-gray-700 hover:text-indigo-600 transition">About</a>
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Get Started</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden bg-gradient-to-b from-indigo-100/20 pt-24">
            <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-indigo-600">About Us</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Welcome to LearnScape</p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        LearnScape is a premier tutoring service dedicated to helping students achieve academic excellence through personalized learning experiences. Our platform connects qualified tutors with students seeking to improve their academic performance and develop a lifelong love for learning.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Location Section -->
        <div class="bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Our Location</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        We are proudly based in Leeds, providing tutoring services to students throughout the city and surrounding areas.
                    </p>
                    <div class="mt-6 text-center">
                        <p class="text-lg font-semibold text-gray-900">LearnScape Education Centre</p>
                        <p class="text-gray-600">123 Learning Lane</p>
                        <p class="text-gray-600">Leeds, LS1 4PQ</p>
                        <p class="text-gray-600">United Kingdom</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Our Values Section -->
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Our Values</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        At LearnScape, our core values guide everything we do. We're committed to providing exceptional educational experiences for all our students.
                    </p>
                </div>
                
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 gap-y-8 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Value 1 -->
                        <div class="bg-indigo-50 rounded-full px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Excellence & Growth</h3>
                            <p class="text-gray-600">We inspire students to not only improve grades but to develop a lifelong love for learning.</p>
                        </div>
                        
                        <!-- Value 2 -->
                        <div class="bg-indigo-50 rounded-full px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Student-Centered Learning</h3>
                            <p class="text-gray-600">Every student is unique. We tailor our teaching to individual needs, ensuring personalized and effective learning.</p>
                        </div>
                        
                        <!-- Value 3 -->
                        <div class="bg-indigo-50 rounded-full px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Results-Driven Approach</h3>
                            <p class="text-gray-600">We focus on measurable progress, ensuring students reach their academic goals with confidence.</p>
                        </div>
                        
                        <!-- Value 4 -->
                        <div class="bg-indigo-50 rounded-full px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Inclusivity & Diversity</h3>
                            <p class="text-gray-600">We welcome students from all backgrounds, creating an inclusive and supportive learning space.</p>
                        </div>
                        
                        <!-- Value 5 -->
                        <div class="bg-indigo-50 rounded-full px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Flexibility & Convenience</h3>
                            <p class="text-gray-600">Book sessions based on your schedule—learning should fit into your life, not the other way around.</p>
                        </div>
                        
                        <!-- Value 6 -->
                        <div class="bg-indigo-50 rounded-full px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Trust & Reliability</h3>
                            <p class="text-gray-600">We ensure a safe, professional, and supportive environment where students can thrive and parents can have peace of mind.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>