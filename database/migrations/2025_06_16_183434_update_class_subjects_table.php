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
        Schema::table('class_subjects', function (Blueprint $table) {
            // Add missing columns for our business logic
            $table->integer('credits')->default(3)->after('ten_lop');
            $table->integer('theory_hours')->default(30)->after('credits');
            $table->integer('practice_hours')->default(15)->after('theory_hours');
            $table->integer('max_students')->default(40)->after('practice_hours');
            
            // Rename existing columns for consistency
            $table->renameColumn('so_sinh_vien', 'current_students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_subjects', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['credits', 'theory_hours', 'practice_hours', 'max_students']);
            
            // Restore original column name
            $table->renameColumn('current_students', 'so_sinh_vien');
        });
    }
};
