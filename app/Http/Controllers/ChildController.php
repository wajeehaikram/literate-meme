<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChildController extends Controller
{
    /**
     * Display a listing of the children for the authenticated parent.
     */
    public function index()
    {
        $children = Child::where('parent_id', Auth::id())->get();
        return view('parent.children.index', compact('children'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create()
    {
        return view('parent.children.add_child');
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year_group' => 'required|string',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'required|string',
            'exam_boards' => 'required|array',
            'exam_boards.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Format subjects with their exam boards
        $formattedSubjects = [];
        foreach ($request->subjects as $index => $subject) {
            if (isset($request->exam_boards[$index])) {
                $formattedSubjects[$subject] = $request->exam_boards[$index];
            }
        }

        Child::create([
            'parent_id' => Auth::id(),
            'name' => $request->name,
            'year_group' => $request->year_group,
            'subjects' => $formattedSubjects,
        ]);

        return redirect()->route('parent.dashboard')->with('success', 'Child added successfully!');
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(Child $child)
    {
        // Ensure the child belongs to the authenticated parent
        if ($child->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('parent.children.edit_child', compact('child'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, Child $child)
    {
        // Ensure the child belongs to the authenticated parent
        if ($child->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year_group' => 'required|string',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'required|string',
            'exam_boards' => 'required|array',
            'exam_boards.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Format subjects with their exam boards
        $formattedSubjects = [];
        foreach ($request->subjects as $index => $subject) {
            if (isset($request->exam_boards[$index])) {
                $formattedSubjects[$subject] = $request->exam_boards[$index];
            }
        }

        $child->update([
            'name' => $request->name,
            'year_group' => $request->year_group,
            'subjects' => $formattedSubjects,
        ]);

        return redirect()->route('parent.dashboard')->with('success', 'Child updated successfully!');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy($id)
    {
        $child = Child::findOrFail($id);
        $child->delete();

        return redirect()->route('parent.dashboard')->with('success', 'Child removed successfully.');
    }
}