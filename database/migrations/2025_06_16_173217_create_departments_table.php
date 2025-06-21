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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('ten_day_du'); // Tên đầy đủ
            $table->string('ten_viet_tat')->unique(); // Tên viết tắt
            $table->text('mo_ta_nhiem_vu')->nullable(); // Mô tả nhiệm vụ của khoa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
