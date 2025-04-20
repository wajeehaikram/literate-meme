<div class="multi-step-booking bg-gray-50 p-6 rounded-lg shadow mb-10">
    <h2 class="text-lg font-semibold text-indigo-800 mb-4">Suggest a Booking Time</h2>
    <form id="multiStepBookingForm" method="POST" action="{{ route('messages.suggestBooking') }}">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}" />
        <!-- Step 1: Select Child -->
        <div class="mb-4">
            <label for="child_id" class="block text-sm font-medium text-gray-700 mb-1">Select Child</label>
            <select id="child_id" name="child_id" class="form-select w-full rounded border-gray-300" required>
                <option value="">-- Choose a child --</option>
                @foreach(Auth::user()->children as $child)
                    <option value="{{ $child->id }}">{{ $child->name }} (Year {{ $child->year_group }})</option>
                @endforeach
            </select>
        </div>
        <!-- Step 2: Select Subject (populated by JS) -->
        <div class="mb-4">
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Select Subject</label>
            <select id="subject" name="subject" class="form-select w-full rounded border-gray-300" required disabled>
                <option value="">-- Choose a subject --</option>
            </select>
        </div>
        <!-- Step 3: Date and Time -->
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Select Date</label>
            <input type="date" id="date" name="date" class="form-input w-full rounded border-gray-300" required>
        </div>
        <div class="mb-4">
            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Select Time</label>
            <input type="time" id="time" name="time" class="form-input w-full rounded border-gray-300" required>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Submit Booking Request</button>
    </form>
</div>
<script>
// Map of child_id => subjects from backend
const childSubjects = @json(Auth::user()->children->mapWithKeys(function($child) {
    return [$child->id => array_keys($child->subjects ?? [])];
}));

const childSelect = document.getElementById('child_id');
const subjectSelect = document.getElementById('subject');

childSelect.addEventListener('change', function() {
    const selectedId = this.value;
    subjectSelect.innerHTML = '<option value="">-- Choose a subject --</option>';
    if (childSubjects[selectedId] && childSubjects[selectedId].length > 0) {
        childSubjects[selectedId].forEach(function(subject) {
            subjectSelect.innerHTML += `<option value="${subject}">${subject}</option>`;
        });
        subjectSelect.disabled = false;
    } else {
        subjectSelect.disabled = true;
    }
});
</script>
