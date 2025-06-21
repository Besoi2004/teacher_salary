<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\Degree;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with(['department', 'degree'])
                          ->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $degrees = Degree::all();
        return view('admin.teachers.create', compact('departments', 'degrees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma_so' => 'nullable|string|max:50|unique:teachers,ma_so',
            'ho_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date|before:today',
            'dien_thoai' => 'nullable|string|max:20',
            'email' => 'required|email|unique:teachers,email',
            'department_id' => 'required|exists:departments,id',
            'degree_id' => 'required|exists:degrees,id'
        ]);

        Teacher::create($request->all());

        return redirect()->route('admin.teachers.index')->with('success', 'Giáo viên đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load(['department', 'degree']);
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $departments = Department::all();
        $degrees = Degree::all();
        return view('admin.teachers.edit', compact('teacher', 'departments', 'degrees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'ma_so' => ['nullable', 'string', 'max:50', Rule::unique('teachers')->ignore($teacher->id)],
            'ho_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date|before:today',
            'dien_thoai' => 'nullable|string|max:20',
            'email' => ['required', 'email', Rule::unique('teachers')->ignore($teacher->id)],
            'department_id' => 'required|exists:departments,id',
            'degree_id' => 'required|exists:degrees,id'
        ]);

        $teacher->update($request->all());

        return redirect()->route('admin.teachers.index')->with('success', 'Thông tin giáo viên đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Giáo viên đã được xóa thành công!');
    }
}
