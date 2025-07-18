<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classSubjects = [
            [
                'ma_lop' => 'CS101_01',
                'ten_lop' => 'Lập trình cơ bản - Lớp 01',
                'subject_id' => 1, // CS101
                'semester_id' => 1, // HK1 2024-2025
                'si_so_lop' => 35,
                'ghi_chu' => 'Lớp học cơ bản dành cho sinh viên năm nhất'
            ],
            [
                'ma_lop' => 'CS101_02',
                'ten_lop' => 'Lập trình cơ bản - Lớp 02',
                'subject_id' => 1, // CS101
                'semester_id' => 1, // HK1 2024-2025
                'si_so_lop' => 38,
                'ghi_chu' => 'Lớp học cơ bản dành cho sinh viên năm nhất'
            ],
            [
                'ma_lop' => 'CS102_01',
                'ten_lop' => 'Cấu trúc dữ liệu và giải thuật - Lớp 01',
                'subject_id' => 2, // CS102
                'semester_id' => 2, // HK2 2024-2025
                'si_so_lop' => 30,
                'ghi_chu' => 'Yêu cầu hoàn thành CS101'
            ],
            [
                'ma_lop' => 'MATH101_01',
                'ten_lop' => 'Toán cao cấp A1 - Lớp 01',
                'subject_id' => 6, // MATH101
                'semester_id' => 1, // HK1 2024-2025
                'si_so_lop' => 45,
                'ghi_chu' => 'Môn học cơ sở bắt buộc'
            ]
        ];

        foreach ($classSubjects as $classSubject) {
            \App\Models\ClassSubject::create($classSubject);
        }
    }
}
