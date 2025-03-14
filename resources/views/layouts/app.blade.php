<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LearnScape') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <span class="text-xl font-bold text-indigo-600">LearnScape</span>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        @auth
                            @if(Auth::user()->isTutor())
                                <span onclick="window.location='{{ route('tutor.dashboard') }}'" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Home</span>
                                <span onclick="window.location='{{ route('tutor.messages') }}'" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Messages</span>
                                <span onclick="window.location='{{ route('tutor.bookings') }}'" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Bookings</span>
                                <span onclick="window.location='{{ route('tutor.resources') }}'" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Resources</span>
                            @else
                                <span onclick="window.location='{{ route('parent.dashboard') }}';" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Home</span>
                                <span onclick="window.location='{{ route('parent.messages') }}'" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Messages</span>
                                <span onclick="window.location='{{ route('parent.bookings') }}'; " class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Bookings</span>
                                <span onclick="window.location='{{ route('parent.payments') }}';" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer">Payments</span>
                            @endif
                        @endauth
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="relative">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 focus:text-indigo-700 transition duration-300 ease-in-out">
                                    {{ Auth::user()->name }}
                                </button>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="ml-4 text-sm text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 focus:text-indigo-700 px-2 py-1 rounded transition duration-300 ease-in-out">Logout</button>
                                </form>
                            </div>
                        @else
                            <span onclick="window.location='{{ route('about') }}'" class="text-sm text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 px-2 py-1 transition duration-300 ease-in-out cursor-pointer">About</span>
                            <span onclick="window.location='{{ route('login') }}'" class="ml-4 text-sm text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 px-2 py-1 transition duration-300 ease-in-out cursor-pointer">Log in</span>
                            <span onclick="window.location='{{ route('register') }}'" class="ml-4 text-sm text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 px-2 py-1 transition duration-300 ease-in-out cursor-pointer">Register</span>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>