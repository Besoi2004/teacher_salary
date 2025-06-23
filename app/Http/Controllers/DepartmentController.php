<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::withCount('teachers')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_day_du' => 'required|string|max:255|unique:departments,ten_day_du',
            'ten_viet_tat' => 'required|string|max:50|unique:departments,ten_viet_tat',
            'mo_ta_nhiem_vu' => 'nullable|string'
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')->with('success', 'Khoa đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $department->load('teachers.degree');
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'ten_day_du' => 'required|string|max:255',
            'ten_viet_tat' => ['required', 'string', 'max:50', Rule::unique('departments')->ignore($department->id)],
            'mo_ta_nhiem_vu' => 'nullable|string'
        ]);

        $department->update($request->all());

        return redirect()->route('admin.departments.index')->with('success', 'Khoa đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($department->teachers()->count() > 0) {
            return redirect()->route('admin.departments.index')->with('error', 'Không thể xóa khoa này vì có giáo viên đang thuộc khoa!');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Khoa đã được xóa thành công!');
    }
}
