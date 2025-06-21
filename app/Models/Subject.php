<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'ma_so',
        'ten_hoc_phan',
        'so_tin_chi',
        'he_so_hoc_phan',
        'so_tiet',
        'mo_ta'
    ];

    protected $casts = [
        'he_so_hoc_phan' => 'decimal:2'
    ];

    /**
     * Quan hệ với lớp học phần
     */
    public function classSubjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class);
    }
}
