// ... existing code ...
public function store(Request $request)
{
    $validated = $request->validate([
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        // ... other fields ...
    ]);

    TutoringSession::create([
        'start_time' => Carbon::parse($request->date.' '.$validated['start_time']),
        'end_time' => Carbon::parse($request->date.' '.$validated['end_time']),
        // ... other fields ...
    ]);
}
// ... existing code ...