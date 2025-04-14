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
        <nav class="bg-white shadow-sm fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">LearnScape</a>
                    </div>
                    <div class="flex items-center space-x-8">
                        @auth
                            @if(Auth::user()->isTutor())
                                <a href="{{ route('tutor.dashboard') }}" class="text-gray-700 hover:text-indigo-600 transition">Home</a>
                                <a href="{{ route('tutor.messages') }}" class="text-gray-700 hover:text-indigo-600 transition">Messages</a>
                                <a href="{{ route('tutor.bookings') }}" class="text-gray-700 hover:text-indigo-600 transition">Bookings</a>
                                <a href="{{ route('tutor.resources') }}" class="text-gray-700 hover:text-indigo-600 transition">Resources</a>
                            @else
                                <a href="{{ route('parent.dashboard') }}" class="text-gray-700 hover:text-indigo-600 transition">Home</a>
                                <a href="{{ route('parent.messages') }}" class="text-gray-700 hover:text-indigo-600 transition">Messages</a>
                                <a href="{{ route('parent.bookings') }}" class="text-gray-700 hover:text-indigo-600 transition">Bookings</a>
                                <a href="{{ route('parent.payments') }}" class="text-gray-700 hover:text-indigo-600 transition">Payments</a>
                            @endif
                            <div class="relative flex flex-col items-end">
                                <span class="text-gray-700 font-medium mb-1">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="text-gray-700 hover:text-indigo-600 transition w-full text-right">Logout</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 transition">Home</a>
                            <a href="{{ route('about') }}" class="text-gray-700 hover:text-indigo-600 transition">About</a>
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 transition">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Get Started</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="pt-24 pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>
    <script src="//code.tidio.co/t3mk4s5lwurqkmeginnwlwytkpfya985.js" async></script>
</body>
</html>