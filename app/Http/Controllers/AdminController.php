<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\Degree;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\ClassSubject;
use App\Models\TeachingAssignment;

class AdminController extends Controller
{
    /**
     * Hiển thị trang chính quản trị
     */
    public function index()
    {
        $stats = [
            'total_teachers' => Teacher::count(),
            'total_departments' => Department::count(),
            'total_degrees' => Degree::count(),
            'total_subjects' => Subject::count(),
            'total_semesters' => Semester::count(),
            'total_class_subjects' => ClassSubject::count(),
            'total_assignments' => TeachingAssignment::count(),
        ];

        return view('admin.index', compact('stats'));
    }

    /**
     * Thống kê giáo viên
     */
    public function statistics()
    {
        $departmentStats = Department::withCount('teachers')->get();
        $degreeStats = Degree::withCount('teachers')->get();

        return view('admin.statistics', compact('departmentStats', 'degreeStats'));
    }
}
