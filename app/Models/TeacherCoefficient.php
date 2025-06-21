<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCoefficient extends Model
{
    protected $fillable = [
        'ten_bang_cap',
        'he_so',
        'mo_ta',
        'trang_thai'
    ];

    protected $casts = [
        'he_so' => 'decimal:2',
        'trang_thai' => 'boolean'
    ];

    /**
     * Scope chỉ lấy các hệ số đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('trang_thai', true);
    }

    /**
     * Sắp xếp theo hệ số tăng dần
     */
    public function scopeOrderByCoefficient($query)
    {
        return $query->orderBy('he_so', 'asc');
    }
}
