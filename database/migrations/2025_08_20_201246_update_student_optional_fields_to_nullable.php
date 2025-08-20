<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, let's clean up any problematic data
        // Set any out-of-range studentnum values to null
        DB::statement('UPDATE students SET studentnum = NULL WHERE studentnum > 2147483647 OR studentnum < -2147483648');

        // Also set empty strings to null for consistency
        DB::statement("UPDATE students SET studentnum = NULL WHERE studentnum = '' OR studentnum = '0'");
        DB::statement("UPDATE students SET email = NULL WHERE email = ''");
        DB::statement("UPDATE students SET phone = NULL WHERE phone = ''");
        DB::statement("UPDATE students SET id_number = NULL WHERE id_number = ''");

        Schema::table('students', function (Blueprint $table) {
            // Use bigInteger instead of integer to handle larger values
            $table->bigInteger('studentnum')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('id_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->bigInteger('studentnum')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('id_number')->nullable(false)->change();
        });
    }
};
