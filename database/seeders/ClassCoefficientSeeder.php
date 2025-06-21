<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassCoefficient;

class ClassCoefficientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        $classCoefficients = [
            [
                'tu_sv' => 0,
                'den_sv' => 99,
                'he_so' => 0.2,
                'mo_ta' => 'Hệ số chuẩn cho tất cả lớp học từ 0 đến 99 sinh viên',
                'trang_thai' => true
            ]
        ];

        foreach ($classCoefficients as $coefficient) {
            ClassCoefficient::create($coefficient);
        }
    }
}
