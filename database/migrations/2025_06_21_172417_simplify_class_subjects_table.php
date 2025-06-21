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
            // Loại bỏ các cột không cần thiết cho hệ thống đơn giản
            if (Schema::hasColumn('class_subjects', 'credits')) {
                $table->dropColumn('credits');
            }
            if (Schema::hasColumn('class_subjects', 'theory_hours')) {
                $table->dropColumn('theory_hours');
            }
            if (Schema::hasColumn('class_subjects', 'practice_hours')) {
                $table->dropColumn('practice_hours');
            }
            if (Schema::hasColumn('class_subjects', 'max_students')) {
                $table->dropColumn('max_students');
            }
            if (Schema::hasColumn('class_subjects', 'current_students')) {
                $table->dropColumn('current_students');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_subjects', function (Blueprint $table) {
            // Khôi phục các cột đã xóa
            $table->integer('credits')->default(3)->after('ten_lop');
            $table->integer('theory_hours')->default(30)->after('credits');
            $table->integer('practice_hours')->default(15)->after('theory_hours');
            $table->integer('max_students')->default(40)->after('practice_hours');
            $table->integer('current_students')->default(0)->after('max_students');
        });
    }
};
