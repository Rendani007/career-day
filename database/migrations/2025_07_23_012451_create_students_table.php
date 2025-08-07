<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('name');
        $table->string('surname');
        $table->string('email')->unique()->nullable();
        $table->string('phone')->unique()->nullable();
        $table->string('id_number')->unique()->nullable();
        $table->string('studentnum')->unique();
        $table->string('grade');
        $table->uuid('school_id'); // foreign key
        $table->uuid('day_industry_id'); // foreign key
        $table->timestamps();

        // Foreign key constraints
        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        $table->foreign('day_industry_id')->references('id')->on('day_industries')->onDelete('cascade');

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
