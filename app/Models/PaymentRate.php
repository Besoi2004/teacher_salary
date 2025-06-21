<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRate extends Model
{
    protected $fillable = [
        'ten_muc_luong',
        'gia_tien_moi_tiet',
        'mo_ta',
        'trang_thai'
    ];

    protected $casts = [
        'gia_tien_moi_tiet' => 'decimal:2',
        'trang_thai' => 'boolean'
    ];

    /**
     * Scope chỉ lấy các mức lương đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('trang_thai', true);
    }
}
