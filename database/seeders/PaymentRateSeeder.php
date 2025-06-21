<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentRate;

class PaymentRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentRates = [
            [
                'ten_muc_luong' => 'Giảng viên chính',
                'gia_tien_moi_tiet' => 200000,
                'mo_ta' => 'Mức lương dành cho giảng viên chính, có kinh nghiệm từ 5 năm trở lên',
                'trang_thai' => true
            ],
            [
                'ten_muc_luong' => 'Thạc sĩ',
                'gia_tien_moi_tiet' => 150000,
                'mo_ta' => 'Mức lương dành cho giảng viên có bằng Thạc sĩ',
                'trang_thai' => true
            ],
            [
                'ten_muc_luong' => 'Tiến sĩ',
                'gia_tien_moi_tiet' => 250000,
                'mo_ta' => 'Mức lương dành cho giảng viên có bằng Tiến sĩ',
                'trang_thai' => true
            ],
            [
                'ten_muc_luong' => 'Giảng viên thỉnh giảng',
                'gia_tien_moi_tiet' => 120000,
                'mo_ta' => 'Mức lương dành cho giảng viên thỉnh giảng từ bên ngoài',
                'trang_thai' => true
            ],
            [
                'ten_muc_luong' => 'Giảng viên mới',
                'gia_tien_moi_tiet' => 100000,
                'mo_ta' => 'Mức lương dành cho giảng viên mới tốt nghiệp, chưa có kinh nghiệm',
                'trang_thai' => false
            ]
        ];

        foreach ($paymentRates as $rate) {
            PaymentRate::create($rate);
        }
    }
}
