<?php

namespace App\Http\Controllers;

use App\Models\TutorAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorAvailabilityController extends Controller
{
    public function index()
    {
        $tutor = Auth::user();
        $availabilities = $tutor->tutorAvailability()
            ->where('is_recurring', true)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
        
        // Format availabilities for the view
        $schedule = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach ($days as $day) {
            $schedule[$day] = [
                'Pre 12pm' => false,
                '12 - 5pm' => false,
                'After 5pm' => false
            ];
        }
        
        foreach ($availabilities as $availability) {
            $period = $this->getTimePeriod($availability->start_time);
            if ($period) {
                $schedule[$availability->day_of_week][$period] = true;
            }
        }
        
        return view('tutor.availability', compact('schedule'));
    }

    public function update(Request $request)
    {
        $tutor = Auth::user();
        
        // Delete existing recurring availability records
        $tutor->tutorAvailability()->where('is_recurring', true)->delete();
        
        // Process new availability data
        $availabilityData = $request->input('availability', []);
        
        foreach ($availabilityData as $day => $periods) {
            foreach ($periods as $period => $isAvailable) {
                if ($isAvailable) {
                    list($start, $end) = $this->getPeriodTimes($period);
                    // Ensure day_of_week is properly capitalized to match enum values
                    TutorAvailability::create([
                        'tutor_id' => $tutor->id,
                        'day_of_week' => ucfirst(strtolower($day)),
                        'start_time' => $start,
                        'end_time' => $end,
                        'is_recurring' => true,
                        'is_available' => true
                    ]);
                }
            }
        }
        
        return redirect()->route('tutor.dashboard')
            ->with('success', 'Availability schedule updated successfully!');
    }

    private function getTimePeriod(string $time): ?string
    {
        $hour = (int) substr($time, 0, 2);
        
        if ($hour < 12) {
            return 'Pre 12pm';
        } elseif ($hour < 17) {
            return '12 - 5pm';
        } else {
            return 'After 5pm';
        }
    }

    private function getPeriodTimes(string $period): array
    {
        // Convert period keys to match the form data format
        $period = str_replace(' ', '_', $period);
        
        switch ($period) {
            case 'Pre_12pm':
                return ['09:00:00', '12:00:00'];
            case '12_-_5pm':
                return ['12:00:00', '17:00:00'];
            case 'After_5pm':
                return ['17:00:00', '21:00:00'];
            default:
                return ['09:00:00', '17:00:00'];
        }
    }
}