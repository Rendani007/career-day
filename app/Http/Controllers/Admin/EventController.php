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
        $events = Event::with(['days.industries'])
        ->orderByDesc('created_at')
        ->get();
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

    public function edit(Event $event){
        $event->load('days.industries');
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event){
        $data = $request->validate([
            'event_name'           => ['required','string','max:255'],
            'day_count'            => ['required','integer','min:1','max:10'],
            'industries'           => ['array'],             // day-indexed
            'industries.*'         => ['array'],             // list of strings per day
            'industries.*.*'       => ['nullable','string','max:255'],
        ]);

        DB::transaction(function () use ($event, $data) {
            //update event name
            $event->update(['name' => $data['event_name']]);

            // 2) Ensure the event has exactly N days (add/remove from the end)
            $currentDays = $event->days()->orderBy('id')->get();
            $have = $currentDays->count();
            $need = (int) $data['day_count'];

            if ($have < $need) {
            for ($i = $have + 1; $i <= $need; $i++) {
                $event->days()->create(['name' => "Day {$i}"]);
            }
        } elseif ($have > $need) {
            // delete extra days (and their pivot relations)
            $currentDays->slice($need)->each(function ($day) {
                $day->industries()->detach();
                $day->delete();
            });
        }

        // 3) Renumber/rename all days to Day 1..N for consistency
        $days = $event->days()->orderBy('id')->get();
        foreach ($days as $i => $day) {
            $expected = 'Day ' . ($i + 1);
            if ($day->name !== $expected) {
                $day->update(['name' => $expected]);
            }
        }

  // 4) Sync industries per day
        $days = $event->days()->orderBy('id')->get(); // refresh after potential changes
        foreach ($days as $i => $day) {
            $names = collect($data['industries'][$i] ?? [])
                ->map(fn ($s) => trim((string)$s))
                ->filter()               // drop blanks
                ->unique();

            if ($names->isEmpty()) {
                $day->industries()->sync([]); // remove all
                continue;
            }

            // find/create industries by name
            $existing = Industry::whereIn('name', $names)->get()->keyBy('name');
            $ids = [];
            foreach ($names as $n) {
                $ids[] = optional($existing->get($n))?->id
                    ?? Industry::create(['name' => $n])->id;
            }

            // sync pivot
            $day->industries()->sync($ids);
        }

        });

        // $event->update($data)
            return redirect()->route('admin.dashboard')->with('success', 'Event updated.');

    }
    public function delete(){

    }
}
