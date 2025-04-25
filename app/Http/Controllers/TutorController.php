<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TutorController extends Controller
{
    /**
     * Display a listing of all tutors for parents to browse.
     *
     * @return \Illuminate\Http\Response
     */
    public function browse(Request $request)
    {
        // Debug: show incoming filter parameters
        if ($request->has('subjects') || $request->has('age_groups')) {
            Log::info('Browse filters', $request->all());
        }

        $query = User::where('user_type', 'tutor')->whereHas('tutorProfile')->with(['tutorProfile']);

        // Filter by subjects
        if ($request->has('subjects') && is_array($request->input('subjects')) && count($request->input('subjects')) > 0) {
            $subjects = $request->input('subjects');
            Log::info('Filtering by subjects (original)', $subjects);
            
            $normalizedSubjects = [];
            foreach ($subjects as $subject) {
                // Normalize subject names to match what's stored in the database
                $normalizedSubject = $subject;
                if ($subject === 'English Literature') {
                    $normalizedSubject = 'English';
                } else if ($subject === 'Mathematics') {
                    $normalizedSubject = 'Maths';
                }
                $normalizedSubjects[] = $normalizedSubject;
                
                // Also include the original subject name to handle both formats
                if (!in_array($subject, $normalizedSubjects) && ($subject === 'Mathematics' || $subject === 'English Literature')) {
                    $normalizedSubjects[] = $subject;
                }
            }
            
            Log::info('Filtering by subjects (normalized)', $normalizedSubjects);
            
            $query->whereHas('tutorProfile', function ($q) use ($normalizedSubjects) {
                $q->where(function($subQuery) use ($normalizedSubjects) {
                    foreach ($normalizedSubjects as $subject) {
                        $subQuery->orWhereJsonContains('subjects', $subject);
                    }
                });
            });
        }

        // Filter by age groups
        if ($request->has('age_groups') && is_array($request->input('age_groups')) && count($request->input('age_groups')) > 0) {
            $ageGroups = $request->input('age_groups');
            Log::info('Filtering by age_groups (original)', $ageGroups);
            
            $normalizedAgeGroups = [];
            foreach ($ageGroups as $group) {
                // Normalize age group names to match what's stored in the database
                $normalizedGroup = $group;
                if (str_contains($group, 'Primary School')) {
                    $normalizedGroup = 'Primary School';
                } else if (str_contains($group, 'Secondary School')) {
                    $normalizedGroup = 'Secondary School';
                } else if (str_contains($group, 'Sixth Form')) {
                    $normalizedGroup = 'Sixth Form';
                } else if (str_contains($group, 'University')) {
                    $normalizedGroup = 'University';
                }
                $normalizedAgeGroups[] = $normalizedGroup;
            }
            
            Log::info('Filtering by age_groups (normalized)', $normalizedAgeGroups);
            
            $query->whereHas('tutorProfile', function ($q) use ($normalizedAgeGroups) {
                $q->where(function($subQuery) use ($normalizedAgeGroups) {
                    foreach ($normalizedAgeGroups as $group) {
                        $subQuery->orWhereJsonContains('age_groups', $group);
                    }
                });
            });
        }

        $tutors = $query->get();
        Log::info('Tutors result count', ['count' => $tutors->count()]);
        return view('parent.browse-tutors', compact('tutors'));
    }
}