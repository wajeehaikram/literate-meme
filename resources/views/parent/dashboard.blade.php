@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Parent Dashboard</h1>
        <p class="mt-2 text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
    </div>

    <div class="mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Children Management Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Children</h2>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                @forelse(Auth::user()->children as $child)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $child->name }}</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Year Group:</span>
                                    <span class="font-medium">{{ $child->year_group }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Exam Board:</span>
                                    <span class="font-medium">{{ $child->exam_board }}</span>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between">
                                <a href="{{ route('child.edit', $child->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                <form method="POST" action="{{ route('child.destroy', $child->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium" onclick="return confirm('Are you sure you want to remove this child?')">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6 text-center">
                            <p class="text-gray-500">You haven't added any children yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Add Child Form -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add a Child</h3>
                    <form method="POST" action="{{ route('child.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            
                            <div>
                                <label for="year_group" class="block text-sm font-medium text-gray-700">Year Group</label>
                                <select name="year_group" id="year_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Year Group</option>
                                    <option value="Reception">Reception</option>
                                    <option value="Year 1">Year 1</option>
                                    <option value="Year 2">Year 2</option>
                                    <option value="Year 3">Year 3</option>
                                    <option value="Year 4">Year 4</option>
                                    <option value="Year 5">Year 5</option>
                                    <option value="Year 6">Year 6</option>
                                    <option value="Year 7">Year 7</option>
                                    <option value="Year 8">Year 8</option>
                                    <option value="Year 9">Year 9</option>
                                    <option value="Year 10">Year 10</option>
                                    <option value="Year 11">Year 11</option>
                                    <option value="Year 12">Year 12</option>
                                    <option value="Year 13">Year 13</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="exam_board" class="block text-sm font-medium text-gray-700">Exam Board</label>
                                <select name="exam_board" id="exam_board" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Exam Board</option>
                                    <option value="AQA">AQA</option>
                                    <option value="Edexcel">Edexcel</option>
                                    <option value="OCR">OCR</option>
                                    <option value="WJEC">WJEC</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Add Child
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Upcoming Sessions Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Upcoming Sessions</h2>
                    <div class="space-y-4">
                        <p class="text-gray-500 text-sm">You don't have any upcoming sessions.</p>
                        <a href="{{ route('parent.find-tutors') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Find a Tutor
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h2>
                    <div class="space-y-3">
                        <p class="text-gray-500 text-sm">No recent activity to display.</p>
                    </div>
                </div>
            </div>

            <!-- Account Summary Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Account Type:</span>
                            <span class="font-medium">Parent</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-medium">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Member Since:</span>
                            <span class="font-medium">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Tutors Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Recommended Tutors</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <p class="text-gray-500 text-sm">No recommended tutors yet.</p>
                        <a href="{{ route('parent.find-tutors') }}" class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Browse all tutors
                            <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection