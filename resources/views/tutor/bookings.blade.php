@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Bookings</h1>
                
                <!-- Upcoming Bookings Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Upcoming Bookings</h2>
                        <div>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                Update Availability
                            </button>
                        </div>
                    </div>
                    
                    <!-- Bookings List -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any upcoming bookings.</p>
                            <p class="mt-2 text-sm">When students book sessions with you, they will appear here.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Past Bookings -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Past Sessions</h2>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any past sessions.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Tips -->
                <div class="bg-indigo-50 rounded-lg p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-indigo-800 mb-2">Booking Tips</h3>
                    <ul class="list-disc pl-5 text-indigo-700 space-y-1">
                        <li><span class="text-gray-600">Keep your availability calendar up to date</span></li>
                        <li><span class="text-gray-600">Confirm bookings promptly</span></li>
                        <li><span class="text-gray-600">Prepare for sessions in advance</span></li>
                        <li><span class="text-gray-600">Send reminders to students before sessions</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection