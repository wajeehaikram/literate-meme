// ... existing code ...
@foreach($upcoming as $booking)
    <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between">
        // ... existing booking details ...
    </li>
    @if(!$loop->last)
        <hr class="border-gray-200 my-2">
    @endif
@endforeach
// ... existing code ...

@foreach($past as $booking)
    <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between">
        // ... existing booking details ...
    </li>
    @if(!$loop->last)
        <hr class="border-gray-200 my-2">
    @endif
@endforeach
// ... existing code ...

@foreach($cancelled as $booking)
    <li class="p-4 flex flex-col sm:flex-row sm:items-center justify-between">
        // ... existing booking details ...
    </li>
    @if(!$loop->last)
        <hr class="border-gray-200 my-2">
    @endif
    // In cancelled bookings section:
    <form method="POST" action="{{ route('parent.cancelBooking', $booking->id) }}" class="mt-2">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs hover:bg-red-200">
            Cancel Booking
        </button>
    </form>
@endforeach
// ... existing code ...