@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Parent Dashboard</h1>
                
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Welcome back, {{ Auth::check() ? Auth::user()->name : 'Guest' }}!</h2>
                    <p class="text-gray-600">Here's an overview of your tutoring activities.</p>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Upcoming Sessions -->
                    <div class="bg-indigo-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-indigo-800 mb-2">Upcoming Sessions</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ $upcomingSessionsCount ?? 0 }}</p>
                        <p class="text-sm text-indigo-600 mt-2">Next Month</p>
                    </div>
                    
                    <!-- Current Children -->
                    <div class="bg-green-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-green-800 mb-2">Current Children</h3>
                        @php
                            $childrenCount = App\Models\Child::where('parent_id', Auth::id())->count();
                        @endphp
                        <p class="text-3xl font-bold text-green-600">{{ $childrenCount }}</p>
                        <p class="text-sm text-green-600 mt-2">Registered children</p>
                    </div>
                    
                    <!-- Active Tutors -->
                    <div class="bg-purple-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-purple-800 mb-2">Active Tutors</h3>
                        <p class="text-3xl font-bold text-purple-600">1</p>
                        <p class="text-sm text-purple-600 mt-2">Current tutors</p>
                    </div>
                </div>


                <!-- My Children Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">My Children</h2>
                        <a href="{{ route('parent.children.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Child
                        </a>
                    </div>
                    
                    @php
                        $children = App\Models\Child::where('parent_id', Auth::id())->get();
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($children as $child)
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4 space-x-2">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ $child->name }}</h3>
                                            <p class="text-sm text-indigo-600">{{ $child->year_group }}</p>
                                        </div>
                                        <a href="{{ route('parent.children.edit', $child) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('parent.children.destroy', $child) }}" class="text-red-600 hover:text-red-800" onclick="event.preventDefault(); document.getElementById('delete-child-form-{{ $child->id }}').submit();">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                        <form id="delete-child-form-{{ $child->id }}" action="{{ route('parent.children.destroy', $child) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">Subjects</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($child->subjects as $subject => $examBoard)
                                                    <div class="px-2 py-1 text-xs bg-indigo-50 text-indigo-700 rounded-full">
                                                        {{ $subject }} ({{ $examBoard }})
                                                    </div>
                                                @empty
                                                    <p class="text-sm text-gray-500">No subjects selected</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <div class="p-6 text-center text-gray-500">
                                    <p>No children added yet. Click the "Add Child" button to get started.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tutor Profiles Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Available Tutors</h2>
                        <a href="{{ route('parent.browse-tutors') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                            View All
                        </a>
                    </div>
                    @php
                        $tutors = App\Models\User::whereHas('tutorProfile')
                            ->with(['tutorProfile'])
                            ->get();
                        $totalTutors = count($tutors);
                    @endphp
                    <div class="relative" style="z-index: 1;">
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-300 ease-in-out space-x-6" id="tutorCarousel" style="width: calc(100% * ceil({{ $totalTutors }} / 3)); position: relative; z-index: 1;">
                                <style>
                                    #tutorCarousel > div {
                                        flex: 0 0 calc(33.333% - 1rem);
                                    }
                                </style>
                                @forelse($tutors as $tutor)
                                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                        <div class="p-6">
                                            <div class="flex items-center mb-4">
                                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                                                    {{ strtoupper(substr($tutor->name, 0, 1)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-lg font-medium text-gray-900">{{ $tutor->name }}</h3>
                                                    <p class="text-sm text-indigo-600">£{{ number_format($tutor->tutorProfile->hourly_rate, 2) }}/hour</p>
                                                </div>
                                            </div>

                                            <div class="space-y-3">
                                                <div>
                                                    <p class="text-sm text-gray-600 line-clamp-3">{{ $tutor->tutorProfile->bio }}</p>
                                                </div>

                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900 mb-1">Subjects</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($tutor->tutorProfile->subjects as $subject)
                                                            <span class="px-2 py-1 text-xs bg-indigo-50 text-indigo-700 rounded-full">{{ $subject }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900 mb-1">Qualifications</h4>
                                                    <ul class="text-sm text-gray-600 list-disc list-inside">
                                                        @foreach($tutor->tutorProfile->qualifications as $qualification)
                                                            <li>{{ $qualification }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900 mb-1">Age Groups</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($tutor->tutorProfile->age_groups as $ageGroup)
                                                            <span class="px-2 py-1 text-xs bg-green-50 text-green-700 rounded-full">{{ $ageGroup }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 pt-4 border-t border-gray-100">
                                                <a href="{{ route('messages.show', $tutor->id) }}" class="inline-flex items-center justify-center w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                    </svg>
                                                    Contact Tutor
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full bg-white rounded-lg border border-gray-200 overflow-hidden">
                                        <div class="p-6 text-center text-gray-500">
                                            <p>No tutors are currently available.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            @if($totalTutors > 3)
                                <button onclick="slideTutors()" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-indigo-600 text-white rounded-full p-2 shadow-lg hover:bg-indigo-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            @endif

                            </div>
                        </div>
                    </div>
                                    <!-- Quick Actions -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('parent.bookings') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Bookings</div>
                            <div class="text-sm text-gray-500 mt-1">Manage tutoring sessions</div>
                        </a>
                        <a href="{{ route('parent.messages') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Messages</div>
                            <div class="text-sm text-gray-500 mt-1">Contact tutors</div>
                        </a>
                        <a href="{{ route('parent.payments') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Payments</div>
                            <div class="text-sm text-gray-500 mt-1">View payment history</div>
                        </a>
                    </div>
                </div>
                </div>
                

                <script>
                    let currentPosition = 0;
                    const tutorCards = document.querySelectorAll('#tutorCarousel > div');
                    const totalCards = tutorCards.length;
                    
                    function slideTutors() {
                        const carousel = document.getElementById('tutorCarousel');
                        currentPosition = (currentPosition + 3) % totalCards;
                        carousel.style.transform = `translateX(-${(currentPosition / 3) * 100}%)`;
                    }
                </script>

                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
