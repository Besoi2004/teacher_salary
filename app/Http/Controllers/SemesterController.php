<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();
        return view('admin.semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('admin.semesters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_ki' => 'required|string|max:255',
            'nam_hoc' => 'required|string|max:20',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'ghi_chu' => 'nullable|string'
        ]);

        // Check for duplicate semester
        $exists = Semester::where('ten_ki', $request->ten_ki)
                         ->where('nam_hoc', $request->nam_hoc)
                         ->exists();

        if ($exists) {
            return back()->withErrors(['ten_ki' => 'Học kỳ này đã tồn tại trong năm học.'])->withInput();
        }

        Semester::create($request->all());

        return redirect()->route('admin.semesters.index')
                        ->with('success', 'Học kỳ đã được tạo thành công!');
    }

    public function show(Semester $semester)
    {
        $semester->load('classSubjects.subject', 'classSubjects.teachingAssignments.teacher');
        return view('admin.semesters.show', compact('semester'));
    }

    public function edit(Semester $semester)
    {
        return view('admin.semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'ten_ki' => 'required|string|max:255',
            'nam_hoc' => 'required|string|max:20',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
            'ghi_chu' => 'nullable|string'
        ]);

        // Check for duplicate semester (excluding current)
        $exists = Semester::where('ten_ki', $request->ten_ki)
                         ->where('nam_hoc', $request->nam_hoc)
                         ->where('id', '!=', $semester->id)
                         ->exists();

        if ($exists) {
            return back()->withErrors(['ten_ki' => 'Học kỳ này đã tồn tại trong năm học.'])->withInput();
        }

        $semester->update($request->all());

        return redirect()->route('admin.semesters.index')
                        ->with('success', 'Học kỳ đã được cập nhật thành công!');
    }

    public function destroy(Semester $semester)
    {
        // Check if semester has class subjects
        if ($semester->classSubjects()->count() > 0) {
            return back()->with('error', 'Không thể xóa học kỳ đã có lớp học phần.');
        }

        $semester->delete();

        return redirect()->route('admin.semesters.index')
                        ->with('success', 'Học kỳ đã được xóa thành công!');
    }

    public function statistics()
    {
        $semesters = Semester::withCount(['classSubjects', 'classSubjects as total_assignments' => function ($query) {
            $query->join('teaching_assignments', 'class_subjects.id', '=', 'teaching_assignments.class_subject_id');
        }])->orderBy('nam_hoc', 'desc')->orderBy('ten_ki', 'desc')->get();

        return view('admin.semesters.statistics', compact('semesters'));
    }
}
