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
        Schema::create('class_coefficients', function (Blueprint $table) {
            $table->id();
            $table->integer('tu_sv'); // Từ số sinh viên (VD: 0, 30, 50)
            $table->integer('den_sv'); // Đến số sinh viên (VD: 29, 49, 99)
            $table->decimal('he_so', 5, 2); // Hệ số lớp (VD: 0.2, 0.5, 1.0)
            $table->text('mo_ta')->nullable(); // Mô tả
            $table->boolean('trang_thai')->default(true); // Trạng thái hoạt động
            $table->timestamps();
            
            // Index để tăng tốc độ truy vấn
            $table->index(['tu_sv', 'den_sv']);
            $table->index('trang_thai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_coefficients');
    }
};
