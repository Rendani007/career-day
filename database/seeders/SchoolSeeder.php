<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        School::insert([
            ['id' => Str::uuid(), 'name' => 'Phumlani High School'],
            ['id' => Str::uuid(), 'name' => 'Zwide Secondary'],
            ['id' => Str::uuid(), 'name' => 'Bophelo High'],
        ]);


    }
}
