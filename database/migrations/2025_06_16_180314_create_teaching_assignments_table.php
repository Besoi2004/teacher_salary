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
        Schema::create('teaching_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // Giảng viên
            $table->foreignId('class_subject_id')->constrained('class_subjects')->onDelete('cascade'); // Lớp học phần
            $table->decimal('so_gio_day', 8, 2)->default(0); // Số giờ dạy
            $table->decimal('he_so_luong', 3, 2)->default(1.00); // Hệ số lương
            $table->decimal('tien_gio', 10, 2)->nullable(); // Tiền giờ (tính toán)
            $table->text('ghi_chu')->nullable(); // Ghi chú
            $table->timestamps();
            
            // Ràng buộc unique: 1 giảng viên chỉ dạy 1 lớp 1 lần
            $table->unique(['teacher_id', 'class_subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaching_assignments');
    }
};
