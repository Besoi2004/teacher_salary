<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            [
                'ten_ki' => 'HK1',
                'nam_hoc' => '2024-2025',
                'ngay_bat_dau' => '2024-09-01',
                'ngay_ket_thuc' => '2025-01-15',
                'is_active' => true,
                'ghi_chu' => 'Học kỳ 1 năm học 2024-2025'
            ],
            [
                'ten_ki' => 'HK2',
                'nam_hoc' => '2024-2025',
                'ngay_bat_dau' => '2025-02-01',
                'ngay_ket_thuc' => '2025-06-15',
                'is_active' => false,
                'ghi_chu' => 'Học kỳ 2 năm học 2024-2025'
            ],
            [
                'ten_ki' => 'HKH',
                'nam_hoc' => '2024-2025',
                'ngay_bat_dau' => '2025-07-01',
                'ngay_ket_thuc' => '2025-08-15',
                'is_active' => false,
                'ghi_chu' => 'Học kỳ hè năm học 2024-2025'
            ],
            [
                'ten_ki' => 'HK1',
                'nam_hoc' => '2025-2026',
                'ngay_bat_dau' => '2025-09-01',
                'ngay_ket_thuc' => '2026-01-15',
                'is_active' => false,
                'ghi_chu' => 'Học kỳ 1 năm học 2025-2026'
            ]
        ];

        foreach ($semesters as $semester) {
            \App\Models\Semester::create($semester);
        }
    }
}
