<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DayIndustry;
use App\Models\Day;
use App\Models\Industry;
use Illuminate\Support\Str;

class DayIndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create sample industries
        $engineering = Industry::create(['id' => Str::uuid(), 'name' => 'Engineering']);
        $it = Industry::create(['id' => Str::uuid(), 'name' => 'IT']);
        $finance = Industry::create(['id' => Str::uuid(), 'name' => 'Finance']);

        // Sample date
        $today = now()->toDateString();

        // Create sample days (use existing event_id if you have one)
        $day1 = Day::create([
            'id' => Str::uuid(),
            'event_id' => Str::uuid(), // Replace with real event_id if needed
            'name' => 'Day 1',
            'event_date' => $today,
        ]);

        $day2 = Day::create([
            'id' => Str::uuid(),
            'event_id' => Str::uuid(),
            'name' => 'Day 2',
            'event_date' => now()->addDay()->toDateString(),
        ]);

        // Link them in day_industry
        DayIndustry::create(['id' => Str::uuid(), 'day_id' => $day1->id, 'industry_id' => $engineering->id]);
        DayIndustry::create(['id' => Str::uuid(), 'day_id' => $day1->id, 'industry_id' => $it->id]);
        DayIndustry::create(['id' => Str::uuid(), 'day_id' => $day2->id, 'industry_id' => $finance->id]);
    }
}
