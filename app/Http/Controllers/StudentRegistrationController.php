<?php

namespace App\Http\Controllers;

use App\Models\DayIndustry;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\Student; // Assuming you have a Student model

class StudentRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      //grabing all schools
        $schools = School::all();
        $dayIndustries = DayIndustry::with(['day.event', 'industry'])->get();
        return view('student-register', compact('schools', 'dayIndustries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'grade' => 'required|integer|between:8,12',
        'school_id' => 'required|uuid|exists:schools,id',
        'day_industry_id' => 'required|uuid|exists:day_industries,id',
        'studentnum' => 'required|integer|unique:students,studentnum',
        'email' => 'nullable|email|unique:students,email',
        'phone' => 'nullable|string|unique:students,phone',
        'id_number' => 'nullable|string|unique:students,id_number',
    ]);

    // Prevent duplicate registration
    $exists = Student::where('email', $request->email)
        ->orWhere('phone', $request->phone)
        ->orWhere('id_number', $request->id_number)
        ->orWhere('studentnum', $request->studentnum)
        ->exists();

    if ($exists) {
        return back()->withErrors(['duplicate' => 'You have already registered.']);
    }

    Student::create($validated);

    return redirect('/student-registration')->with([
        'success' => 'Registration successful!',
        'student_name' => $validated['name']
    ]);

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
