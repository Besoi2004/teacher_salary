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
        Schema::create('payment_rates', function (Blueprint $table) {
            $table->id();
            $table->string('ten_muc_luong', 100); // Tên mức lương (VD: "Giảng viên", "Thạc sĩ", "Tiến sĩ")
            $table->decimal('gia_tien_moi_tiet', 10, 2); // Giá tiền mỗi tiết
            $table->text('mo_ta')->nullable(); // Mô tả
            $table->boolean('trang_thai')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_rates');
    }
};
