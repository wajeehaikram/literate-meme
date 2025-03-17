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
                        <p class="text-3xl font-bold text-indigo-600">0</p>
                        <p class="text-sm text-indigo-600 mt-2">Next 7 days</p>
                    </div>
                    
                    <!-- Total Students -->
                    <div class="bg-green-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-green-800 mb-2">Total Students</h3>
                        <p class="text-3xl font-bold text-green-600">0</p>
                        <p class="text-sm text-green-600 mt-2">Active students</p>
                    </div>
                    
                    <!-- Hours Taught -->
                    <div class="bg-purple-50 rounded-lg p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        <h3 class="text-lg font-medium text-purple-800 mb-2">Hours Taught</h3>
                        <p class="text-3xl font-bold text-purple-600">0</p>
                        <p class="text-sm text-purple-600 mt-2">This month</p>
                    </div>
                </div>
                
                <!-- Upcoming Sessions -->
                <div class="mb-8">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Upcoming Sessions</h2>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any upcoming sessions.</p>
                            <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                Update Availability
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Messages -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Recent Messages</h2>
                        <a href="{{ route('tutor.messages') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</a>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="p-6 text-center text-gray-500">
                            <p>You don't have any recent messages.</p>
                        </div>
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
@endsection