<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Day;
use App\Models\Industry;
use App\Models\DayIndustry;
use DB;

class EventController extends Controller
{

     public function index()
    {
        $events = Event::with(['days.industries'])->latest()->get();
        return view('/admin/dashboard', compact('events'));
    }

    public function create()
    {
        return view('admin/create-event');
    }



    public function store(Request $request)
    {

        
        $request->validate([
            'event_name' => 'required|string|max:255',
            'day_count' => 'required|integer|min:1|max:10',
            'industries' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            // Create Event
            $event = Event::create([
                'id' => Str::uuid(),
                'name' => $request->event_name,
            ]);

            // Create Days and Industries
            for ($i = 0; $i < $request->day_count; $i++) {
                $day = Day::create([
                    'id' => Str::uuid(),
                    'name' => 'Day ' . ($i + 1),
                    'event_id' => $event->id,
                    'event_date' => now()->addDays($i),
                ]);

                $industriesForDay = $request->industries[$i] ?? [];

                foreach ($industriesForDay as $industryName) {
                    $industry = Industry::firstOrCreate(
                        ['name' => $industryName],
                        ['id' => Str::uuid()]
                    );

                    DayIndustry::create([
                        'id' => Str::uuid(),
                        'day_id' => $day->id,
                        'industry_id' => $industry->id,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create event: ' . $e->getMessage()]);
        }
    }
}
