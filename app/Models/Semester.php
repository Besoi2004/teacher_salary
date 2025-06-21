<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Semester extends Model
{
    protected $fillable = [
        'ten_ki',
        'nam_hoc',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'is_active',
        'ghi_chu'
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Quan hệ với lớp học phần
     */
    public function classSubjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class);
    }

    /**
     * Lấy tên đầy đủ của kì học
     */
    public function getFullNameAttribute(): string
    {
        return $this->ten_ki . ' - ' . $this->nam_hoc;
    }

    /**
     * Kiểm tra kì có đang hoạt động không
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope để lấy kì đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
