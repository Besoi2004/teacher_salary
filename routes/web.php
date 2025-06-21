<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\TeachingAssignmentController;

Route::get('/', function () {
    return redirect()->route('admin.index');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    
    // Test route for debugging
    Route::get('/test-data', function () {
        $teachers = \App\Models\Teacher::with('department')->get();
        $classSubjects = \App\Models\ClassSubject::with(['subject', 'semester'])->get();
        
        return response()->json([
            'teachers_count' => $teachers->count(),
            'class_subjects_count' => $classSubjects->count(),
            'teachers' => $teachers->map(function($t) {
                return [
                    'id' => $t->id,
                    'ma_so' => $t->ma_so,
                    'ho_ten' => $t->ho_ten,
                    'department' => $t->department ? $t->department->ten_viet_tat : 'N/A'
                ];
            }),
            'class_subjects' => $classSubjects->map(function($cs) {
                return [
                    'id' => $cs->id,
                    'ma_lop' => $cs->ma_lop,
                    'ten_lop' => $cs->ten_lop,
                    'subject' => $cs->subject ? $cs->subject->ten_hoc_phan : 'N/A',
                    'semester' => $cs->semester ? ($cs->semester->ten_ki . ' ' . $cs->semester->nam_hoc) : 'N/A'
                ];
            })
        ]);
    });
    
    // Test route for debugging teaching assignments create
    Route::get('/test-teaching-create', function () {
        return 'TEST: Teaching assignment create route works!';
    });
    
    // Test route với view
    Route::get('/test-teaching-view', function () {
        $teachers = collect([
            (object)['id' => 1, 'ma_so' => 'GV001', 'ho_ten' => 'Test Teacher', 'department' => (object)['ten_viet_tat' => 'CNTT']]
        ]);
        
        $classSubjects = collect([
            (object)['id' => 1, 'ma_lop' => 'CS101', 'ten_lop' => 'Test Class', 'so_sinh_vien' => 30, 
                     'subject' => (object)['ten_hoc_phan' => 'Test Subject'],
                     'semester' => (object)['ten_ki' => 'Học kỳ 1', 'nam_hoc' => '2023-2024']]
        ]);
        
        return view('admin.teaching-assignments.create_test_layout', compact('teachers', 'classSubjects'));
    });
    
    // Test route to debug API
    Route::get('test-api', function() {
        $semesters = \App\Models\Semester::all();
        $firstSemester = $semesters->first();
        
        if (!$firstSemester) {
            return response()->json(['error' => 'No semesters found']);
        }
        
        $subjects = \App\Models\Subject::whereHas('classSubjects', function($query) use ($firstSemester) {
            $query->where('semester_id', $firstSemester->id);
        })->get(['id', 'ma_so', 'ten_hoc_phan']);
        
        return response()->json([
            'first_semester_id' => $firstSemester->id,
            'first_semester_name' => $firstSemester->ten_ki . ' ' . $firstSemester->nam_hoc,
            'subjects_count' => $subjects->count(),
            'subjects' => $subjects,
            'api_url' => url("/admin/api/subjects-by-semester/{$firstSemester->id}")
        ]);
    });
    
    // Simple test route
    Route::get('debug-data', function() {
        $semesters = \App\Models\Semester::all();
        $subjects = \App\Models\Subject::all();
        $classSubjects = \App\Models\ClassSubject::all();
        
        return response()->json([
            'semesters' => $semesters->count(),
            'subjects' => $subjects->count(), 
            'class_subjects' => $classSubjects->count(),
            'semester_list' => $semesters->map(fn($s) => ['id' => $s->id, 'name' => $s->ten_ki . ' ' . $s->nam_hoc]),
            'subject_list' => $subjects->map(fn($s) => ['id' => $s->id, 'code' => $s->ma_so, 'name' => $s->ten_hoc_phan]),
        ]);
    });
    
    // Test specific API endpoint
    Route::get('test-subjects/{semesterId}', [TeachingAssignmentController::class, 'getSubjectsBySemester']);
    
    // Debug route for semester and class subjects
    Route::get('debug-semester/{semesterId?}', function($semesterId = null) {
        if (!$semesterId) {
            $semesterId = \App\Models\Semester::first()?->id;
        }
        
        $semester = \App\Models\Semester::find($semesterId);
        $classSubjects = \App\Models\ClassSubject::where('semester_id', $semesterId)->with('subject')->get();
        $subjects = \App\Models\Subject::whereHas('classSubjects', function($query) use ($semesterId) {
            $query->where('semester_id', $semesterId);
        })->get();
        
        return response()->json([
            'semester_id' => $semesterId,
            'semester_name' => $semester ? $semester->ten_ki . ' ' . $semester->nam_hoc : 'Not found',
            'class_subjects_count' => $classSubjects->count(),
            'class_subjects' => $classSubjects->map(fn($cs) => [
                'id' => $cs->id,
                'ma_lop' => $cs->ma_lop,
                'subject_code' => $cs->subject->ma_so ?? 'N/A',
                'subject_name' => $cs->subject->ten_hoc_phan ?? 'N/A'
            ]),
            'unique_subjects_count' => $subjects->count(),
            'unique_subjects' => $subjects->map(fn($s) => [
                'id' => $s->id,
                'ma_so' => $s->ma_so,
                'ten_hoc_phan' => $s->ten_hoc_phan
            ])
        ]);
    });
    
    // Resource routes - Quản lý Giáo viên
    Route::resource('degrees', DegreeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('teachers', TeacherController::class);
    
    // Resource routes - Quản lý Lớp học phần
    Route::resource('subjects', SubjectController::class);
    Route::resource('semesters', SemesterController::class);
    Route::get('semesters-statistics', [SemesterController::class, 'statistics'])->name('semesters.statistics');
    
    Route::resource('class-subjects', ClassSubjectController::class);
    Route::get('class-subjects-statistics', [ClassSubjectController::class, 'statistics'])->name('class-subjects.statistics');
    
    Route::resource('teaching-assignments', TeachingAssignmentController::class);
    
    // API routes for cascade dropdowns
    Route::get('api/subjects-by-semester/{semesterId}', [TeachingAssignmentController::class, 'getSubjectsBySemester']);
    Route::get('api/class-subjects-by-subject/{subjectId}', [TeachingAssignmentController::class, 'getClassSubjectsBySubject']);
    
    // Test route để debug
    Route::get('test-dropdown-data', function() {
        $semesters = \App\Models\Semester::all();
        $subjects = \App\Models\Subject::all();
        $classSubjects = \App\Models\ClassSubject::with(['subject', 'semester'])->get();
        
        return response()->json([
            'semesters' => $semesters,
            'subjects' => $subjects,
            'class_subjects' => $classSubjects
        ]);
    });
    
    Route::get('test-dropdown', function() {
        $semesters = \App\Models\Semester::all();
        return view('test-dropdown', compact('semesters'));
    });
    
    Route::get('debug-dropdown', function() {
        $semesters = \App\Models\Semester::all();
        return view('debug-dropdown', compact('semesters'));
    });
    
    Route::get('create-simple', function() {
        $semesters = \App\Models\Semester::all();
        $teachers = \App\Models\Teacher::with('department')->get();
        return view('create-simple', compact('semesters', 'teachers'));
    });
    
    Route::get('simple-api-test/{semesterId}', function($semesterId) {
        $subjects = \App\Models\Subject::whereHas('classSubjects', function($query) use ($semesterId) {
            $query->where('semester_id', $semesterId);
        })->get(['id', 'ma_so', 'ten_hoc_phan']);
        
        return response()->json([
            'semester_id' => $semesterId,
            'subjects_count' => $subjects->count(),
            'subjects' => $subjects
        ]);
    });
    
    Route::post('check-assignment-conflicts', function(\Illuminate\Http\Request $request) {
        $conflicts = [];
        
        if ($request->teacher_id && $request->class_subject_ids) {
            foreach ($request->class_subject_ids as $classSubjectId) {
                $classSubject = \App\Models\ClassSubject::with(['subject', 'semester'])->find($classSubjectId);
                if (!$classSubject) continue;
                
                // Check if teacher is already assigned
                $existsTeacher = \App\Models\TeachingAssignment::where('teacher_id', $request->teacher_id)
                                              ->where('class_subject_id', $classSubjectId)
                                              ->exists();
                
                // Check if any other teacher is assigned
                $existsOtherTeacher = \App\Models\TeachingAssignment::with('teacher')
                                                   ->where('class_subject_id', $classSubjectId)
                                                   ->where('teacher_id', '!=', $request->teacher_id)
                                                   ->first();
                
                if ($existsTeacher) {
                    $conflicts[] = [
                        'class_id' => $classSubjectId,
                        'class_name' => $classSubject->ma_lop,
                        'type' => 'duplicate_teacher',
                        'message' => "Giảng viên đã được phân công cho lớp này"
                    ];
                } elseif ($existsOtherTeacher) {
                    $conflicts[] = [
                        'class_id' => $classSubjectId,
                        'class_name' => $classSubject->ma_lop,
                        'type' => 'class_occupied',
                        'assigned_teacher' => $existsOtherTeacher->teacher->ho_ten,
                        'message' => "Lớp đã được phân công cho giảng viên {$existsOtherTeacher->teacher->ho_ten}"
                    ];
                }
            }
        }
        
        return response()->json(['conflicts' => $conflicts]);
    });
});
