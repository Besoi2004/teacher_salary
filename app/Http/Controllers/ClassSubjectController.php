<?php

namespace App\Http\Controllers;

use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\Semester;
use Illuminate\Http\Request;

class ClassSubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassSubject::with(['subject', 'semester']);
        
        // Tìm kiếm theo tên lớp hoặc mã lớp
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('ma_lop', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('ten_lop', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Lọc theo học kỳ
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }
        
        // Lọc theo học phần
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        
        $classSubjects = $query->orderBy('created_at', 'desc')->get();
        
        // Lấy dữ liệu cho dropdown lọc
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        $subjects = Subject::orderBy('ten_hoc_phan')->get();
        
        return view('admin.class-subjects.index', compact('classSubjects', 'semesters', 'subjects'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('ten_hoc_phan')->get();
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        
        // Lấy danh sách các học phần đã có lớp
        $subjectsWithClasses = Subject::has('classSubjects')
                                    ->withCount('classSubjects')
                                    ->orderBy('ten_hoc_phan')
                                    ->get();
        
        return view('admin.class-subjects.create', compact('subjects', 'semesters', 'subjectsWithClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'so_lop' => 'required|integer|min:1|max:20',
            'ghi_chu' => 'nullable|string'
        ]);

        // Lấy thông tin học phần
        $subject = Subject::findOrFail($request->subject_id);
        
        // Tạo các lớp học phần
        $createdClasses = [];
        
        for ($i = 1; $i <= $request->so_lop; $i++) {
            $soThuTu = str_pad($i, 2, '0', STR_PAD_LEFT); // 01, 02, 03...
            
            $maLop = $subject->ma_so . '_' . $soThuTu;
            $tenLop = $subject->ten_hoc_phan . '_N' . $soThuTu;
            
            // Kiểm tra mã lớp đã tồn tại chưa
            $existingClass = ClassSubject::where('ma_lop', $maLop)->first();
            if ($existingClass) {
                return back()->withErrors(['so_lop' => "Mã lớp {$maLop} đã tồn tại trong hệ thống."])->withInput();
            }
            
            $classSubject = ClassSubject::create([
                'semester_id' => $request->semester_id,
                'subject_id' => $request->subject_id,
                'ma_lop' => $maLop,
                'ten_lop' => $tenLop,
                'ghi_chu' => $request->ghi_chu
            ]);
            
            $createdClasses[] = $maLop;
        }

        $message = 'Đã tạo thành công ' . count($createdClasses) . ' lớp học phần: ' . implode(', ', $createdClasses);

        return redirect()->route('admin.class-subjects.index')
                        ->with('success', $message);
    }

    public function show(ClassSubject $classSubject)
    {
        $classSubject->load(['subject', 'semester', 'teachingAssignments.teacher.department']);
        return view('admin.class-subjects.show', compact('classSubject'));
    }

    public function edit(ClassSubject $classSubject)
    {
        $subjects = Subject::orderBy('ten_hoc_phan')->get();
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        return view('admin.class-subjects.edit', compact('classSubject', 'subjects', 'semesters'));
    }

    public function update(Request $request, ClassSubject $classSubject)
    {
        $request->validate([
            'ma_lop' => 'required|string|max:20|unique:class_subjects,ma_lop,' . $classSubject->id,
            'ten_lop' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'semester_id' => 'required|exists:semesters,id',
            'ghi_chu' => 'nullable|string'
        ]);

        $classSubject->update($request->all());

        return redirect()->route('admin.class-subjects.index')
                        ->with('success', 'Lớp học phần đã được cập nhật thành công!');
    }

    public function destroy(ClassSubject $classSubject)
    {
        // Check if class subject has teaching assignments
        if ($classSubject->teachingAssignments()->count() > 0) {
            return back()->with('error', 'Không thể xóa lớp học phần đã có phân công giảng dạy.');
        }

        $classSubject->delete();

        return redirect()->route('admin.class-subjects.index')
                        ->with('success', 'Lớp học phần đã được xóa thành công!');
    }

    public function statistics()
    {
        $statistics = ClassSubject::with(['subject', 'semester'])
                                ->withCount('teachingAssignments')
                                ->get()
                                ->groupBy(['semester.ten_ki', 'subject.ten_hoc_phan']);

        return view('admin.class-subjects.statistics', compact('statistics'));
    }
}
