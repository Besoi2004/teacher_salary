<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Degree extends Model
{
    protected $fillable = [
        'ten_day_du',
        'ten_viet_tat',
        'mo_ta'
    ];

    /**
     * Quan hệ với giáo viên
     */
    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }
}
