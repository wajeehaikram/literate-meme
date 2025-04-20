<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\TutorAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TutoringSession;
use App\Models\Child;

class MessagesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            });

        // Get the user IDs from the conversations
        $userIds = $conversations->keys();
        
        // Get the user details for each conversation
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');
        
        // Determine which view to use based on user type
        if ($user->user_type === 'tutor') {
            $viewName = 'tutor.messages';
        } elseif ($user->user_type === 'parent') {
            $viewName = 'parent.messages';
        } else {
            $viewName = 'messages.index';
        }
        
        return view($viewName, compact('conversations', 'users'));
    }

    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        $messages = Message::where(function($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // If the other user is a tutor, get their availability schedule
        $schedule = null;
        if ($otherUser->user_type === 'tutor') {
            // Map short keys to full day names
            $dayMap = [
                'mon' => 'Monday',
                'tue' => 'Tuesday',
                'wed' => 'Wednesday',
                'thu' => 'Thursday',
                'fri' => 'Friday',
                'sat' => 'Saturday',
                'sun' => 'Sunday',
            ];
            $periodMap = [
                'pre_12pm' => 'pre_12pm',
                '12_5pm' => '12_-_5pm',
                'after_5pm' => 'after_5pm',
            ];
            $days = array_values($dayMap);
            $periods = array_values($periodMap);

            // Try to get new simple availability first
            $simpleAvailability = $otherUser->tutorSimpleAvailability;
            if ($simpleAvailability) {
                // Ensure availability is always an array
                $availabilityData = $simpleAvailability->availability;
                if (is_string($availabilityData)) {
                    $availabilityData = json_decode($availabilityData, true);
                }
                if (is_array($availabilityData)) {
                    $schedule = [];
                    foreach ($days as $day) {
                        $schedule[$day] = [
                            'pre_12pm' => false,
                            '12_-_5pm' => false,
                            'after_5pm' => false
                        ];
                    }
                    foreach ($availabilityData as $shortDay => $slots) {
                        if (!isset($dayMap[$shortDay])) continue;
                        $fullDay = $dayMap[$shortDay];
                        foreach ($slots as $slot) {
                            if (isset($periodMap[$slot])) {
                                $mappedPeriod = $periodMap[$slot];
                                $schedule[$fullDay][$mappedPeriod] = true;
                            }
                        }
                    }
                }
            } else {
                // Fallback to old method
                $schedule = [];
                foreach ($days as $day) {
                    $schedule[$day] = [
                        'pre_12pm' => false,
                        '12_-_5pm' => false,
                        'after_5pm' => false
                    ];
                }
                $availabilities = $otherUser->tutorProfile->availability ?? collect();
                foreach ($availabilities as $availability) {
                    $period = $this->getTimePeriod($availability->start_time);
                    $schedule[$availability->day_of_week][$period] = true;
                }
            }
        }

        return view('messages.show', compact('messages', 'otherUser', 'schedule'));
    }

    // Compose method removed as we're using direct chat instead

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        return redirect()->route('messages.show', $request->receiver_id)
            ->with('success', 'Message sent successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $exact = $request->input('exact', false);
        
        $usersQuery = User::where('id', '!=', Auth::id());
        
        if ($exact) {
            // If exact parameter is true, search by ID (for tutor selection from dashboard)
            $usersQuery->where('id', $query);
        } else {
            // Regular search by name or email
            $usersQuery->where(function($q) use ($query) {
                $q->where('email', 'like', "%{$query}%")
                  ->orWhere('name', 'like', "%{$query}%");
            });
        }
        
        $users = $usersQuery->take(5)->get(['id', 'name', 'email']);
        return response()->json($users);
    }
    
    private function getTimePeriod(string $time): ?string
    {
        $hour = (int) substr($time, 0, 2);
        
        if ($hour < 12) {
            return 'pre_12pm';
        } elseif ($hour < 17) {
            return '12_-_5pm';
        } else {
            return 'after_5pm';
        }
    }

    // Handle booking suggestion from tutor
    public function suggestBooking(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'child_id' => 'required|exists:children,id',
            'subject' => 'required|string',
        ]);

        // Get child name and year group
        $child = Child::find($request->child_id);

        $content = json_encode([
            'type' => 'booking_suggestion',
            'date' => $request->booking_date,
            'time_period' => $request->booking_time,
            'child_name' => $child ? $child->name : null,
            'year_group' => $child ? $child->year_group : null,
            'subject' => $request->subject,
            'status' => 'pending'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $content,
        ]);

        return response()->json(['success' => true, 'message_id' => $message->id]);
    }

    // Handle accept/decline of booking suggestion
    public function bookingResponse(Request $request, Message $message)
    {
        $request->validate([
            'response' => 'required|in:accepted,declined',
        ]);

        // Only the receiver can respond
        if (Auth::id() !== $message->receiver_id) {
            abort(403);
        }

        $content = json_decode($message->content, true);
        if (is_array($content) && ($content['type'] ?? null) === 'booking_suggestion') {
            $content['status'] = $request->response;
            $message->content = json_encode($content);
            $message->save();
            
            // Create TutoringSession if accepted and not already created
            if ($request->response === 'accepted') {
                // Check if a session already exists for this message (optional: add message_id to TutoringSession for strictness)
                $existing = TutoringSession::where('tutor_id', $message->sender_id)
                    ->where('parent_id', $message->receiver_id)
                    ->whereDate('start_time', $content['date'])
                    ->whereTime('start_time', '>=', $this->parseTimePeriod($content['time_period'])[0])
                    ->first();
                if (!$existing) {
                    $start = $this->parseTimePeriod($content['time_period'])[0];
                    $end = $this->parseTimePeriod($content['time_period'])[1];
                    $startDateTime = $content['date'] . ' ' . $start;
                    $endDateTime = $content['date'] . ' ' . $end;
                    TutoringSession::create([
                        'tutor_id' => $message->sender_id,
                        'parent_id' => $message->receiver_id,
                        'start_time' => $startDateTime,
                        'end_time' => $endDateTime,
                        'status' => 'scheduled', // Use allowed enum value
                        'subject' => $content['subject'] ?? '',
                        'session_fee' => 0,
                        'notes' => '',
                        'is_paid' => false,
                    ]);
                }
            }
        }

        return redirect()->back();
    }

    // Helper for time periods
    private function parseTimePeriod($period)
    {
        // Map your time periods to start/end times
        $map = [
            'pre_12pm' => ['09:00:00', '12:00:00'],
            '12_-_5pm' => ['12:00:00', '17:00:00'],
            'after_5pm' => ['17:00:00', '21:00:00'],
        ];
        if (isset($map[$period])) return $map[$period];
        if (preg_match('/(\d{1,2}:\d{2}) ?[ap]m ?- ?(\d{1,2}:\d{2}) ?[ap]m/i', $period, $m)) {
            return [$m[1], $m[2]];
        }
        return ['09:00:00', '10:00:00']; // fallback
    }

    public function sendSuggestion(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'suggestion_date' => 'required|date',
            'suggestion_time' => 'required|string',
        ]);
    
        $content = json_encode([
            'type' => 'suggestion',
            'date' => $request->suggestion_date,
            'time' => $request->suggestion_time,
        ]);
    
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $content,
        ]);
    
        return redirect()->route('messages.show', $request->receiver_id)
            ->with('success', 'Suggestion sent successfully!');
    }
}