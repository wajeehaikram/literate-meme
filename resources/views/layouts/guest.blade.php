<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LearnScape') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Navbar link hover effect */
        .nav-link-hover {
            transition: transform 0.3s ease;
        }
        
        .nav-link-hover:hover {
            transform: scale(1.05);
        }
    </style>
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
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out nav-link-hover">Dashboard</a>
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

    <div>
        @yield('content')
    </div>
</body>
</html>