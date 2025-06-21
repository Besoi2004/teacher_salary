<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSubject extends Model
{
    protected $fillable = [
        'semester_id',
        'subject_id',
        'ma_lop',
        'ten_lop',
        'si_so_lop',
        'ghi_chu'
    ];

    /**
     * Quan hệ với kì học
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Quan hệ với học phần
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Quan hệ với phân công giảng viên
     */
    public function teachingAssignments(): HasMany
    {
        return $this->hasMany(TeachingAssignment::class);
    }

    /**
     * Lấy tên đầy đủ của lớp
     */
    public function getFullNameAttribute(): string
    {
        return $this->ma_lop . ' - ' . $this->ten_lop;
    }

    /**
     * Accessor methods để tương thích với controllers
     */
    public function getClassCodeAttribute()
    {
        return $this->ma_lop;
    }

    public function getClassNameAttribute()
    {
        return $this->ten_lop;
    }
}
