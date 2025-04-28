@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Completed Payments</h1>
                
                @forelse($completedSessions as $session)
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $session->tutor->name }}</h3>
                                <p class="text-gray-600">{{ $session->tutorProfile->subject }}</p>
                            </div>
                            <span class="text-sm font-medium text-green-600">
                                Paid
                            </span>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-600">{{ $session->start_time->format('M j, Y g:i A') }} - {{ $session->end_time->format('g:i A') }}</p>
                            <p class="text-gray-900 font-medium mt-2">£{{ number_format($session->tutorProfile->hourly_rate, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No completed payments found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection