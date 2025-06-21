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
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('ten_ki'); // Tên kì (HK1, HK2, HK3)
            $table->string('nam_hoc'); // Năm học (2024-2025)
            $table->date('ngay_bat_dau'); // Ngày bắt đầu
            $table->date('ngay_ket_thuc'); // Ngày kết thúc
            $table->boolean('is_active')->default(false); // Kì đang hoạt động
            $table->text('ghi_chu')->nullable(); // Ghi chú
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
