<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentRate;
use Illuminate\Validation\Rule;

class PaymentRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentRates = PaymentRate::orderBy('created_at', 'desc')->paginate(10);
        $hasPaymentRate = PaymentRate::exists(); // Kiểm tra đã có mức lương chưa
        return view('admin.payment-rates.index', compact('paymentRates', 'hasPaymentRate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Kiểm tra nếu đã có mức lương thì không cho tạo mới
        if (PaymentRate::exists()) {
            return redirect()->route('admin.payment-rates.index')
                           ->with('error', 'Hệ thống chỉ cho phép có một mức lương duy nhất. Vui lòng sửa hoặc xóa mức lương hiện tại để tạo mới!');
        }

        return view('admin.payment-rates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Kiểm tra lại trước khi lưu
        if (PaymentRate::exists()) {
            return redirect()->route('admin.payment-rates.index')
                           ->with('error', 'Hệ thống chỉ cho phép có một mức lương duy nhất!');
        }

        $request->validate([
            'ten_muc_luong' => 'required|string|max:100|unique:payment_rates,ten_muc_luong',
            'gia_tien_moi_tiet' => 'required|numeric|min:0|max:9999999.99',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'boolean'
        ]);

        PaymentRate::create($request->all());

        return redirect()->route('admin.payment-rates.index')->with('success', 'Mức lương theo tiết đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentRate $paymentRate)
    {
        return view('admin.payment-rates.show', compact('paymentRate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentRate $paymentRate)
    {
        return view('admin.payment-rates.edit', compact('paymentRate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentRate $paymentRate)
    {
        $request->validate([
            'ten_muc_luong' => ['required', 'string', 'max:100', Rule::unique('payment_rates')->ignore($paymentRate->id)],
            'gia_tien_moi_tiet' => 'required|numeric|min:0|max:9999999.99',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'boolean'
        ]);

        $paymentRate->update($request->all());

        return redirect()->route('admin.payment-rates.index')->with('success', 'Mức lương theo tiết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentRate $paymentRate)
    {
        $paymentRate->delete();

        return redirect()->route('admin.payment-rates.index')
                       ->with('success', 'Mức lương theo tiết đã được xóa thành công! Bạn có thể tạo mức lương mới.');
    }
}
