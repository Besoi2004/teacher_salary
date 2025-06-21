<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeacherCoefficient;

class TeacherCoefficientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coefficients = [
            [
                'ten_bang_cap' => 'Cử nhân/Kỹ sư',
                'he_so' => 1.3,
                'mo_ta' => 'Hệ số dành cho giáo viên có bằng cử nhân/kỹ sư (trình độ đại học)',
                'trang_thai' => true
            ],
            [
                'ten_bang_cap' => 'Thạc sĩ',
                'he_so' => 1.5,
                'mo_ta' => 'Hệ số dành cho giáo viên có bằng thạc sĩ',
                'trang_thai' => true
            ],
            [
                'ten_bang_cap' => 'Tiến sĩ',
                'he_so' => 1.7,
                'mo_ta' => 'Hệ số dành cho giáo viên có bằng tiến sĩ',
                'trang_thai' => true
            ],
            [
                'ten_bang_cap' => 'Phó giáo sư',
                'he_so' => 2.0,
                'mo_ta' => 'Hệ số dành cho giáo viên có chức danh phó giáo sư',
                'trang_thai' => true
            ],
            [
                'ten_bang_cap' => 'Giáo sư',
                'he_so' => 2.5,
                'mo_ta' => 'Hệ số dành cho giáo viên có chức danh giáo sư',
                'trang_thai' => true
            ],
            [
                'ten_bang_cap' => 'Cao đẳng',
                'he_so' => 1.1,
                'mo_ta' => 'Hệ số dành cho giáo viên có bằng cao đẳng',
                'trang_thai' => false
            ]
        ];

        foreach ($coefficients as $coefficient) {
            TeacherCoefficient::create($coefficient);
        }
    }
}
