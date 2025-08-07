<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student; // Assuming you have a Student model

class StudentController extends Controller
{
    //
    public function index(Request $request)
    {
        // $search = $request->input('search');

        $students = Student::with(['school', 'dayIndustry.day.event', 'dayIndustry.industry'])
        ->get()
        ->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'surname' => $student->surname,
                'email' => $student->email,
                'phone' => $student->phone,
                'id_number' => $student->id_number,
                'studentnum' => $student->studentnum,
                'grade' => $student->grade,
                'school' => $student->school->name ?? '-',
                'day' => $student->dayIndustry->day->name ?? '-',
                'industry' => $student->dayIndustry->industry->name ?? '-',
            ];
        });

    return view('admin.students.index', compact('students'));
    }
}
