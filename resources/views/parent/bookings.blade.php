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
                            <a href="http://127.0.0.1:8000/parent/browse-tutors" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-300">
                                Book New Session
                            </a>
                        </div>
                    </div>
                    <!-- Tabs for filtering bookings -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="border-b border-gray-200">
                            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                                <a href="{{ route('parent.bookings', ['tab' => 'upcoming']) }}" class="{{ request()->input('tab', 'upcoming') === 'upcoming' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Upcoming
                                </a>
                                <a href="{{ route('parent.bookings', ['tab' => 'past']) }}" class="{{ request()->input('tab') === 'past' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Past
                                </a>
                                <a href="{{ route('parent.bookings', ['tab' => 'cancelled']) }}" class="{{ request()->input('tab') === 'cancelled' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Cancelled
                                </a>
                            </nav>
                        </div>
                        <div class="p-6 text-center text-gray-500">
                            @if(request()->input('tab', 'upcoming') === 'upcoming')
                                @if($upcoming->count())
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($upcoming->where('status', '!=', 'cancelled') as $booking)
                                            <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between booking-item transition-opacity duration-500 mb-6 border-b border-gray-200" id="booking-{{ $booking->id }}">
                                                <div class="flex-1 text-left">
                                                    <div class="font-semibold text-gray-800">{{ $booking->subject ?? 'Tutoring Session' }}</div>
                                                    <div class="text-gray-600 text-sm">
                                                        {{ $booking->start_time->format('l, d M Y') }}
                                                        at {{ $booking->start_time->setTimezone('Europe/London')->format('H:i') }}
                                                        - {{ $booking->end_time->format('H:i') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-1">
                                                        Tutor: {{ $booking->tutor->name }}
                                                    </div>
                                                    <div class="text-indigo-600 text-xs mt-1">Status: {{ ucfirst($booking->status) }}</div>
                                                </div>
                                                <div class="flex items-center gap-2 mt-2 sm:mt-0">

                                                    @if($booking->status === 'scheduled')
                                                        <form action="{{ route('parent.cancelBooking', $booking->id) }}" method="POST" class="cancel-booking-form" data-booking-id="{{ $booking->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="ml-2 px-3 py-1 bg-red-600 text-gray-500 rounded hover:bg-red-700 transition-colors text-xs font-semibold shadow">Cancel</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>You don't have any upcoming bookings.</p>
                                    <p class="mt-2 text-sm">Book a session with one of our qualified tutors to get started.</p>
                                @endif
                            @elseif(request()->input('tab') === 'past')
                                @if($past->count())
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($past->where('status', '!=', 'cancelled') as $booking)
                                            <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between booking-item transition-opacity duration-500 mb-6 border-b border-gray-200" id="booking-{{ $booking->id }}">
                                                <div class="flex-1 text-left">
                                                    <div class="font-semibold text-gray-800">{{ $booking->subject ?? 'Tutoring Session' }}</div>
                                                    <div class="text-gray-600 text-sm">
                                                        {{ $booking->start_time->format('l, d M Y') }}
                                                        at {{ $booking->start_time->format('H:i') }}
                                                        - {{ $booking->end_time->format('H:i') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-1">
                                                        Tutor: {{ $booking->tutor->name }}
                                                    </div>
                                                    <div class="text-green-600 text-xs mt-1 flex justify-center">Status: Past</div>
                                                </div>
                                                <div class="flex items-center gap-2 mt-2 sm:mt-0">
                                                    @if($booking->is_paid)
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Paid</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>You don't have any past bookings.</p>
                                @endif
                            @elseif(request()->input('tab') === 'cancelled')
                                @if($cancelled->count())
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($cancelled as $booking)
                                            <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between booking-item transition-opacity duration-500 mb-6 border-b border-gray-200" id="booking-{{ $booking->id }}">
                                                <div class="flex-1 text-left">
                                                    <div class="font-semibold text-gray-800">{{ $booking->subject ?? 'Tutoring Session' }}</div>
                                                    <div class="text-gray-600 text-sm">
                                                        {{ $booking->start_time->format('l, d M Y') }}
                                                        at {{ $booking->start_time->format('H:i') }}
                                                        - {{ $booking->end_time->format('H:i') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-1">
                                                        Tutor: {{ $booking->tutor->name }}
                                                    </div>
                                                    <div class="text-red-600 text-xs mt-1">Status: Cancelled</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>You don't have any cancelled bookings.</p>
                                @endif
                            @endif
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.cancel-booking-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if(confirm('Are you sure you want to cancel this booking?')) {
                var bookingId = this.getAttribute('data-booking-id');
                var bookingItem = document.getElementById('booking-' + bookingId);
                bookingItem.style.opacity = '0';
                setTimeout(() => {
                    this.submit();
                }, 400);
            }
        });
    });
});
</script>