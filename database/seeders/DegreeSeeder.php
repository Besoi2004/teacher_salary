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
                'ten_day_du' => 'Tiến sĩ Công nghệ thông tin',
                'ten_viet_tat' => 'TS.CNTT',
                'mo_ta' => 'Bằng tiến sĩ chuyên ngành Công nghệ thông tin'
            ],
            [
                'ten_day_du' => 'Thạc sĩ Khoa học máy tính',
                'ten_viet_tat' => 'ThS.KHMT',
                'mo_ta' => 'Bằng thạc sĩ chuyên ngành Khoa học máy tính'
            ],
            [
                'ten_day_du' => 'Kỹ sư Điện tử Viễn thông',
                'ten_viet_tat' => 'KS.DTVT',
                'mo_ta' => 'Bằng kỹ sư chuyên ngành Điện tử Viễn thông'
            ],
            [
                'ten_day_du' => 'Cử nhân Kinh tế',
                'ten_viet_tat' => 'CN.KT',
                'mo_ta' => 'Bằng cử nhân chuyên ngành Kinh tế'
            ],
            [
                'ten_day_du' => 'Tiến sĩ Toán học',
                'ten_viet_tat' => 'TS.TH',
                'mo_ta' => 'Bằng tiến sĩ chuyên ngành Toán học'
            ]
        ];

        foreach ($degrees as $degree) {
            Degree::create($degree);
        }
    }
}
