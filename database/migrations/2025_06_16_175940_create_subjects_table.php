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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('ma_so')->unique(); // Mã số học phần
            $table->string('ten_hoc_phan'); // Tên học phần
            $table->integer('so_tin_chi'); // Số tín chỉ
            $table->decimal('he_so_hoc_phan', 3, 2)->default(1.00); // Hệ số học phần
            $table->integer('so_tiet'); // Số tiết
            $table->text('mo_ta')->nullable(); // Mô tả
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
