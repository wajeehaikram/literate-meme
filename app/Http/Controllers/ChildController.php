<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'year_group' => 'required|string|max:255',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
            'exam_boards' => 'array',
            'exam_boards.*' => 'required|string|max:255'
        ]);

        $child = Child::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'year_group' => $request->year_group,
        ]);
        
        // Attach subjects with exam boards if selected
        if ($request->has('subjects')) {
            $subjectsData = [];
            foreach ($request->subjects as $index => $subjectId) {
                $subjectsData[$subjectId] = [
                    'exam_board' => $request->exam_boards[$index]
                ];
            }
            $child->subjects()->attach($subjectsData);
        }

        if ($request->has('add_and_continue')) {
            return redirect()->route('parent.dashboard')->with('success', 'Child added successfully! You can add another child below.');
        }

        return redirect()->route('parent.dashboard')->with('success', 'Child added successfully!');
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(Child $child)
    {
        // Check if the child belongs to the authenticated user
        if ($child->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('parent.edit_child', compact('child'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, Child $child)
    {
        // Check if the child belongs to the authenticated user
        if ($child->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'year_group' => 'required|string|max:255',
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
            'exam_boards' => 'array',
            'exam_boards.*' => 'required|string|max:255'
        ]);

        $child->update([
            'name' => $request->name,
            'year_group' => $request->year_group,
        ]);
        
        // Sync subjects with exam boards if provided
        if ($request->has('subjects')) {
            $subjectsData = [];
            foreach ($request->subjects as $index => $subjectId) {
                $subjectsData[$subjectId] = [
                    'exam_board' => $request->exam_boards[$index]
                ];
            }
            $child->subjects()->sync($subjectsData);
        } else {
            // Remove all subjects if none selected
            $child->subjects()->detach();
        }

        return redirect()->route('parent.dashboard')->with('success', 'Child updated successfully!');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy(Child $child)
    {
        // Check if the child belongs to the authenticated user
        if ($child->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $child->delete();

        return redirect()->route('parent.dashboard')->with('success', 'Child removed successfully!');
    }
}