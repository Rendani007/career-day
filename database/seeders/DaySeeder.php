<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Day::insert([
            ['name' => 'Day 1', 'event_date' => '2025-08-01'],
            ['name' => 'Day 2', 'event_date' => '2025-08-02'],
            ['name' => 'Day 3', 'event_date' => '2025-08-03'],
        ]);
    }
}
