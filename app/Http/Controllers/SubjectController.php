<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::withCount('classSubjects')->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ma_so' => 'required|string|max:50|unique:subjects,ma_so',
            'ten_hoc_phan' => 'required|string|max:255|unique:subjects,ten_hoc_phan',
            'so_tin_chi' => 'required|integer|min:1|max:10',
            'he_so_hoc_phan' => 'required|numeric|min:0.1|max:5',
            'mo_ta' => 'nullable|string'
        ]);

        // Tự động tính số tiết dựa trên số tín chỉ (1 tín chỉ = 15 tiết)
        $data = $request->all();
        $data['so_tiet'] = $request->so_tin_chi * 15;

        Subject::create($data);

        return redirect()->route('admin.subjects.index')->with('success', 'Học phần đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('classSubjects.semester');
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'ma_so' => ['required', 'string', 'max:50', Rule::unique('subjects')->ignore($subject->id)],
            'ten_hoc_phan' => 'required|string|max:255',
            'so_tin_chi' => 'required|integer|min:1|max:10',
            'he_so_hoc_phan' => 'required|numeric|min:0.1|max:5',
            'mo_ta' => 'nullable|string'
        ]);

        // Tự động tính số tiết dựa trên số tín chỉ (1 tín chỉ = 15 tiết)
        $data = $request->all();
        $data['so_tiet'] = $request->so_tin_chi * 15;

        $subject->update($data);

        return redirect()->route('admin.subjects.index')->with('success', 'Học phần đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->classSubjects()->count() > 0) {
            return redirect()->route('admin.subjects.index')->with('error', 'Không thể xóa học phần này vì có lớp học phần đang sử dụng!');
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'Học phần đã được xóa thành công!');
    }
}
