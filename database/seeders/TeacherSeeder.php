<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'ho_ten' => 'Nguyễn Văn An',
                'email' => 'nguyenvanan@university.edu.vn',
                'dien_thoai' => '0901234567',
                'ngay_sinh' => '1980-05-15',
                'department_id' => 1, // CNTT
                'degree_id' => 3, // Tiến sĩ
            ],
            [
                'ho_ten' => 'Trần Thị Bình',
                'email' => 'tranthibinh@university.edu.vn',
                'dien_thoai' => '0912345678',
                'ngay_sinh' => '1985-08-20',
                'department_id' => 1, // CNTT
                'degree_id' => 2, // Thạc sĩ
            ],
            [
                'ho_ten' => 'Lê Minh Cường',
                'email' => 'leminhcuong@university.edu.vn',
                'dien_thoai' => '0923456789',
                'ngay_sinh' => '1975-12-10',
                'department_id' => 2, // Toán học
                'degree_id' => 3, // Tiến sĩ
            ],
            [
                'ho_ten' => 'Phạm Thị Dung',
                'email' => 'phamthidung@university.edu.vn',
                'dien_thoai' => '0934567890',
                'ngay_sinh' => '1983-03-25',
                'department_id' => 1, // CNTT
                'degree_id' => 2, // Thạc sĩ
            ],
            [
                'ho_ten' => 'Hoàng Văn Em',
                'email' => 'hoangvanem@university.edu.vn',
                'dien_thoai' => '0945678901',
                'ngay_sinh' => '1990-07-18',
                'department_id' => 2, // Toán học
                'degree_id' => 1, // Cử nhân
            ]
        ];

        foreach ($teachers as $teacher) {
            \App\Models\Teacher::create($teacher);
        }
    }
}
