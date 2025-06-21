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
        Schema::table('teaching_assignments', function (Blueprint $table) {
            // Change 'role' to string for Vietnamese values
            if (Schema::hasColumn('teaching_assignments', 'role')) {
                $table->dropColumn('role');
            }
            $table->string('role', 50)->default('Giảng viên chính')->after('class_subject_id');
            $table->integer('theory_hours_assigned')->default(0)->after('role');
            $table->integer('practice_hours_assigned')->default(0)->after('theory_hours_assigned');
            $table->decimal('hourly_rate', 10, 2)->default(150000)->after('practice_hours_assigned');
            
            // Drop old columns that don't match our business logic
            $table->dropColumn(['so_gio_day', 'he_so_luong', 'tien_gio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_assignments', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->enum('role', ['primary', 'assistant'])->default('primary')->after('class_subject_id');
            // Restore old columns
            $table->decimal('so_gio_day', 8, 2)->default(0);
            $table->decimal('he_so_luong', 3, 2)->default(1.00);
            $table->decimal('tien_gio', 10, 2)->nullable();
            
            // Drop new columns
            $table->dropColumn(['role', 'theory_hours_assigned', 'practice_hours_assigned', 'hourly_rate']);
        });
    }
};
