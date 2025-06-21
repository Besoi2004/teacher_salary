<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use Illuminate\Validation\Rule;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $degrees = Degree::withCount('teachers')->paginate(10);
        return view('admin.degrees.index', compact('degrees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.degrees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_day_du' => 'required|string|max:255',
            'ten_viet_tat' => 'required|string|max:50|unique:degrees,ten_viet_tat',
            'mo_ta' => 'nullable|string'
        ]);

        Degree::create($request->all());

        return redirect()->route('admin.degrees.index')->with('success', 'Bằng cấp đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Degree $degree)
    {
        $degree->load('teachers');
        return view('admin.degrees.show', compact('degree'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Degree $degree)
    {
        return view('admin.degrees.edit', compact('degree'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Degree $degree)
    {
        $request->validate([
            'ten_day_du' => 'required|string|max:255',
            'ten_viet_tat' => ['required', 'string', 'max:50', Rule::unique('degrees')->ignore($degree->id)],
            'mo_ta' => 'nullable|string'
        ]);

        $degree->update($request->all());

        return redirect()->route('admin.degrees.index')->with('success', 'Bằng cấp đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Degree $degree)
    {
        if ($degree->teachers()->count() > 0) {
            return redirect()->route('admin.degrees.index')->with('error', 'Không thể xóa bằng cấp này vì có giáo viên đang sử dụng!');
        }

        $degree->delete();

        return redirect()->route('admin.degrees.index')->with('success', 'Bằng cấp đã được xóa thành công!');
    }
}
