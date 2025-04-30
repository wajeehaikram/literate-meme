@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="chat-header">
                    {{ $otherUser->name }}
                    <span class="role">{{ $otherUser->user_type === 'tutor' ? 'Tutor' : 'Parent' }}</span>
                </div>
                <div class="card-body chat-container">
                    <div class="messages">
                        @foreach($messages as $message)
                            @php
                                $isBooking = false;
                                $bookingData = null;
                                // Try to decode content as JSON and check if it's a booking suggestion
                                try {
                                    $decoded = json_decode($message->content, true);
                                    if (is_array($decoded) && ($decoded['type'] ?? null) === 'booking_suggestion') {
                                        $isBooking = true;
                                        $bookingData = $decoded;
                                    }
                                } catch (Exception $e) {}
                            @endphp
                            @if($isBooking)
                                <div class="message mb-3 text-center">
                                    <div class="p-3 rounded-lg border border-indigo-400 bg-indigo-50 d-inline-block">
                                        <div>
                                            <span class="font-weight-bold" style="font-size:1.1rem;">
                                                {{ \Carbon\Carbon::parse($bookingData['date'])->format('l d M') }}
                                            </span>
                                            <span class="text-muted" style="font-size:0.95rem;">(UK Local time)</span>
                                        </div>
                                        @if(isset($bookingData['child_name']) && isset($bookingData['year_group']))
                                            <div class="mt-2">
                                                <span class="font-weight-bold">Child:</span> {{ $bookingData['child_name'] }} ({{ $bookingData['year_group'] }})
                                            </div>
                                        @endif
                                        @if(isset($bookingData['subject']))
                                            <div class="mt-2">
                                                <span class="font-weight-bold">Subject:</span> {{ $bookingData['subject'] }}
                                            </div>
                                        @endif
                                        <div class="mt-2">
                                            <span class="btn booking-suggestion-time">
                                                @if(isset($bookingData['time']))
                                                    {{ $bookingData['time'] }}
                                                @elseif(isset($bookingData['time_period']))
                                                    @if($bookingData['time_period'] === 'pre_12pm')
                                                        06:00am - 12:00pm
                                                    @elseif($bookingData['time_period'] === '12_-_5pm')
                                                        12:00pm - 5:00pm
                                                    @elseif($bookingData['time_period'] === 'after_5pm')
                                                        6:00pm - 11:00pm
                                                    @else
                                                        {{ $bookingData['time_period'] }}
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            Status: <span class="badge badge-{{ $bookingData['status'] === 'pending' ? 'warning' : ($bookingData['status'] === 'accepted' ? 'success' : 'danger') }}">
                                                {{ ucfirst($bookingData['status']) }}
                                            </span>
                                        </div>
                                        @if($bookingData['status'] === 'pending' && Auth::id() == $message->receiver_id)
                                            <div class="mt-2">
                                                @if($bookingData['status'] === 'pending' && Auth::id() == $message->receiver_id)
                                                    <div class="mt-2">
                                                        <div class="purple-action-box" style="background:#ede9fe;border:2px solid #6366f1;border-radius:10px;padding:16px 0 10px 0;display:inline-block;width:100%;max-width:350px;">
                                                            <form action="{{ route('messages.bookingResponse', $message->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <input type="hidden" name="response" value="accepted">
                                                                <button type="submit" class="btn btn-sm font-bold text-lg px-5 py-2" style="background:#6366f1;color:#fff;border:2px solid #4f46e5;border-radius:6px;margin-right:8px;">Accept</button>
                                                            </form>
                                                            <form action="{{ route('messages.bookingResponse', $message->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                                                                @csrf
                                                                <input type="hidden" name="response" value="declined">
                                                                <button type="submit" class="btn btn-sm font-bold text-lg px-5 py-2" style="background:#ede9fe;color:#6366f1;border:2px solid #6366f1;border-radius:6px;">Decline</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="mt-2">
                                                        <form action="{{ route('messages.bookingResponse', $message->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="response" value="accepted">
                                                            <button type="submit" class="btn btn-success btn-sm font-bold text-lg px-5 py-2 bg-green-600 hover:bg-green-700 shadow-lg border-2 border-green-800">Accept</button>
                                                        </form>
                                                        <form action="{{ route('messages.bookingResponse', $message->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                                                            @csrf
                                                            <input type="hidden" name="response" value="declined">
                                                            <button type="submit" class="btn btn-danger btn-sm font-bold text-lg px-5 py-2 bg-red-600 hover:bg-red-700 shadow-lg border-2 border-red-800">Decline</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="message-time small text-muted text-center">
                                        {{ $message->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            @else
                                <div class="msg-bubble {{ $message->sender_id === Auth::id() ? 'user' : 'other' }}">
                                    {{ $message->content }}
                                    <div class="msg-time {{ $message->sender_id === Auth::id() ? 'right' : 'left' }}">
                                        {{ $message->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="chat-input-area">
                    <form action="{{ route('messages.store') }}" method="POST" style="width:100%;display:flex;align-items:center;">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}" />
                        <input type="text" name="content" placeholder="Type your message..." autocomplete="off" required />
                        <button type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tutor Availability Schedule -->
@if(isset($schedule) && ($otherUser->user_type === 'tutor' || Auth::user()->user_type === 'tutor'))
<div class="availability-card">
    <div class="availability-title">Tutor Availability Schedule</div>
    <div class="availability-table-wrapper">
        <table class="availability-table">
            <thead>
                <tr>
                    <th class="period-header">TIME PERIOD</th>
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $index => $day)
                        <th class="day-header">{{ strtoupper(substr($day,0,3)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $periods = [
                        ['label' => 'Pre 12pm', 'key' => 'pre_12pm', 'icon' => '☀️'],
                        ['label' => '12 - 5pm', 'key' => '12_-_5pm', 'icon' => '⌚'],
                        ['label' => 'After 5pm', 'key' => 'after_5pm', 'icon' => '🌙']
                    ];
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                @endphp
                @foreach($periods as $period)
                <tr>
                    <td class="period-label">
                        <span class="period-icon">{{ $period['icon'] }}</span>
                        <span>{{ $period['label'] }}</span>
                    </td>
                    @foreach($days as $day)
                    <td class="day-cell">
                        @if(isset($schedule[$day][$period['key']]) && $schedule[$day][$period['key']])
                            <span class="avail-icon avail-yes">&#10003;</span>
                        @else
                            <span class="avail-icon avail-no">&#10005;</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Add gap between chat and booking box -->
<div style="height: 32px;"></div>

<!-- Suggest a Booking Time (Modal) -->
<div class="booking-card">
    <div class="booking-title">Suggest a Booking Time</div>
    <div class="booking-flex">
        <form id="suggestBookingForm" class="booking-form" method="POST" action="{{ route('messages.suggestBooking') }}">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
            <label for="child_id" class="booking-label">Select Child</label>
            <select id="child_id" name="child_id" class="form-select w-full rounded border-indigo-400 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 shadow-sm py-2 px-3 text-base text-gray-800 bg-white transition duration-150 ease-in-out" required style="margin-bottom: 1rem;">
                <option value="" disabled selected hidden>Choose a child</option>
                @php
                    $childList = isset($children) && $children ? $children : (Auth::user()->children ?? []);
                @endphp
                @foreach($childList as $child)
                    <option value="{{ $child->id }}">{{ $child->name }} ({{ $child->year_group }})</option>
                @endforeach
            </select>
            <div class="booking-row">
                <label for="subject" class="booking-label">Select Subject</label>
                <select id="subject" name="subject" class="form-select w-full rounded border-indigo-400 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 shadow-sm py-2 px-3 text-base text-gray-800 bg-white transition duration-150 ease-in-out" required disabled style="margin-bottom: 1rem;">
                    <option value="" disabled selected hidden>Choose a subject</option>
                </select>
            </div>
            <div class="booking-row">
                <label for="booking-date" class="booking-label">Date</label>
                <input type="date" class="booking-input" id="booking-date" name="booking_date" required>
            </div>
            <div class="booking-row booking-tabs-actions-row">
                <label class="booking-label">Time (UK time)</label>
                <div class="booking-tabs-actions">
                    <div class="booking-tabs" id="booking-tabs">
                        <button type="button" class="tab-btn" data-tab="tab-6-11">6am - 11am</button>
                        <button type="button" class="tab-btn" data-tab="tab-12-5">12pm - 5pm</button>
                        <button type="button" class="tab-btn" data-tab="tab-6-11pm">6pm - 11pm</button>
                    </div>
                    <div class="booking-actions">
                        <button type="submit" class="booking-submit-btn">Send Suggestion</button>
                    </div>
                </div>
            </div>
            <div class="booking-time-slots booking-time-slots-below">
                <div id="tab-6-11" class="tab-content">
                    <div class="time-grid">
                        @foreach([6,7,8,9,10,11] as $h)
                        @php
                            $start = date('g:i', strtotime($h . ':00'));
                            $end = date('g:i', strtotime(($h+1) . ':00'));
                            $start_ampm = date('a', strtotime($h . ':00'));
                            $end_ampm = date('a', strtotime(($h+1) . ':00'));
                        @endphp
                        <label class="time-slot-btn">
                            <input type="radio" name="booking_time" value="{{ sprintf('%02d:00-%02d:00', $h, $h+1) }}" class="sr-only time-slot-radio">
                            <span>{{ $start }}{{ $start_ampm }} - {{ $end }}{{ $end_ampm }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div id="tab-12-5" class="tab-content">
                    <div class="time-grid">
                        @foreach([12,13,14,15,16,17] as $h)
                        @php
                            $start = date('g:i', strtotime($h . ':00'));
                            $end = date('g:i', strtotime(($h+1) . ':00'));
                            $start_ampm = date('a', strtotime($h . ':00'));
                            $end_ampm = date('a', strtotime(($h+1) . ':00'));
                        @endphp
                        <label class="time-slot-btn">
                            <input type="radio" name="booking_time" value="{{ sprintf('%02d:00-%02d:00', $h, $h+1) }}" class="sr-only time-slot-radio">
                            <span>{{ $start }}{{ $start_ampm }} - {{ $end }}{{ $end_ampm }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div id="tab-6-11pm" class="tab-content">
                    <div class="time-grid">
                        @foreach([18,19,20,21,22,23] as $h)
                        @php
                            $start = date('g:i', strtotime($h . ':00'));
                            $end = date('g:i', strtotime(($h+1) . ':00'));
                            $start_ampm = date('a', strtotime($h . ':00'));
                            $end_ampm = date('a', strtotime(($h+1) . ':00'));
                        @endphp
                        <label class="time-slot-btn">
                            <input type="radio" name="booking_time" value="{{ sprintf('%02d:00-%02d:00', $h, $h+1) }}" class="sr-only time-slot-radio">
                            <span>{{ $start }}{{ $start_ampm }} - {{ $end }}{{ $end_ampm }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
const childSubjects = @json(collect($childList)->mapWithKeys(function($child) {
    return [$child->id => array_keys($child->subjects ?? [])];
}));

const childSelect = document.getElementById('child_id');
const subjectSelect = document.getElementById('subject');

childSelect.addEventListener('change', function() {
    const selectedId = this.value;
    subjectSelect.innerHTML = '<option value="">Choose a subject</option>';
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

<style>
    .chat-header {
        background: #4F46E5;
        color: #fff;
        padding: 18px 30px;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 1.15rem;
        letter-spacing: 0.5px;
    }
    .chat-header .role {
        font-size: 0.95rem;
        margin-left: 15px;
        opacity: 0.85;
        font-weight: 400;
    }
    .chat-container {
        height: 450px;
        overflow-y: auto;
        background: #f4f6fb;
        padding: 0;
    }
    .messages {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        padding: 25px 30px;
    }
    .msg-bubble {
        max-width: 60%;
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 1rem;
        position: relative;
        word-break: break-word;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .msg-bubble.user {
        align-self: flex-end;
        background: #4F46E5;
        color: #fff;
        border-bottom-right-radius: 6px;
    }
    .msg-bubble.other {
        align-self: flex-start;
        background: #fff;
        color: #232323;
        border-bottom-left-radius: 6px;
        border: 1px solid #ececec;
    }
    .msg-time {
        font-size: 0.87rem;
        color: #888;
        margin-top: 2px;
        margin-left: 3px;
        margin-right: 3px;
        text-align: right;
    }
    .msg-time.left {
        text-align: left;
    }
    .msg-time.right {
        text-align: right;
    }
    .chat-input-area {
        display: flex;
        align-items: center;
        border-top: 1px solid #e5e7eb;
        background: #fff;
        padding: 16px 30px;
    }
    .chat-input-area input[type="text"] {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        padding: 10px 14px;
        font-size: 1rem;
        outline: none;
        margin-right: 12px;
    }
    .chat-input-area button {
        background: #4F46E5;
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 8px 22px;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .chat-input-area button:hover {
        background: #3730a3;
    }
    .booking-tabs-actions-row {
        align-items: flex-start;
    }
    .booking-tabs-actions {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        gap: 20px;
        width: 100%;
    }
    .booking-tabs {
        flex: 1 1 auto;
        min-width: 0;
    }
    .booking-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 0;
        margin-left: 16px;
    }
    @media (max-width: 950px) {
        .booking-tabs-actions {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        .booking-actions {
            margin-left: 0;
            margin-top: 10px;
        }
    }
    /* AVAILABILITY CARD */
    .availability-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(80,88,120,0.06);
        padding: 32px 28px 24px 28px;
        margin: 32px 0 28px 0;
        max-width: 900px;
    }
    .availability-title {
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 18px;
        color: #333;
    }
    .availability-table-wrapper {
        overflow-x: auto;
    }
    .availability-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #f7f8fa;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .period-header,
    .day-header {
        background: #f1f2f7;
        color: #7b809a;
        font-weight: 500;
        font-size: 0.97rem;
        padding: 10px 0;
        text-align: center;
        border-bottom: 1.5px solid #e5e7eb;
    }
    .period-label {
        font-weight: 500;
        color: #444;
        padding: 10px 0 10px 8px;
        background: #f7f8fa;
        border-right: 1px solid #ececec;
        min-width: 120px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .period-icon {
        font-size: 1.2rem;
    }
    .day-cell {
        text-align: center;
        padding: 9px 0;
        background: #fff;
    }
    .avail-icon {
        display: inline-block;
        width: 24px;
        height: 24px;
        line-height: 24px;
        font-size: 1.1rem;
        border-radius: 50%;
    }
    .avail-yes {
        background: #e7fbe7;
        color: #1a7f37;
        border: 1px solid #b4e2b4;
    }
    .avail-no {
        background: #fde8e8;
        color: #d32f2f;
        border: 1px solid #f5bebe;
    }

    /* BOOKING CARD */
    .booking-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(80,88,120,0.06);
        padding: 32px 28px 30px 28px;
        margin: 0 0 32px 0;
        max-width: 900px;
    }
    .booking-title {
        font-size: 1.13rem;
        font-weight: 600;
        margin-bottom: 18px;
        color: #333;
    }
    .booking-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .booking-row {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .booking-label {
        min-width: 80px;
        font-size: 1rem;
        color: #555;
        font-weight: 500;
    }
    .booking-input {
        border: 1px solid #d1d5db;
        border-radius: 7px;
        padding: 9px 13px;
        font-size: 1rem;
        outline: none;
        background: #f7f8fa;
        width: 180px;
    }
    .booking-tabs {
        display: flex;
        flex-direction: row;
        border-radius: 7px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        margin-bottom: 0;
        background: #f7f8fa;
        width: 100%;
        max-width: 480px;
        min-width: 320px;
        justify-content: space-between;
    }
    .tab-btn {
        flex: 1;
        padding: 12px 0;
        background: #f7f8fa;
        border: none;
        font-weight: 500;
        color: #555;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
        border-right: 1px solid #e5e7eb;
        font-size: 1.02rem;
        white-space: nowrap;
        min-width: 100px;
        text-align: center;
        line-height: 1.1;
    }
    .tab-btn:last-child { border-right: none; }
    .tab-btn.active {
        background: #ede9fe;
        color: #4F46E5;
        font-weight: bold;
        border-bottom: 2px solid #4F46E5;
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .time-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 18px 18px;
        margin-top: 10px;
        width: 100%;
    }
    @media (max-width: 950px) {
        .time-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px 12px;
        }
    }
    .time-row {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
    }
    .time-slot-btn {
        display: inline-block;
        margin: 0;
    }
    .time-slot-btn input[type="radio"]:checked + span {
        background: #4F46E5;
        color: #fff;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(79,70,229,0.10);
    }
    .time-slot-btn span {
        display: inline-block;
        padding: 0.5rem 1.15rem;
        border-radius: 6px;
        background: #fff;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        font-size: 1rem;
        min-width: 60px;
        text-align: center;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    }
    .time-slot-btn span:hover {
        background: #ede9fe;
        color: #4F46E5;
    }
    .booking-actions {
        display: flex;
        justify-content: flex-end;
        gap: 14px;
        margin-top: 10px;
    }
    .booking-cancel-btn {
        background: #f6f6f6;
        color: #444;
        border: none;
        border-radius: 7px;
        padding: 8px 18px;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .booking-cancel-btn:hover {
        background: #ececec;
    }
    .booking-submit-btn {
        background: #4F46E5;
        color: #fff;
        border: none;
        border-radius: 7px;
        padding: 8px 22px;
        font-size: 1rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .booking-submit-btn:hover {
        background: #3730a3;
    }
    .booking-flex {
        display: flex;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
    }
    .booking-time-slots-below {
        margin-top: 24px;
        margin-left: 0 !important;
        max-width: 700px;
    }
    @media (max-width: 950px) {
        .booking-flex {
            flex-direction: column;
            gap: 18px;
        }
        .booking-time-slots-below {
            margin-top: 18px;
            max-width: 100%;
        }
    }
    body {
        margin-bottom: 0;
    }
    .main-content, .booking-card, .availability-card {
        padding-bottom: 48px !important;
    }
    .booking-suggestion-time {
        background: #ede9fe !important; /* light purple */
        color: #4F46E5 !important;    /* indigo text for contrast */
        font-weight: bold;
        font-size: 1.1rem;
        pointer-events: none;
        border: none;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
            document.getElementById(this.dataset.tab).classList.add('active');
            // Clear radio selection on tab switch
            document.querySelectorAll('.time-slot-radio').forEach(r => r.checked = false);
        });
    });
    // Highlight slot on select
    document.querySelectorAll('.time-slot-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.time-slot span').forEach(s => s.classList.remove('selected'));
            if (this.checked) {
                this.nextElementSibling.classList.add('selected');
            }
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatContainer = document.querySelector('.chat-container');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    const suggestBookingForm = document.getElementById('suggestBookingForm');
    if (suggestBookingForm) {
        suggestBookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const bookingDate = document.getElementById('booking-date').value;
            const bookingTimeRadio = document.querySelector('input[name="booking_time"]:checked');
            const bookingTime = bookingTimeRadio ? bookingTimeRadio.value : '';
            const receiverId = document.querySelector('input[name="receiver_id"]').value;
            const childId = document.getElementById('child_id').value;
            const subject = document.getElementById('subject').value;

            if (!bookingDate || !bookingTime || !childId || !subject) {
                alert('Please select a child, subject, date, and time slot.');
                return;
            }
            fetch("{{ route('messages.suggestBooking') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: receiverId,
                    booking_date: bookingDate,
                    booking_time: bookingTime,
                    child_id: childId,
                    subject: subject
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    suggestBookingForm.reset();
                    location.reload();
                } else {
                    alert('Failed to send suggestion.');
                }
            })
            .catch(() => {
                alert('Failed to send suggestion.');
            });
        });
    }
});
</script>
@push('scripts')
@endpush
@endsection