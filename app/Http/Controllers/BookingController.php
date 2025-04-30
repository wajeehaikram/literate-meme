// ... existing code ...
public function store(Request $request)
{
    $validated = $request->validate([
        'start_time' => 'required|date_format:H:i',
        // 'end_time' => 'required|date_format:H:i|after:start_time', // Remove end_time validation
        // ... other fields ...
    ]);

    $start = Carbon::parse($request->date.' '.$validated['start_time']);
    $end = (clone $start)->addHour();

    TutoringSession::create([
        'start_time' => $start,
        'end_time' => $end,
        // ... other fields ...
    ]);
}
// ... existing code ...