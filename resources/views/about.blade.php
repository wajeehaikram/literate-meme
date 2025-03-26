<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LearnScape - About Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-b from-indigo-50 to-white">
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
                            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 transition">Home</a>
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

    <div class="bg-gradient-to-b from-indigo-50 to-white">
        <!-- Hero Section -->
        <div class="relative isolate overflow-hidden bg-gradient-to-r from-indigo-200 to-purple-100 pt-24">
            <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-indigo-100 opacity-50"></div>
            <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-indigo-700 bg-indigo-100 inline-block px-4 py-1 rounded-full">About Us</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Welcome to <span class="text-indigo-600">LearnScape</span></p>
                    <p class="mt-6 text-lg leading-8 text-gray-700">
                        LearnScape is a premier tutoring service dedicated to helping students achieve academic excellence through personalized learning experiences. Our platform connects qualified tutors with students seeking to improve their academic performance and develop a lifelong love for learning.
                    </p>
                </div>
            </div>
            <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-white opacity-50"></div>
        </div>
        
        <!-- Location Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 py-16 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-400"></div>
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-indigo-800">Our Location</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-700">
                        We are proudly based in Leeds, providing tutoring services to students throughout the city and surrounding areas.
                    </p>
                    <div class="mt-6 text-center p-6 bg-white rounded-lg shadow-md border-l-4 border-indigo-500">
                        <p class="text-lg font-semibold text-indigo-900">LearnScape Education Centre</p>
                        <p class="text-gray-700">123 Learning Lane</p>
                        <p class="text-gray-700">Leeds, LS1 4PQ</p>
                        <p class="text-gray-700">United Kingdom</p>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-indigo-400"></div>
        </div>
        
        <!-- Our Values Section -->
        <div class="bg-gradient-to-b from-white to-indigo-50 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center mb-16">
                    <span class="inline-block px-4 py-1 rounded-full text-indigo-700 bg-indigo-100 mb-4">What We Stand For</span>
                    <h2 class="text-3xl font-bold tracking-tight text-indigo-900">Our Values</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-700">
                        At LearnScape, our core values guide everything we do. We're committed to providing exceptional educational experiences for all our students.
                    </p>
                    <div class="h-1 w-40 mx-auto mt-8 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-full"></div>
                </div>
                
                <div class="mx-auto max-w-7xl">
                    <div class="grid grid-cols-1 gap-y-8 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Value 1 -->
                        <div class="bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-xl px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300 border-t-4 border-indigo-500">
                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-indigo-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Excellence & Growth</h3>
                            <p class="text-gray-700">We inspire students to not only improve grades but to develop a lifelong love for learning.</p>
                        </div>
                        
                        <!-- Value 2 -->
                        <div class="bg-gradient-to-br from-purple-100 to-indigo-50 rounded-xl px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-purple-200 hover:scale-105 transition-all duration-300 border-t-4 border-purple-500">
                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-purple-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-purple-800 mb-2">Student-Centered Learning</h3>
                            <p class="text-gray-700">Every student is unique. We tailor our teaching to individual needs, ensuring personalized and effective learning.</p>
                        </div>
                        
                        <!-- Value 3 -->
                        <div class="bg-gradient-to-br from-blue-100 to-indigo-50 rounded-xl px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-blue-200 hover:scale-105 transition-all duration-300 border-t-4 border-blue-500">
                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-blue-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Results-Driven Approach</h3>
                            <p class="text-gray-700">We focus on measurable progress, ensuring students reach their academic goals with confidence.</p>
                        </div>
                        
                        <!-- Value 4 -->
                        <div class="bg-gradient-to-br from-indigo-100 to-blue-50 rounded-xl px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-indigo-200 hover:scale-105 transition-all duration-300 border-t-4 border-indigo-500">
                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-indigo-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2">Inclusivity & Diversity</h3>
                            <p class="text-gray-700">We welcome students from all backgrounds, creating an inclusive and supportive learning space.</p>
                        </div>
                        
                        <!-- Value 5 -->
                        <div class="bg-gradient-to-br from-purple-100 to-pink-50 rounded-xl px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-purple-200 hover:scale-105 transition-all duration-300 border-t-4 border-purple-500">
                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-purple-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-purple-800 mb-2">Flexibility & Convenience</h3>
                            <p class="text-gray-700">Book sessions based on your schedule—learning should fit into your life, not the other way around.</p>
                        </div>
                        
                        <!-- Value 6 -->
                        <div class="bg-gradient-to-br from-blue-100 to-indigo-50 rounded-xl px-6 py-8 text-center shadow-sm hover:shadow-lg hover:bg-blue-200 hover:scale-105 transition-all duration-300 border-t-4 border-blue-500">
                            <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center rounded-full bg-blue-600 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Trust & Reliability</h3>
                            <p class="text-gray-700">We ensure a safe, professional, and supportive environment where students can thrive and parents can have peace of mind.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Section -->
        <div class="bg-gradient-to-t from-indigo-100 to-white py-16 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-indigo-400"></div>
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-indigo-900">Get In Touch</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-700">
                        Have questions about our tutoring services? We're here to help you on your learning journey.
                    </p>
                    <div class="mt-8 inline-block px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                        <a href="#" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>