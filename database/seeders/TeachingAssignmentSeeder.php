<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeachingAssignment;
use App\Models\Teacher;
use App\Models\ClassSubject;

class TeachingAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $classSubjects = ClassSubject::all();

        if ($teachers->isEmpty() || $classSubjects->isEmpty()) {
            $this->command->info('Không có dữ liệu giáo viên hoặc lớp học phần. Vui lòng chạy seeder trước.');
            return;
        }

        $assignments = [
            [
                'teacher_id' => $teachers->get(0)->id ?? null,
                'class_subject_id' => $classSubjects->where('ma_lop', 'CS101_01')->first()->id ?? null,
                'ghi_chu' => 'Phụ trách lý thuyết và thực hành'
            ],
            [
                'teacher_id' => $teachers->get(1)->id ?? null,
                'class_subject_id' => $classSubjects->where('ma_lop', 'CS102_01')->first()->id ?? null,
                'ghi_chu' => 'Phụ trách toàn bộ môn học'
            ],
            [
                'teacher_id' => $teachers->get(2)->id ?? null,
                'class_subject_id' => $classSubjects->where('ma_lop', 'MATH101_01')->first()->id ?? null,
                'ghi_chu' => 'Phụ trách lớp toán cao cấp'
            ],
            [
                'teacher_id' => $teachers->get(0)->id ?? null,
                'class_subject_id' => $classSubjects->where('ma_lop', 'CS202_01')->first()->id ?? null,
                'ghi_chu' => 'Hỗ trợ thực hành cơ sở dữ liệu'
            ],
            [
                'teacher_id' => $teachers->get(3)->id ?? null,
                'class_subject_id' => $classSubjects->where('ma_lop', 'ENG101_01')->first()->id ?? null,
                'ghi_chu' => 'Phụ trách tiếng Anh chuyên ngành'
            ],
            [
                'teacher_id' => $teachers->get(4)->id ?? null,
                'class_subject_id' => $classSubjects->where('ma_lop', 'CS101_02')->first()->id ?? null,
                'ghi_chu' => 'Lớp song song lập trình C++'
            ]
        ];

        foreach ($assignments as $assignmentData) {
            if ($assignmentData['teacher_id'] && $assignmentData['class_subject_id']) {
                TeachingAssignment::create($assignmentData);
            }
        }

        // Thống kê
        $totalAssignments = TeachingAssignment::count();
        $this->command->info("=== THỐNG KÊ PHÂN CÔNG GIẢNG DẠY ===");
        $this->command->info("Tổng số phân công: {$totalAssignments}");
    }
}
