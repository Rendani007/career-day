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
        Schema::table('students', function (Blueprint $table) {
           try { $table->dropForeign(['school_id']); } catch (\Throwable $e) { /* ignore if not present */ }
        });
        // 2) Make school_id NULLable (pick the line that matches your column type)
        Schema::table('students', function (Blueprint $table) {
            // If you store UUIDs as char(36):
            $table->uuid('school_id')->nullable()->change();

            // If you use unsigned big int foreign keys:
            // $table->unsignedBigInteger('school_id')->nullable()->change();

            // If you used foreignUuid in Laravel 8+:
            // $table->foreignUuid('school_id')->nullable()->change();
        });

        // 3) Clean any values that don't exist in schools (or empty strings) to NULL
        DB::statement("
            UPDATE students s
            LEFT JOIN schools sch ON sch.id = s.school_id
            SET s.school_id = NULL
            WHERE sch.id IS NULL OR s.school_id = '' OR s.school_id = '0'
        ");

        // 4) Re-add FK with ON DELETE SET NULL
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->nullOnDelete();
            // Older Laravel alternative:
            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
            try { $table->dropForeign(['school_id']); } catch (\Throwable $e) {}
        });

    }
};
