<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Symfony\Component\HttpFoundation\StreamedResponse;// Assuming you have a Student model

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
    public function toggleAttendance(Request $request, Student $student){
       try {
            $request->validate([
                'attended' => 'required|boolean',
            ]);

            $student->attended = (bool) $request->boolean('attended');
            $student->checked_in_at = $student->attended ? now() : null;
            $student->save();

            return response()->json([
                'ok' => true,
                'attended' => $student->attended,
                'checked_in_at' => optional($student->checked_in_at)->toDateTimeString(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
    public function export(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $search = trim((string) $request->input('search', ''));

        $query = Student::with([
            'school',
            'dayIndustry.day',
            'dayIndustry.industry',
        ])
        ->when($search !== '', function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                // Student columns
                $qq->where('name', 'like', "%{$search}%")
                ->orWhere('surname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('id_number', 'like', "%{$search}%")
                ->orWhere('studentnum', 'like', "%{$search}%")
                ->orWhere('grade', 'like', "%{$search}%");

                // Related: school
                $qq->orWhereHas('school', function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%");
                });

                // Related: day name (e.g., "Day 1")
                $qq->orWhereHas('dayIndustry.day', function ($dq) use ($search) {
                    $dq->where('name', 'like', "%{$search}%");
                });

                // Related: industry name
                $qq->orWhereHas('dayIndustry.industry', function ($iq) use ($search) {
                    $iq->where('name', 'like', "%{$search}%");
                });
            });
        });

        $filename = 'students_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

            // Semicolon is Excel-friendly in many locales
            $delim = ';';

            fputcsv($out, [
                'Name','Surname','Email','Phone','ID Number','Student #','Grade',
                'School','Event Day','Industry','Attended','Checked In At'
            ], $delim);

            $query->chunk(500, function ($chunk) use ($out, $delim) {
                foreach ($chunk as $s) {
                    fputcsv($out, [
                        $s->name,
                        $s->surname,
                        $s->email,
                        $s->phone,
                        $s->id_number,
                        $s->studentnum,
                        $s->grade,
                        optional($s->school)->name,
                        optional(optional($s->dayIndustry)->day)->name,
                        optional(optional($s->dayIndustry)->industry)->name,
                        $s->attended ? 'Yes' : 'No',
                        optional($s->checked_in_at)->format('Y-m-d H:i:s'), // <= with cast, this works
                    ], $delim);
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

}
