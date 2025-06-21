<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Teacher;
use App\Models\TeachingAssignment;
use App\Models\PaymentRate;
use App\Models\TeacherCoefficient;
use App\Models\ClassCoefficient;
use App\Models\Department;
use Illuminate\Http\Request;

class SalaryCalculationController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        $teachers = Teacher::with('department')->orderBy('ho_ten')->get();
        
        return view('admin.salary-calculation.index', compact('semesters', 'teachers'));
    }    public function calculate(Request $request)
    {
        try {
            $request->validate([
                'semester_id' => 'required|exists:semesters,id',
                'teacher_id' => 'required|exists:teachers,id'
            ]);

            $semester = Semester::findOrFail($request->semester_id);
            $teacher = Teacher::with(['department', 'degree'])->findOrFail($request->teacher_id);

            // Lấy tất cả phân công của giáo viên trong học kỳ
            $assignments = TeachingAssignment::with([
                'classSubject.subject',
                'classSubject.semester'
            ])
            ->whereHas('classSubject', function($query) use ($request) {
                $query->where('semester_id', $request->semester_id);
            })
            ->where('teacher_id', $request->teacher_id)
            ->get();

        if ($assignments->isEmpty()) {
            return back()->with('error', 'Không tìm thấy phân công giảng dạy cho giáo viên này trong học kỳ đã chọn.');
        }        // Lấy hệ số giáo viên dựa trên bằng cấp
        $teacherCoefficient = TeacherCoefficient::where('ten_bang_cap', $teacher->degree->ten_day_du)
                                                ->where('trang_thai', true)
                                                ->first();
        
        if (!$teacherCoefficient) {
            return back()->with('error', 'Không tìm thấy hệ số cho bằng cấp: ' . $teacher->degree->ten_day_du);
        }

        // Lấy tiền dạy một tiết (lấy mức đầu tiên đang hoạt động)
        $paymentRate = PaymentRate::where('trang_thai', true)->first();
        
        if (!$paymentRate) {
            return back()->with('error', 'Không tìm thấy mức tiền dạy một tiết.');
        }

        $calculations = [];
        $totalSalary = 0;
        $stt = 1;

        foreach ($assignments as $assignment) {
            $classSubject = $assignment->classSubject;
            $subject = $classSubject->subject;            // Lấy hệ số lớp dựa trên số sinh viên
            $soSinhVien = $classSubject->si_so_lop ?? 0; // Default to 0 if null
            
            $classCoefficient = ClassCoefficient::where('tu_sv', '<=', $soSinhVien)
                                                ->where('den_sv', '>=', $soSinhVien)
                                                ->where('trang_thai', true)
                                                ->first();
            
            if (!$classCoefficient) {
                // Nếu không tìm thấy hệ số lớp phù hợp, dùng hệ số mặc định
                $classCoefficient = (object)[
                    'he_so' => 1.0,
                    'mo_ta' => 'Hệ số mặc định'
                ];
            }            // Tính toán theo công thức
            // Số tiết quy đổi = Số tiết thực tế * (hệ số học phần + hệ số lớp)
            $soTietThucTe = $subject->so_tiet; // Lấy số tiết từ subject
            $soTietQuiDoi = $soTietThucTe * ($subject->he_so_hoc_phan + $classCoefficient->he_so);
            
            // Tiền dạy mỗi lớp = số tiết quy đổi * hệ số giáo viên * tiền dạy một tiết
            $tienDayMotLop = $soTietQuiDoi * $teacherCoefficient->he_so * $paymentRate->gia_tien_moi_tiet;

            $calculations[] = [
                'stt' => $stt++,
                'ma_lop' => $classSubject->ma_lop,
                'ten_lop' => $classSubject->ten_lop,
                'ten_hoc_phan' => $subject->ten_hoc_phan,
                'so_tiet' => $soTietThucTe,
                'so_sinh_vien' => $soSinhVien,
                'he_so_hoc_phan' => $subject->he_so_hoc_phan,
                'he_so_lop' => $classCoefficient->he_so,
                'tiet_quy_doi' => round($soTietQuiDoi, 2),
                'he_so_gv' => $teacherCoefficient->he_so,
                'tien_mot_tiet' => $paymentRate->gia_tien_moi_tiet,
                'tien_day' => round($tienDayMotLop, 0)
            ];

            $totalSalary += $tienDayMotLop;
        }

        return view('admin.salary-calculation.result', compact(
            'semester', 
            'teacher', 
            'calculations',            'totalSalary',
            'teacherCoefficient',
            'paymentRate'
        ));
        
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }    /**
     * Báo cáo tiền dạy giáo viên trong 1 năm
     */
    public function teacherYearlyReport(Request $request)
    {
        $teachers = Teacher::with('department')->orderBy('ho_ten')->get();
        $years = Semester::select('nam_hoc')->distinct()->orderBy('nam_hoc', 'desc')->get();
        
        $reportData = null;
        
        if ($request->filled('teacher_id') && $request->filled('year')) {
            $teacher = Teacher::with(['department', 'degree'])->findOrFail($request->teacher_id);
            $year = $request->year;
            
            // Lấy tất cả học kỳ trong năm
            $semesters = Semester::where('nam_hoc', $year)->orderBy('ten_ki')->get();
            
            $semesterReports = [];
            $totalYear = 0;
            
            foreach ($semesters as $semester) {
                $semesterData = $this->calculateTeacherSemesterSalary($teacher->id, $semester->id);
                if ($semesterData['total'] > 0) {
                    $semesterReports[] = [
                        'semester' => $semester,
                        'classes_count' => $semesterData['classes_count'],
                        'total_hours' => $semesterData['total_hours'],
                        'total_salary' => $semesterData['total'],
                        'details' => $semesterData['details']
                    ];
                    $totalYear += $semesterData['total'];
                }
            }
            
            $reportData = [
                'teacher' => $teacher,
                'year' => $year,
                'semesters' => $semesterReports,
                'total_year' => $totalYear
            ];
        }
        
        return view('admin.reports.teacher-yearly', compact('teachers', 'years', 'reportData'));
    }
      /**
     * Báo cáo tiền dạy giáo viên 1 khoa
     */    public function departmentReport(Request $request)
    {
        $departments = Department::orderBy('ten_day_du')->get();
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        
        $reportData = null;
        
        if ($request->filled('department_id') && $request->filled('semester_id')) {
            $department = Department::findOrFail($request->department_id);
            $semester = Semester::findOrFail($request->semester_id);
            
            // Lấy tất cả giáo viên trong khoa
            $teachers = Teacher::with(['department', 'degree'])
                              ->where('department_id', $department->id)
                              ->orderBy('ho_ten')
                              ->get();
            
            $teacherReports = [];
            $totalDepartment = 0;
            $totalClasses = 0;
            $totalHours = 0;
            
            foreach ($teachers as $teacher) {
                $teacherData = $this->calculateTeacherSemesterSalary($teacher->id, $semester->id);
                
                if ($teacherData['total'] > 0) {
                    $teacherReports[] = [
                        'teacher' => $teacher,
                        'classes_count' => $teacherData['classes_count'],
                        'total_hours' => $teacherData['total_hours'],
                        'total_salary' => $teacherData['total'],
                        'details' => $teacherData['details']
                    ];
                    $totalDepartment += $teacherData['total'];
                    $totalClasses += $teacherData['classes_count'];
                    $totalHours += $teacherData['total_hours'];
                }
            }
            
            $reportData = [
                'department' => $department,
                'semester' => $semester,
                'teachers' => $teacherReports,
                'total_teachers' => count($teacherReports),
                'total_classes' => $totalClasses,
                'total_hours' => $totalHours,
                'total_salary' => $totalDepartment
            ];
        }
        
        return view('admin.reports.department', compact('departments', 'semesters', 'reportData'));
    }
      /**
     * Báo cáo tiền dạy giáo viên toàn trường
     */
    public function schoolWideReport(Request $request)
    {
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        $years = Semester::select('nam_hoc')->distinct()->orderBy('nam_hoc', 'desc')->get();
        
        $reportData = null;
        
        if ($request->filled('report_type')) {
            $reportType = $request->report_type;
            
            if ($reportType == 'semester' && $request->filled('semester_id')) {
                $reportData = $this->generateSchoolSemesterReport($request->semester_id);
            } elseif ($reportType == 'yearly' && $request->filled('year')) {
                $reportData = $this->generateSchoolYearlyReport($request->year);
            }
        }
        
        return view('admin.reports.school-wide', compact('semesters', 'years', 'reportData'));
    }
    
    /**
     * Helper method: Tính lương giáo viên trong 1 học kỳ
     */
    private function calculateTeacherSemesterSalary($teacherId, $semesterId)
    {
        $teacher = Teacher::with(['department', 'degree'])->findOrFail($teacherId);
        
        // Lấy tất cả phân công của giáo viên trong học kỳ
        $assignments = TeachingAssignment::with([
            'classSubject.subject',
            'classSubject.semester'
        ])
        ->whereHas('classSubject', function($query) use ($semesterId) {
            $query->where('semester_id', $semesterId);
        })
        ->where('teacher_id', $teacherId)
        ->get();

        if ($assignments->isEmpty()) {
            return [
                'classes_count' => 0,
                'total_hours' => 0,
                'total' => 0,
                'details' => []
            ];
        }

        // Lấy hệ số giáo viên dựa trên bằng cấp
        $teacherCoefficient = TeacherCoefficient::where('ten_bang_cap', $teacher->degree->ten_day_du)
                                                ->where('trang_thai', true)
                                                ->first();
        
        if (!$teacherCoefficient) {
            return [
                'classes_count' => 0,
                'total_hours' => 0,
                'total' => 0,
                'details' => [],
                'error' => 'Không tìm thấy hệ số cho bằng cấp: ' . $teacher->degree->ten_day_du
            ];
        }

        // Lấy tiền dạy một tiết
        $paymentRate = PaymentRate::where('trang_thai', true)->first();
        
        if (!$paymentRate) {
            return [
                'classes_count' => 0,
                'total_hours' => 0,
                'total' => 0,
                'details' => [],
                'error' => 'Không tìm thấy mức tiền dạy một tiết.'
            ];
        }

        $details = [];
        $totalSalary = 0;
        $totalHours = 0;

        foreach ($assignments as $assignment) {
            $classSubject = $assignment->classSubject;
            $subject = $classSubject->subject;

            // Lấy hệ số lớp dựa trên số sinh viên
            $soSinhVien = $classSubject->si_so_lop ?? 0;
            
            $classCoefficient = ClassCoefficient::where('tu_sv', '<=', $soSinhVien)
                                                ->where('den_sv', '>=', $soSinhVien)
                                                ->where('trang_thai', true)
                                                ->first();
            
            if (!$classCoefficient) {
                $classCoefficient = (object)[
                    'he_so' => 1.0,
                    'mo_ta' => 'Hệ số mặc định'
                ];
            }

            // Tính toán theo công thức
            $soTietThucTe = $subject->so_tiet;
            $soTietQuiDoi = $soTietThucTe * ($subject->he_so_hoc_phan + $classCoefficient->he_so);
            $tienDayMotLop = $soTietQuiDoi * $teacherCoefficient->he_so * $paymentRate->gia_tien_moi_tiet;

            $details[] = [
                'ma_lop' => $classSubject->ma_lop,
                'ten_lop' => $classSubject->ten_lop,
                'ten_hoc_phan' => $subject->ten_hoc_phan,
                'so_tiet' => $soTietThucTe,
                'so_sinh_vien' => $soSinhVien,
                'he_so_hoc_phan' => $subject->he_so_hoc_phan,
                'he_so_lop' => $classCoefficient->he_so,
                'tiet_quy_doi' => round($soTietQuiDoi, 2),
                'he_so_gv' => $teacherCoefficient->he_so,
                'tien_mot_tiet' => $paymentRate->gia_tien_moi_tiet,
                'tien_day' => round($tienDayMotLop, 0)
            ];

            $totalSalary += $tienDayMotLop;
            $totalHours += $soTietThucTe;
        }

        return [
            'classes_count' => $assignments->count(),
            'total_hours' => $totalHours,
            'total' => $totalSalary,
            'details' => $details,
            'teacher_coefficient' => $teacherCoefficient,
            'payment_rate' => $paymentRate
        ];
    }
    
    /**
     * Tạo báo cáo toàn trường theo học kỳ
     */
    private function generateSchoolSemesterReport($semesterId)    {
        $semester = Semester::findOrFail($semesterId);
        $departments = Department::orderBy('ten_day_du')->get();
        
        $departmentReports = [];
        $totalSchool = 0;
        $totalTeachers = 0;
        $totalClasses = 0;
        $totalHours = 0;
        
        foreach ($departments as $department) {
            $teachers = Teacher::with(['department', 'degree'])
                              ->where('department_id', $department->id)
                              ->get();
            
            $departmentSalary = 0;
            $departmentClasses = 0;
            $departmentHours = 0;
            $teachingTeachers = 0;
            
            foreach ($teachers as $teacher) {
                $teacherData = $this->calculateTeacherSemesterSalary($teacher->id, $semesterId);
                
                if ($teacherData['total'] > 0) {
                    $departmentSalary += $teacherData['total'];
                    $departmentClasses += $teacherData['classes_count'];
                    $departmentHours += $teacherData['total_hours'];
                    $teachingTeachers++;
                }
            }
            
            if ($departmentSalary > 0) {
                $departmentReports[] = [
                    'department' => $department,
                    'teachers_count' => $teachingTeachers,
                    'classes_count' => $departmentClasses,
                    'total_hours' => $departmentHours,
                    'total_salary' => $departmentSalary
                ];
                
                $totalSchool += $departmentSalary;
                $totalTeachers += $teachingTeachers;
                $totalClasses += $departmentClasses;
                $totalHours += $departmentHours;
            }
        }
        
        return [
            'type' => 'semester',
            'semester' => $semester,
            'departments' => $departmentReports,
            'summary' => [
                'total_teachers' => $totalTeachers,
                'total_classes' => $totalClasses,
                'total_hours' => $totalHours,
                'total_salary' => $totalSchool
            ]
        ];
    }
    
    /**
     * Tạo báo cáo toàn trường theo năm học
     */
    private function generateSchoolYearlyReport($year)
    {        $semesters = Semester::where('nam_hoc', $year)->orderBy('ten_ki')->get();
        $departments = Department::orderBy('ten_day_du')->get();
        
        $departmentReports = [];
        $totalSchool = 0;
        $totalTeachers = 0;
        $totalClasses = 0;
        $totalHours = 0;
        
        foreach ($departments as $department) {
            $teachers = Teacher::with(['department', 'degree'])
                              ->where('department_id', $department->id)
                              ->get();
            
            $departmentSalary = 0;
            $departmentClasses = 0;
            $departmentHours = 0;
            $teachingTeachers = [];
            
            // Tính tổng cho cả năm học
            foreach ($semesters as $semester) {
                foreach ($teachers as $teacher) {
                    $teacherData = $this->calculateTeacherSemesterSalary($teacher->id, $semester->id);
                    
                    if ($teacherData['total'] > 0) {
                        $departmentSalary += $teacherData['total'];
                        $departmentClasses += $teacherData['classes_count'];
                        $departmentHours += $teacherData['total_hours'];
                        $teachingTeachers[$teacher->id] = $teacher; // Unique teachers
                    }
                }
            }
            
            if ($departmentSalary > 0) {
                $departmentReports[] = [
                    'department' => $department,
                    'teachers_count' => count($teachingTeachers),
                    'classes_count' => $departmentClasses,
                    'total_hours' => $departmentHours,
                    'total_salary' => $departmentSalary
                ];
                
                $totalSchool += $departmentSalary;
                $totalTeachers += count($teachingTeachers);
                $totalClasses += $departmentClasses;
                $totalHours += $departmentHours;
            }
        }
        
        return [
            'type' => 'yearly',
            'year' => $year,
            'semesters' => $semesters,
            'departments' => $departmentReports,
            'summary' => [
                'total_teachers' => $totalTeachers,
                'total_classes' => $totalClasses,
                'total_hours' => $totalHours,
                'total_salary' => $totalSchool
            ]
        ];
    }
}
