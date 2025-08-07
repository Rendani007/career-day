<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DayIndustry;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    //
    public function destroy($id){
        $assignment = DayIndustry::find($id);
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }
}
