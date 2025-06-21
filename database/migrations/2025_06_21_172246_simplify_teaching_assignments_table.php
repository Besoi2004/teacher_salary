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
            // Loại bỏ các cột không cần thiết cho hệ thống đơn giản
            if (Schema::hasColumn('teaching_assignments', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('teaching_assignments', 'theory_hours_assigned')) {
                $table->dropColumn('theory_hours_assigned');
            }
            if (Schema::hasColumn('teaching_assignments', 'practice_hours_assigned')) {
                $table->dropColumn('practice_hours_assigned');
            }
            if (Schema::hasColumn('teaching_assignments', 'hourly_rate')) {
                $table->dropColumn('hourly_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_assignments', function (Blueprint $table) {
            // Khôi phục các cột đã xóa
            $table->string('role', 50)->default('primary')->after('class_subject_id');
            $table->integer('theory_hours_assigned')->default(0)->after('role');
            $table->integer('practice_hours_assigned')->default(0)->after('theory_hours_assigned');
            $table->decimal('hourly_rate', 10, 2)->default(150000)->after('practice_hours_assigned');
        });
    }
};
