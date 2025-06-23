<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassCoefficient extends Model
{
    protected $fillable = [
        'tu_sv',
        'den_sv', 
        'he_so',
        'mo_ta',
        'trang_thai'
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
        'he_so' => 'decimal:2'
    ];

    /**
     * Lấy hệ số dựa vào số sinh viên
     */
    public static function getCoefficientByStudentCount($studentCount)
    {
        return self::where('trang_thai', true)
                  ->where('tu_sv', '<=', $studentCount)
                  ->where('den_sv', '>=', $studentCount)
                  ->first();
    }

    /**
     * Kiểm tra khoảng số sinh viên có hợp lệ không
     */
    public function isValidRange()
    {
        return $this->tu_sv <= $this->den_sv;
    }

    /**
     * Lấy mô tả đầy đủ của khoảng
     */
    public function getRangeDescriptionAttribute()
    {
        return "Từ {$this->tu_sv} đến {$this->den_sv} sinh viên";
    }
}
