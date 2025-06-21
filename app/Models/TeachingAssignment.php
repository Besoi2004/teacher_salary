<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingAssignment extends Model
{
    protected $fillable = [
        'teacher_id',
        'class_subject_id',
        'ghi_chu'
    ];

    /**
     * Quan hệ với giảng viên
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Quan hệ với lớp học phần
     */
    public function classSubject(): BelongsTo
    {
        return $this->belongsTo(ClassSubject::class);
    }

    /**
     * Lấy tên đầy đủ của phân công
     */
    public function getFullNameAttribute(): string
    {
        return $this->teacher->ho_ten . ' - ' . $this->classSubject->ma_lop;
    }

    /**
     * Tính lương đơn giản (có thể bỏ nếu không cần)
     */
    public function calculateSalary()
    {
        // Trả về 0 vì hệ thống không quản lý lương nữa
        return 0;
    }
}
