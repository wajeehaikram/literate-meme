@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Bookings</h1>
                
                <!-- Bookings Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Your Bookings</h2>
                        <div>
                            <a href="{{ route('parent.find-tutors') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                Book New Session
                            </a>
                        </div>
                    </div>
                    
                    <!-- Tabs for filtering bookings -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="border-b border-gray-200">
                            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                                <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Upcoming
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Past
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Cancelled
                                </a>
                            </nav>
                        </div>
                        
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any upcoming bookings.</p>
                            <p class="mt-2 text-sm">Book a session with one of our qualified tutors to get started.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Tips -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Booking Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Browse available tutors and their schedules</span></li>
                        <li><span class="text-gray-600">Book sessions at least 24 hours in advance</span></li>
                        <li><span class="text-gray-600">Check tutor reviews and ratings before booking</span></li>
                        <li><span class="text-gray-600">Cancel or reschedule at least 12 hours before the session</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection