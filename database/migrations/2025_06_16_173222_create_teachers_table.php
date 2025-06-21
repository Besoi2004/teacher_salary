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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('ma_so')->unique(); // Mã số giáo viên
            $table->string('ho_ten'); // Họ và tên
            $table->date('ngay_sinh'); // Ngày sinh
            $table->string('dien_thoai')->nullable(); // Điện thoại
            $table->string('email')->unique(); // Email
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade'); // Thuộc khoa
            $table->foreignId('degree_id')->constrained('degrees')->onDelete('cascade'); // Bằng cấp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
