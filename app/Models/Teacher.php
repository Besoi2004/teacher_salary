<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'ma_so',
        'ho_ten',
        'ngay_sinh',
        'dien_thoai',
        'email',
        'department_id',
        'degree_id'
    ];

    protected $casts = [
        'ngay_sinh' => 'date'
    ];

    /**
     * Quan hệ với khoa
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Quan hệ với bằng cấp
     */
    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    /**
     * Quan hệ với phân công giảng dạy
     */
    public function teachingAssignments(): HasMany
    {
        return $this->hasMany(TeachingAssignment::class);
    }

    /**
     * Tự động sinh mã số giáo viên
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($teacher) {
            if (empty($teacher->ma_so)) {
                $teacher->ma_so = 'GV' . str_pad(Teacher::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Accessor methods để tương thích với controllers
     */
    public function getFullNameAttribute()
    {
        return $this->ho_ten;
    }

    public function getTeacherIdAttribute()
    {
        return $this->ma_so;
    }

    public function getDateOfBirthAttribute()
    {
        return $this->ngay_sinh;
    }

    public function getPhoneAttribute()
    {
        return $this->dien_thoai;
    }
}
