<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'ma_so' => 'CS101',
                'ten_hoc_phan' => 'Lập trình cơ bản',
                'so_tin_chi' => 3,
                'he_so_hoc_phan' => 1.00,
                'so_tiet' => 45,
                'mo_ta' => 'Môn học cung cấp kiến thức cơ bản về lập trình máy tính'
            ],
            [
                'ma_so' => 'CS102',
                'ten_hoc_phan' => 'Cấu trúc dữ liệu và giải thuật',
                'so_tin_chi' => 4,
                'he_so_hoc_phan' => 1.20,
                'so_tiet' => 60,
                'mo_ta' => 'Môn học về các cấu trúc dữ liệu và thuật toán cơ bản'
            ],
            [
                'ma_so' => 'CS201',
                'ten_hoc_phan' => 'Lập trình hướng đối tượng',
                'so_tin_chi' => 3,
                'he_so_hoc_phan' => 1.10,
                'so_tiet' => 45,
                'mo_ta' => 'Môn học về phương pháp lập trình hướng đối tượng'
            ],
            [
                'ma_so' => 'CS202',
                'ten_hoc_phan' => 'Cơ sở dữ liệu',
                'so_tin_chi' => 3,
                'he_so_hoc_phan' => 1.15,
                'so_tiet' => 45,
                'mo_ta' => 'Môn học về thiết kế và quản lý cơ sở dữ liệu'
            ],
            [
                'ma_so' => 'CS301',
                'ten_hoc_phan' => 'Phát triển ứng dụng Web',
                'so_tin_chi' => 4,
                'he_so_hoc_phan' => 1.25,
                'so_tiet' => 60,
                'mo_ta' => 'Môn học về phát triển ứng dụng web hiện đại'
            ],
            [
                'ma_so' => 'MATH101',
                'ten_hoc_phan' => 'Toán cao cấp A1',
                'so_tin_chi' => 3,
                'he_so_hoc_phan' => 1.00,
                'so_tiet' => 45,
                'mo_ta' => 'Môn toán cơ bản cho ngành công nghệ thông tin'
            ],
            [
                'ma_so' => 'MATH102',
                'ten_hoc_phan' => 'Toán rời rạc',
                'so_tin_chi' => 3,
                'he_so_hoc_phan' => 1.05,
                'so_tiet' => 45,
                'mo_ta' => 'Môn học về toán rời rạc và logic'
            ],
            [
                'ma_so' => 'ENG101',
                'ten_hoc_phan' => 'Tiếng Anh chuyên ngành CNTT',
                'so_tin_chi' => 2,
                'he_so_hoc_phan' => 0.90,
                'so_tiet' => 30,
                'mo_ta' => 'Môn học tiếng Anh chuyên ngành công nghệ thông tin'
            ]
        ];

        foreach ($subjects as $subject) {
            \App\Models\Subject::create($subject);
        }
    }
}
