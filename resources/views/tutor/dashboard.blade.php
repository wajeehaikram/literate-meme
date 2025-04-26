@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Tutor Dashboard</h1>
                
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Welcome, {{ Auth::user()->name }}!</h2>
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
                    
                    <!-- Total Students -->
                    <div class="bg-green-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-green-800 mb-2">Total Students</h3>
                        <p class="text-3xl font-bold text-green-600">1</p>
                        <p class="text-sm text-green-600 mt-2">Active students</p>
                    </div>
                    
                    <!-- Hours Taught -->
                    <div class="bg-purple-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-purple-800 mb-2">Hours Taught</h3>
                        <p class="text-3xl font-bold text-purple-600">1</p>
                        <p class="text-sm text-purple-600 mt-2">This month</p>
                    </div>
                </div>
                
                <!-- Upcoming Sessions -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Upcoming Sessions</h2>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any upcoming sessions.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Availability Schedule -->
                <div class="mb-8">
                    <form id="availabilityForm" action="{{ route('tutor.availability.simple.store') }}" method="POST">
                        @csrf
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-medium text-gray-800">Set your availability</h2>
                            <div>
                                <button type="button" id="editScheduleBtn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">Edit Schedule</button>
                                <button type="submit" id="saveScheduleBtn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50" disabled>Save</button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Please indicate when you are usually free so that parents know roughly when you're available for lessons. You can still accept bookings at any time.</p>
                        
                        @php
                            $availability = Auth::user()->tutorSimpleAvailability ? json_decode(Auth::user()->tutorSimpleAvailability->availability, true) : [];
                            $hours = Auth::user()->tutorSimpleAvailability ? Auth::user()->tutorSimpleAvailability->hours_per_week : '';
                            $days = ['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'];
                            $timeSlots = [
                                'pre_12pm' => '<span class="mr-2">☀️</span> Pre 12pm',
                                '12_5pm' => '<span class="mr-2">🔆</span> 12 - 5pm',
                                'after_5pm' => '<span class="mr-2">🌙</span> After 5pm'
                            ];
                        @endphp

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4"></th>
                                        @foreach($days as $dayAbbr => $dayName)
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $dayName }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($timeSlots as $slotKey => $slotLabel)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{!! $slotLabel !!}</td>
                                            @foreach($days as $dayAbbr => $dayName)
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <input type="checkbox" name="availability[{{ $dayAbbr }}][]" value="{{ $slotKey }}" 
                                                           class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded availability-checkbox" 
                                                           {{ isset($availability[$dayAbbr]) && in_array($slotKey, $availability[$dayAbbr]) ? 'checked' : '' }}
                                                           disabled>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                    </form>
                </div>

                <!-- Recent Messages -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Recent Messages</h2>
                        <a href="{{ route('tutor.messages') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">View All</a>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        @if(isset($recentMessages) && $recentMessages->count() > 0)
                            <ul class="divide-y divide-gray-100">
                                @foreach($recentMessages as $msg)
                                    <li>
                                        <a href="{{ route('messages.show', $msg->sender_id) }}" class="flex items-center px-6 py-4 hover:bg-indigo-50 transition">
                                            <span class="font-semibold text-indigo-700 mr-2">{{ $msg->sender->name }}</span>
                                            <span class="text-gray-600 flex-1">{{ Str::limit($msg->content, 40) }}</span>
                                            <span class="ml-2 text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="p-6 text-center text-gray-500">
                                <p>You don't have any recent messages.</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div>
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('tutor.messages') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Messages</div>
                            <div class="text-sm text-gray-500 mt-1">Check your messages</div>
                        </a>
                        <a href="{{ route('tutor.bookings') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Bookings</div>
                            <div class="text-sm text-gray-500 mt-1">Manage your bookings</div>
                        </a>
                        <a href="{{ route('tutor.resources') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Resources</div>
                            <div class="text-sm text-gray-500 mt-1">Access teaching resources</div>
                        </a>
                        <a href="{{ route('tutor.profile.edit') }}" class="bg-white p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-300 text-center">
                            <div class="text-indigo-600 font-medium">Edit Profile</div>
                            <div class="text-sm text-gray-500 mt-1">Update your profile</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButton = document.getElementById('editScheduleBtn');
        const saveButton = document.getElementById('saveScheduleBtn');
        const checkboxes = document.querySelectorAll('.availability-checkbox');
        const hoursInput = document.getElementById('hours_per_week');
        const form = document.getElementById('availabilityForm');

        editButton.addEventListener('click', function() {
            // Enable all checkboxes and the hours input
            checkboxes.forEach(checkbox => checkbox.disabled = false);
            if (hoursInput) hoursInput.disabled = false;

            // Enable the save button
            saveButton.disabled = false;
        });

        // Enable save button if any checkbox changes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!saveButton.disabled) return;
                saveButton.disabled = false;
            });
        });
    });
</script>
@endpush

@endsection
