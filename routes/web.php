<?php

use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\DayController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/auth/login');
});
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Students frontend registration
Route::get('/student-registration', [StudentRegistrationController::class, 'index'])->name('student-register');
Route::post('/students', [StudentRegistrationController::class, 'store'])->name('students.store');


Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Event dashboard & creation
    Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // Other Admin Routes
    Route::resource('/industries', IndustryController::class)->except(['show']);
    Route::resource('/days', DayController::class)->except(['show']);
    Route::resource('/students', StudentController::class)->only(['index', 'destroy']);
    Route::patch('/students/{student}/attendance',[StudentController::class, 'toggleAttendance'])->name('students.attendance');
    Route::get('/students-export', [StudentController::class, 'export'])->name('students.export');
    Route::resource('/schools', SchoolController::class);

    // Industry-Day assignments
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
});

// Profile routes (outside of admin prefix)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
