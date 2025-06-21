<?php

namespace App\Http\Controllers;

use App\Models\TeachingAssignment;
use App\Models\Teacher;
use App\Models\ClassSubject;
use Illuminate\Http\Request;

class TeachingAssignmentController extends Controller
{
    public function index()
    {
        $assignments = TeachingAssignment::with(['teacher.department', 'classSubject.subject', 'classSubject.semester'])
                                       ->orderBy('created_at', 'desc')
                                       ->get();
        return view('admin.teaching-assignments.index', compact('assignments'));
    }

    public function create()
    {
        $teachers = Teacher::with('department')->orderBy('ho_ten')->get();
        $semesters = \App\Models\Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        
        return view('admin.teaching-assignments.create', compact('teachers', 'semesters'));
    }

    public function store(Request $request)
    {
        if ($request->assignment_type === 'single') {
            $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'class_subject_id' => 'required|exists:class_subjects,id',
                'si_so_lop' => 'required|integer|min:1|max:100',
                'ghi_chu' => 'nullable|string'
            ], [
                'teacher_id.required' => 'Vui lòng chọn giáo viên.',
                'class_subject_id.required' => 'Vui lòng chọn lớp học phần.',
                'si_so_lop.required' => 'Vui lòng nhập sĩ số lớp.',
            ]);

            // Check if teacher is already assigned to this class subject
            $existsTeacher = TeachingAssignment::where('teacher_id', $request->teacher_id)
                                      ->where('class_subject_id', $request->class_subject_id)
                                      ->exists();

            if ($existsTeacher) {
                return back()->withErrors(['teacher_id' => 'Giáo viên này đã được phân công cho lớp học phần này.'])->withInput();
            }

            // Check if any other teacher is already assigned to this class subject
            $existsClass = TeachingAssignment::where('class_subject_id', $request->class_subject_id)
                                    ->exists();

            if ($existsClass) {
                $assignedTeacher = TeachingAssignment::with('teacher')
                                                   ->where('class_subject_id', $request->class_subject_id)
                                                   ->first();
                return back()->withErrors([
                    'class_subject_id' => 'Lớp học phần này đã được phân công cho giáo viên: ' . $assignedTeacher->teacher->ho_ten
                ])->withInput();
            }

            // Update class subject's si_so_lop
            $classSubject = ClassSubject::findOrFail($request->class_subject_id);
            $classSubject->update(['si_so_lop' => $request->si_so_lop]);

            // Create teaching assignment
            TeachingAssignment::create([
                'teacher_id' => $request->teacher_id,
                'class_subject_id' => $request->class_subject_id,
                'role' => 'primary', // Default role
                'theory_hours_assigned' => 0,
                'practice_hours_assigned' => 0,
                'hourly_rate' => 150000,
                'ghi_chu' => $request->ghi_chu
            ]);

