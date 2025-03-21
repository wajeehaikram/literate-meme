@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Parent Dashboard</h1>
                <p class="text-gray-600 mb-8">Welcome back, {{ Auth::check() ? Auth::user()->name : 'Guest' }}!</p>

                <!-- Children Management Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-medium text-gray-800">Your Children</h2>
                        <a href="{{ route('child.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Child
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                        @if(Auth::check())
                            @forelse(Auth::user()->children as $child)
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                    <div class="p-6">
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $child->name }}</h3>
                                        <div class="space-y-2 text-sm text-gray-600">
                                            <p><span class="font-medium">Year Group:</span> {{ $child->year_group }}</p>
                                            <div class="mt-3">
                                                <span class="font-medium">Subjects:</span>
                                                <ul class="mt-1 list-disc list-inside">
                                                    @foreach($child->subjects as $subject)
                                                        <div class="text-sm text-gray-600">{{ $subject->name }} - {{ $subject->pivot->exam_board }}</div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex justify-between">
                                            <a href="{{ route('child.edit', $child->id) }}" class="inline-flex items-center px-3 py-1.5 text-indigo-600 hover:text-indigo-900 transition-colors duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('child.destroy', $child->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-red-600 hover:text-red-900 transition-colors duration-300" onclick="return confirm('Are you sure you want to remove this child?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="p-6 text-center text-gray-500">
                                        <p>You haven't added any children yet.</p>
                                    </div>
                                </div>
                            @endforelse
                        @else
                            <div class="col-span-full bg-white rounded-lg border border-gray-200 overflow-hidden">
                                <div class="p-6 text-center text-gray-500">
                                    <p>Please log in to view your children.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection