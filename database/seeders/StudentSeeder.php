<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\School;
use App\Models\DayIndustry;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first(); // Get a valid school
        $dayIndustry = DayIndustry::first(); // Get a valid day_industry

        if (!$school || !$dayIndustry) {
            $this->command->error('Seed aborted: make sure School and DayIndustry records exist.');
            return;
        }

        Student::insert([
            [
                'id' => Str::uuid(),
                'school_id' => $school->id,
                'day_industry_id' => $dayIndustry->id,
                'name' => 'Lerato',
                'surname' => 'Mokoena',
                'grade' => 10,
                'studentnum' => 2023001,
                'email' => 'lerato@example.com',
                'phone' => '0821234567',
                'id_number' => '0001234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'school_id' => $school->id,
                'day_industry_id' => $dayIndustry->id,
                'name' => 'Thabo',
                'surname' => 'Nkosi',
                'grade' => 11,
                'studentnum' => 2023002,
                'email' => 'thabo@example.com',
                'phone' => '0832345678',
                'id_number' => '0002345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'school_id' => $school->id,
                'day_industry_id' => $dayIndustry->id,
                'name' => 'Naledi',
                'surname' => 'Pitso',
                'grade' => 12,
                'studentnum' => 2023003,
                'email' => 'naledi@example.com',
                'phone' => '0843456789',
                'id_number' => '0003456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
