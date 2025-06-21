<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'ten_day_du' => 'Khoa Công nghệ thông tin',
                'ten_viet_tat' => 'CNTT',
                'mo_ta_nhiem_vu' => 'Đào tạo và nghiên cứu trong lĩnh vực công nghệ thông tin, phần mềm, mạng máy tính'
            ],
            [
                'ten_day_du' => 'Khoa Kinh tế',
                'ten_viet_tat' => 'KT',
                'mo_ta_nhiem_vu' => 'Đào tạo chuyên ngành kinh tế, quản trị kinh doanh, tài chính ngân hàng'
            ],
            [
                'ten_day_du' => 'Khoa Toán - Tin',
                'ten_viet_tat' => 'TT',
                'mo_ta_nhiem_vu' => 'Đào tạo và nghiên cứu toán học ứng dụng và tin học'
            ],
            [
                'ten_day_du' => 'Khoa Điện - Điện tử',
                'ten_viet_tat' => 'DDT',
                'mo_ta_nhiem_vu' => 'Đào tạo kỹ sư điện, điện tử, tự động hóa và viễn thông'
            ],
            [
                'ten_day_du' => 'Khoa Ngoại ngữ',
                'ten_viet_tat' => 'NN',
                'mo_ta_nhiem_vu' => 'Đào tạo ngoại ngữ và văn hóa quốc tế cho sinh viên'
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
