<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TutorSimpleAvailability;
use Illuminate\Support\Facades\Auth;

class TutorSimpleAvailabilityController extends Controller
{
    /**
     * Store or update the tutor's simple availability.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $validatedData = $request->validate([
            'availability' => 'nullable|array',
            'availability.*' => 'nullable|array',
            'availability.*.*' => 'string', // Ensure time slots are strings
            'hours_per_week' => 'nullable|integer|min:0',
        ]);

        // Prepare availability data, ensuring keys are days and values are arrays of time slots
        $availabilityData = [];
        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $timeSlots = ['pre_12pm', '12_5pm', 'after_5pm'];

        foreach ($days as $day) {
            $availabilityData[$day] = [];
            if (isset($validatedData['availability'][$day])) {
                foreach ($validatedData['availability'][$day] as $timeSlot) {
                    // Only add valid time slots
                    if (in_array($timeSlot, $timeSlots)) {
                        $availabilityData[$day][] = $timeSlot;
                    }
                }
            }
        }

        // Use updateOrCreate to handle both creation and updates
        TutorSimpleAvailability::updateOrCreate(
            ['user_id' => $user->id],
            [
                'availability' => json_encode($availabilityData),
                'hours_per_week' => $validatedData['hours_per_week'] ?? null,
            ]
        );

        return redirect()->route('tutor.dashboard')->with('success', 'Availability updated successfully!');
    }
}