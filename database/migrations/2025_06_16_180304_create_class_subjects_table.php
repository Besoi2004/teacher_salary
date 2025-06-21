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
        Schema::create('class_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters')->onDelete('cascade'); // Thuộc kì
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // Thuộc học phần
            $table->string('ma_lop')->unique(); // Mã lớp
            $table->string('ten_lop'); // Tên lớp
            $table->integer('so_sinh_vien')->default(0); // Số sinh viên
            $table->text('ghi_chu')->nullable(); // Ghi chú
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_subjects');
    }
};
