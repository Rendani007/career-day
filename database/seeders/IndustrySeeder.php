<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Industry::insert([
            ['name' => 'Technology'],
            ['name' => 'Healthcare'],
            ['name' => 'Finance'],
            ['name' => 'Education'],
            ['name' => 'Manufacturing'],
            ['name' => 'Retail'],
            ['name' => 'Hospitality'],
            ['name' => 'Construction'],
            ['name' => 'Transportation'],
            ['name' => 'Entertainment'],
        ]);
    }
}