            return redirect()->route('admin.teaching-assignments.index')
                            ->with('success', 'Phân công giảng dạy đã được tạo thành công!');
        } elseif ($request->assignment_type === 'bulk') {
            $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'class_subject_ids' => 'required|array|min:1',
                'class_subject_ids.*' => 'exists:class_subjects,id',
                'si_so_lop' => 'required|integer|min:1|max:100',
                'ghi_chu' => 'nullable|string'
            ], [
                'teacher_id.required' => 'Vui lòng chọn giáo viên.',
                'class_subject_ids.required' => 'Vui lòng chọn ít nhất một lớp học phần.',
                'class_subject_ids.min' => 'Vui lòng chọn ít nhất một lớp học phần.',
                'si_so_lop.required' => 'Vui lòng nhập sĩ số lớp.',
            ]);

            // Kiểm tra tất cả các lớp trước khi tạo phân công
            $errors = [];
            $conflictDetails = [];
            
            foreach ($request->class_subject_ids as $classSubjectId) {
                $classSubject = ClassSubject::with(['subject', 'semester'])->find($classSubjectId);
                
                // Check if teacher is already assigned to this class subject
                $existsTeacher = TeachingAssignment::where('teacher_id', $request->teacher_id)
                                          ->where('class_subject_id', $classSubjectId)
                                          ->exists();

                // Check if any other teacher is already assigned to this class subject
                $existsOtherTeacher = TeachingAssignment::where('class_subject_id', $classSubjectId)
                                                       ->where('teacher_id', '!=', $request->teacher_id)
                                                       ->first();

                if ($existsTeacher) {
                    $conflictDetails[] = [
                        'type' => 'duplicate_teacher',
                        'class' => $classSubject->ma_lop,
                        'subject' => $classSubject->subject->ten_hoc_phan,
                        'semester' => $classSubject->semester->ten_ki . ' - ' . $classSubject->semester->nam_hoc,
                        'message' => "Giảng viên đã được phân công cho lớp {$classSubject->ma_lop}"
                    ];
                } elseif ($existsOtherTeacher) {
                    $assignedTeacher = TeachingAssignment::with('teacher')
                                                       ->where('class_subject_id', $classSubjectId)
                                                       ->first();
                    $conflictDetails[] = [
                        'type' => 'class_occupied',
                        'class' => $classSubject->ma_lop,
                        'subject' => $classSubject->subject->ten_hoc_phan,
                        'semester' => $classSubject->semester->ten_ki . ' - ' . $classSubject->semester->nam_hoc,
                        'assigned_teacher' => $assignedTeacher->teacher->ho_ten,
                        'message' => "Lớp {$classSubject->ma_lop} đã được phân công cho giảng viên {$assignedTeacher->teacher->ho_ten}"
                    ];
                }
            }

            // Nếu có lỗi, báo lỗi chi tiết và dừng lại
            if (!empty($conflictDetails)) {
                $errorMessage = "Phát hiện " . count($conflictDetails) . " xung đột trong phân công:";
                
                // Nhóm lỗi theo loại
                $duplicateTeachers = array_filter($conflictDetails, function($item) { return $item['type'] === 'duplicate_teacher'; });
                $occupiedClasses = array_filter($conflictDetails, function($item) { return $item['type'] === 'class_occupied'; });
                
                if (!empty($duplicateTeachers)) {
                    $errorMessage .= "\n\n• Giảng viên đã được phân công cho các lớp:";
                    foreach ($duplicateTeachers as $detail) {
                        $errorMessage .= "\n  - {$detail['class']} ({$detail['subject']})";
                    }
                }
                
                if (!empty($occupiedClasses)) {
                    $errorMessage .= "\n\n• Các lớp đã có giảng viên khác:";
                    foreach ($occupiedClasses as $detail) {
                        $errorMessage .= "\n  - {$detail['class']} ({$detail['subject']}) → Giảng viên: {$detail['assigned_teacher']}";
                    }
                }
                
                return back()->withErrors([
                    'class_subject_ids' => $errorMessage
                ])->withInput();
            }

            // Nếu không có lỗi, tạo tất cả các phân công
            $successCount = 0;
            
            foreach ($request->class_subject_ids as $classSubjectId) {
                // Update class subject's si_so_lop
                $classSubject = ClassSubject::findOrFail($classSubjectId);
                $classSubject->update(['si_so_lop' => $request->si_so_lop]);

                // Create teaching assignment
                TeachingAssignment::create([
                    'teacher_id' => $request->teacher_id,
                    'class_subject_id' => $classSubjectId,
                    'role' => 'primary', // Default role
                    'theory_hours_assigned' => 0,
                    'practice_hours_assigned' => 0,
                    'hourly_rate' => 150000,
                    'ghi_chu' => $request->ghi_chu
                ]);

                $successCount++;
            }

            return redirect()->route('admin.teaching-assignments.index')
                            ->with('success', "Đã tạo thành công {$successCount} phân công giảng dạy!");
        }

        // Handle other assignment types here (bulk, etc.)
        return back()->withErrors(['assignment_type' => 'Loại phân công không hợp lệ.']);
    }

    public function show(TeachingAssignment $teachingAssignment)
    {
        $teachingAssignment->load(['teacher.department', 'classSubject.subject', 'classSubject.semester']);
        return view('admin.teaching-assignments.show', compact('teachingAssignment'));
    }

    public function edit(TeachingAssignment $teachingAssignment)
    {
        $teachers = Teacher::with('department')->orderBy('ho_ten')->get();
        $classSubjects = ClassSubject::with(['subject', 'semester'])
                                   ->orderBy('ma_lop')
                                   ->get();
        return view('admin.teaching-assignments.edit', compact('teachingAssignment', 'teachers', 'classSubjects'));
    }

    public function update(Request $request, TeachingAssignment $teachingAssignment)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_subject_id' => 'required|exists:class_subjects,id',
            'si_so_lop' => 'required|integer|min:1|max:100',
            'ghi_chu' => 'nullable|string'
        ], [
            'teacher_id.required' => 'Vui lòng chọn giáo viên.',
            'class_subject_id.required' => 'Vui lòng chọn lớp học phần.',
            'si_so_lop.required' => 'Vui lòng nhập sĩ số lớp.',
        ]);

        // Check if teacher is already assigned to this class subject (excluding current assignment)
        $existsTeacher = TeachingAssignment::where('teacher_id', $request->teacher_id)
                                  ->where('class_subject_id', $request->class_subject_id)
                                  ->where('id', '!=', $teachingAssignment->id)
                                  ->exists();

        if ($existsTeacher) {
            return back()->withErrors(['teacher_id' => 'Giáo viên này đã được phân công cho lớp học phần này.'])->withInput();
        }

        // Check if any other teacher is already assigned to this class subject (excluding current assignment)
        $existsClass = TeachingAssignment::where('class_subject_id', $request->class_subject_id)
                                        ->where('id', '!=', $teachingAssignment->id)
                                        ->exists();

        if ($existsClass) {
            $assignedTeacher = TeachingAssignment::with('teacher')
                                               ->where('class_subject_id', $request->class_subject_id)
                                               ->where('id', '!=', $teachingAssignment->id)
                                               ->first();
            return back()->withErrors([
                'class_subject_id' => 'Lớp học phần này đã được phân công cho giáo viên: ' . $assignedTeacher->teacher->ho_ten
            ])->withInput();
        }

        // Update class subject's si_so_lop
        $classSubject = ClassSubject::findOrFail($request->class_subject_id);
        $classSubject->update(['si_so_lop' => $request->si_so_lop]);

        // Update teaching assignment
        $teachingAssignment->update([
            'teacher_id' => $request->teacher_id,
            'class_subject_id' => $request->class_subject_id,
            'ghi_chu' => $request->ghi_chu
        ]);

        return redirect()->route('admin.teaching-assignments.index')
                        ->with('success', 'Phân công giảng dạy đã được cập nhật thành công!');
    }

    public function destroy(TeachingAssignment $teachingAssignment)
    {
        $teachingAssignment->delete();

        return redirect()->route('admin.teaching-assignments.index')
                        ->with('success', 'Phân công giảng dạy đã được xóa thành công!');
    }

    // API Methods for cascade dropdowns
    public function getSubjectsBySemester($semesterId)
    {
        try {
            \Log::info("=== getSubjectsBySemester START ===");
            \Log::info("Semester ID: " . $semesterId);
            
            // Lấy tất cả học phần có lớp học phần trong học kỳ này
            $subjects = \App\Models\Subject::whereHas('classSubjects', function($query) use ($semesterId) {
                $query->where('semester_id', $semesterId);
            })->orderBy('ten_hoc_phan')->get(['id', 'ma_so', 'ten_hoc_phan']);

            \Log::info("Found subjects: " . $subjects->count());
            \Log::info("Subjects data: " . $subjects->toJson());
            
            return response()->json($subjects);
        } catch (\Exception $e) {
            \Log::error('Error in getSubjectsBySemester: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Lỗi tải dữ liệu'], 500);
        }
    }

    public function getClassSubjectsBySubject($subjectId, Request $request)
    {
        try {
            $query = ClassSubject::where('subject_id', $subjectId);
            
            if ($request->has('semester_id')) {
                $query->where('semester_id', $request->semester_id);
            }
            
            $classSubjects = $query->with(['teachingAssignments.teacher'])
                                  ->orderBy('ma_lop')
                                  ->get(['id', 'ma_lop', 'ten_lop', 'si_so_lop']);

            // Add assignment information to each class
            $result = $classSubjects->map(function ($classSubject) {
                $assignment = $classSubject->teachingAssignments->first();
                
                return [
                    'id' => $classSubject->id,
                    'ma_lop' => $classSubject->ma_lop,
                    'ten_lop' => $classSubject->ten_lop,
                    'si_so_lop' => $classSubject->si_so_lop,
                    'is_assigned' => $assignment ? true : false,
                    'assigned_teacher' => $assignment ? [
                        'id' => $assignment->teacher->id,
                        'ho_ten' => $assignment->teacher->ho_ten,
                        'ma_so' => $assignment->teacher->ma_so
                    ] : null
                ];
            });

            return response()->json($result);
        } catch (\Exception $e) {
            \Log::error('Error in getClassSubjectsBySubject: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi tải dữ liệu'], 500);
        }
    }
}
