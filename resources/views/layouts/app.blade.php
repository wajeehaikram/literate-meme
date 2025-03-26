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
    <link href="https://fonts.bunny.net/css?family=montserrat:700,800|poppins:600,700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .logo-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .logo-icon {
            animation: pulse 3s infinite alternate;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        
        /* Navbar link hover effect */
        .nav-link-hover {
            transition: transform 0.3s ease;
        }
        
        .nav-link-hover:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">LearnScape</a>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        @auth
                            @if(Auth::user()->isTutor())
                                <span onclick="window.location='{{ route('tutor.dashboard') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Home</span>
                                <span onclick="window.location='{{ route('tutor.messages') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Messages</span>
                                <span onclick="window.location='{{ route('tutor.bookings') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Bookings</span>
                                <span onclick="window.location='{{ route('tutor.resources') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Resources</span>
                            @else
                                <span onclick="window.location='{{ route('parent.dashboard') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Home</span>
                                <span onclick="window.location='{{ route('parent.messages') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Messages</span>
                                <span onclick="window.location='{{ route('parent.bookings') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Bookings</span>
                                <span onclick="window.location='{{ route('parent.payments') }}'; return false;" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Payments</span>
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
                            <span onclick="window.location='{{ route('about') }}'; return false;" class="text-sm text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 px-2 py-1 transition duration-300 ease-in-out cursor-pointer nav-link-hover">About</span>
                            <span onclick="window.location='{{ route('login') }}'; return false;" class="ml-4 text-sm text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 px-2 py-1 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Log in</span>
                            <span onclick="window.location='{{ route('register') }}'; return false;" class="ml-4 text-sm text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 focus:text-indigo-700 focus:border-b-2 focus:border-indigo-600 px-2 py-1 transition duration-300 ease-in-out cursor-pointer nav-link-hover">Register</span>
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
    <script src="//code.tidio.co/t3mk4s5lwurqkmeginnwlwytkpfya985.js" async></script>
</body>
</html>