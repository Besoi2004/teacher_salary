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
    }

    /**
     * Báo cáo tiền dạy giáo viên trong 1 năm
     */
    public function teacherYearlyReport()
    {
        $teachers = Teacher::with('department')->orderBy('ho_ten')->get();
        $years = Semester::select('nam_hoc')->distinct()->orderBy('nam_hoc', 'desc')->get();
        
        return view('admin.reports.teacher-yearly', compact('teachers', 'years'));
    }
    
    /**
     * Báo cáo tiền dạy giáo viên 1 khoa
     */    public function departmentReport()
    {
        $departments = Department::orderBy('ten_khoa')->get();
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        
        return view('admin.reports.department', compact('departments', 'semesters'));
    }
    
    /**
     * Báo cáo tiền dạy giáo viên toàn trường
     */
    public function schoolWideReport()
    {
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        $years = Semester::select('nam_hoc')->distinct()->orderBy('nam_hoc', 'desc')->get();
        
        return view('admin.reports.school-wide', compact('semesters', 'years'));
    }
}
