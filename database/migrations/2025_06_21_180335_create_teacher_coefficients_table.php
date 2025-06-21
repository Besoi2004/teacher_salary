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
        Schema::create('teacher_coefficients', function (Blueprint $table) {
            $table->id();
            $table->string('ten_bang_cap', 100); // Tên bằng cấp (VD: "Đại học", "Thạc sĩ", "Tiến sĩ")
            $table->decimal('he_so', 5, 2); // Hệ số (VD: 1.3, 1.5, 1.7)
            $table->text('mo_ta')->nullable(); // Mô tả
            $table->boolean('trang_thai')->default(true); // Trạng thái hoạt động
            $table->timestamps();
            
            // Index để tăng tốc độ truy vấn
            $table->index('trang_thai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_coefficients');
    }
};
