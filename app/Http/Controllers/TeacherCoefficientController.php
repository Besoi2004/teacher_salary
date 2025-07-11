<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherCoefficient;
use App\Models\Degree;
use Illuminate\Validation\Rule;

class TeacherCoefficientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coefficients = TeacherCoefficient::orderBy('he_so', 'asc')->paginate(10);
        return view('admin.teacher-coefficients.index', compact('coefficients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách các bằng cấp đã có trong hệ thống
        $degrees = Degree::orderBy('ten_day_du')->get();
        
        // Lấy danh sách các bằng cấp đã có hệ số để loại bỏ
        $existingDegrees = TeacherCoefficient::pluck('ten_bang_cap')->toArray();
        
        return view('admin.teacher-coefficients.create', compact('degrees', 'existingDegrees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_bang_cap' => 'required|string|max:100|unique:teacher_coefficients,ten_bang_cap',
            'he_so' => 'required|numeric|min:1|max:10',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'boolean'
        ]);

        TeacherCoefficient::create($request->all());

        return redirect()->route('admin.teacher-coefficients.index')->with('success', 'Hệ số giáo viên đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherCoefficient $teacherCoefficient)
    {
        return view('admin.teacher-coefficients.show', compact('teacherCoefficient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherCoefficient $teacherCoefficient)
    {
        // Lấy danh sách các bằng cấp đã có trong hệ thống
        $degrees = Degree::orderBy('ten_day_du')->get();
        
        // Lấy danh sách các bằng cấp đã có hệ số để loại bỏ (trừ bằng cấp hiện tại)
        $existingDegrees = TeacherCoefficient::where('id', '!=', $teacherCoefficient->id)
                                           ->pluck('ten_bang_cap')
                                           ->toArray();
        
        return view('admin.teacher-coefficients.edit', compact('teacherCoefficient', 'degrees', 'existingDegrees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherCoefficient $teacherCoefficient)
    {
        $request->validate([
            'ten_bang_cap' => ['required', 'string', 'max:100', Rule::unique('teacher_coefficients')->ignore($teacherCoefficient->id)],
            'he_so' => 'required|numeric|min:1|max:10',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'boolean'
        ]);

        $teacherCoefficient->update($request->all());

        return redirect()->route('admin.teacher-coefficients.index')->with('success', 'Hệ số giáo viên đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherCoefficient $teacherCoefficient)
    {
        $teacherCoefficient->delete();

        return redirect()->route('admin.teacher-coefficients.index')->with('success', 'Hệ số giáo viên đã được xóa thành công!');
    }
}
