<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School; // Assuming you have a School model

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //view all schools
        $schools = School::all();
        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //create a new school
        return view('admin.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255'
        ]);

        School::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.schools.index')->with('success', 'School added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $school = School::findOrFail($id);
        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
        'name' => ['required','string','max:255'],
        ]);

        $school = School::findOrFail($id);
        $school->update($data);

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'School updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        //
        $school = School::findOrFail($id);

        try {
            $school->delete();
        } catch (\Throwable $e) {
            // Likely FK constraint (students still linked). Show a friendly message.
            if ($request->wantsJson()) {
                return response()->json(['ok' => false, 'message' => 'Cannot delete a school that has students assigned.'], 409);
            }
            return back()->with('error', 'Cannot delete a school that has students assigned.');
        }

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }
        return back()->with('success', 'School deleted successfully!');
    }
}
