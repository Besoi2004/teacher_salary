<?php

namespace App\Http\Controllers;

use App\Models\ClassCoefficient;
use Illuminate\Http\Request;

class ClassCoefficientController extends Controller
{
    public function index()
    {
        $classCoefficients = ClassCoefficient::orderBy('tu_sv', 'asc')->paginate(10);
        return view('admin.class-coefficients.index', compact('classCoefficients'));
    }

    public function create()
    {
        return view('admin.class-coefficients.create');
    }

    public function store(Request $request)
    {        $request->validate([
            'tu_sv' => 'required|integer|min:0',
            'den_sv' => 'required|integer|min:0|gte:tu_sv',
            'he_so' => 'required|numeric|min:0',
            'mo_ta' => 'nullable|string|max:500',
            'trang_thai' => 'boolean'
        ]);

        // Kiểm tra trùng lặp khoảng sinh viên
        $existingRange = ClassCoefficient::where(function($query) use ($request) {
            $query->where(function($q) use ($request) {
                $q->where('tu_sv', '<=', $request->tu_sv)
                  ->where('den_sv', '>=', $request->tu_sv);
            })
            ->orWhere(function($q) use ($request) {
                $q->where('tu_sv', '<=', $request->den_sv)
                  ->where('den_sv', '>=', $request->den_sv);
            })
            ->orWhere(function($q) use ($request) {
                $q->where('tu_sv', '>=', $request->tu_sv)
                  ->where('den_sv', '<=', $request->den_sv);
            });
        })->where('trang_thai', true)->first();        if ($existingRange) {
            return back()->withErrors(['error' => 'Khoảng số sinh viên này đã tồn tại với hệ số khác!'])
                        ->withInput();
        }

        // Tạo dữ liệu với các trường cần thiết
        $data = [
            'tu_sv' => $request->tu_sv,
            'den_sv' => $request->den_sv,
            'he_so' => $request->he_so,
            'mo_ta' => $request->mo_ta,
            'trang_thai' => $request->boolean('trang_thai')
        ];

        ClassCoefficient::create($data);

        return redirect()->route('admin.class-coefficients.index')
                        ->with('success', 'Tạo hệ số lớp thành công!');
    }

    public function show(ClassCoefficient $classCoefficient)
    {
        return view('admin.class-coefficients.show', compact('classCoefficient'));
    }

    public function edit(ClassCoefficient $classCoefficient)
    {
        return view('admin.class-coefficients.edit', compact('classCoefficient'));
    }

    public function update(Request $request, ClassCoefficient $classCoefficient)
    {        $request->validate([
            'tu_sv' => 'required|integer|min:0',
            'den_sv' => 'required|integer|min:0|gte:tu_sv',
            'he_so' => 'required|numeric|min:0',
            'mo_ta' => 'nullable|string|max:500',
            'trang_thai' => 'boolean'
        ]);

        // Kiểm tra trùng lặp khoảng sinh viên (trừ bản ghi hiện tại)
        $existingRange = ClassCoefficient::where('id', '!=', $classCoefficient->id)
            ->where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('tu_sv', '<=', $request->tu_sv)
                      ->where('den_sv', '>=', $request->tu_sv);
                })
                ->orWhere(function($q) use ($request) {
                    $q->where('tu_sv', '<=', $request->den_sv)
                      ->where('den_sv', '>=', $request->den_sv);
                })
                ->orWhere(function($q) use ($request) {
                    $q->where('tu_sv', '>=', $request->tu_sv)
                      ->where('den_sv', '<=', $request->den_sv);
                });
            })->where('trang_thai', true)->first();        if ($existingRange) {
            return back()->withErrors(['error' => 'Khoảng số sinh viên này đã tồn tại với hệ số khác!'])
                        ->withInput();
        }

        // Cập nhật dữ liệu với các trường cần thiết
        $data = [
            'tu_sv' => $request->tu_sv,
            'den_sv' => $request->den_sv,
            'he_so' => $request->he_so,
            'mo_ta' => $request->mo_ta,
            'trang_thai' => $request->boolean('trang_thai')
        ];

        $classCoefficient->update($data);

        return redirect()->route('admin.class-coefficients.index')
                        ->with('success', 'Cập nhật hệ số lớp thành công!');
    }

    public function destroy(ClassCoefficient $classCoefficient)
    {
        $classCoefficient->delete();

        return redirect()->route('admin.class-coefficients.index')
                        ->with('success', 'Xóa hệ số lớp thành công!');
    }
}
