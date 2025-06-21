<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Degree;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = [
            [
                'ten_day_du' => 'Cử nhân/Kỹ sư',
                'ten_viet_tat' => 'CN/KS',
                'mo_ta' => 'Bằng cử nhân hoặc kỹ sư (trình độ đại học)'
            ],
            [
                'ten_day_du' => 'Thạc sĩ',
                'ten_viet_tat' => 'ThS',
                'mo_ta' => 'Bằng thạc sĩ khoa học hoặc thạc sĩ chuyên ngành'
            ],
            [
                'ten_day_du' => 'Tiến sĩ',
                'ten_viet_tat' => 'TS',
                'mo_ta' => 'Bằng tiến sĩ khoa học hoặc tiến sĩ chuyên ngành'
            ],
            [
                'ten_day_du' => 'Phó giáo sư',
                'ten_viet_tat' => 'PGS',
                'mo_ta' => 'Chức danh khoa học Phó giáo sư'
            ],
            [
                'ten_day_du' => 'Giáo sư',
                'ten_viet_tat' => 'GS',
                'mo_ta' => 'Chức danh khoa học Giáo sư'
            ],
            [
                'ten_day_du' => 'Cao đẳng',
                'ten_viet_tat' => 'CĐ',
                'mo_ta' => 'Bằng cao đẳng'
            ]
        ];

        foreach ($degrees as $degree) {
            Degree::create($degree);
        }
    }
}
