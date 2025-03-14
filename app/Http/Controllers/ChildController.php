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
        $request->validate([
            'name' => 'required|string|max:255',
            'year_group' => 'required|string|max:255',
            'exam_board' => 'required|string|max:255',
        ]);

        $child = new Child([
            'name' => $request->name,
            'year_group' => $request->year_group,
            'exam_board' => $request->exam_board,
        ]);

        Auth::user()->children()->save($child);

        return redirect()->route('parent.dashboard')->with('success', 'Child added successfully!');
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(Child $child)
    {
        // Check if the child belongs to the authenticated user
        if ($child->parent_id !== Auth::id()) {
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
        if ($child->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'year_group' => 'required|string|max:255',
            'exam_board' => 'required|string|max:255',
        ]);

        $child->update([
            'name' => $request->name,
            'year_group' => $request->year_group,
            'exam_board' => $request->exam_board,
        ]);

        return redirect()->route('parent.dashboard')->with('success', 'Child updated successfully!');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy(Child $child)
    {
        // Check if the child belongs to the authenticated user
        if ($child->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $child->delete();

        return redirect()->route('parent.dashboard')->with('success', 'Child removed successfully!');
    }
}