<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingAssignment extends Model
{
    protected $fillable = [
        'teacher_id',
        'class_subject_id',
        'role',
        'theory_hours_assigned',
        'practice_hours_assigned',
        'hourly_rate',
        'ghi_chu'
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2'
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
     * Tính lương tự động
     */
    public function calculateSalary()
    {
        $totalHours = $this->theory_hours_assigned + $this->practice_hours_assigned;
        return $totalHours * $this->hourly_rate;
    }

    /**
     * Boot method để xử lý events
     */
    protected static function boot()
    {
        parent::boot();
        // Có thể thêm logic auto-calculation nếu cần
    }
}
