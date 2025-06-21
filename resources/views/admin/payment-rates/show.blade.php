@extends('layouts.admin')

@section('title', 'Chi tiết mức lương')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-eye me-2"></i>
                    Chi tiết mức lương: {{ $paymentRate->ten_muc_luong }}
                </h2>
                <div>
                    <a href="{{ route('admin.payment-rates.edit', $paymentRate) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.payment-rates.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin chi tiết
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Tên mức lương</h6>
                            <div class="mb-3">
                                <strong class="h5">{{ $paymentRate->ten_muc_luong }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Giá tiền mỗi tiết</h6>
                            <div class="mb-3">
                                <span class="badge bg-success fs-6 p-2">
                                    {{ number_format($paymentRate->gia_tien_moi_tiet, 0, ',', '.') }} VND
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Trạng thái</h6>
                            <div class="mb-3">
                                @if($paymentRate->trang_thai)
                                    <span class="badge bg-success fs-6 p-2">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6 p-2">
                                        <i class="fas fa-pause-circle me-1"></i>
                                        Tạm dừng
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Ngày tạo</h6>
                            <div class="mb-3">
                                <strong>{{ $paymentRate->created_at->format('d/m/Y H:i:s') }}</strong>
                                <br>
                                <small class="text-muted">
                                    ({{ $paymentRate->created_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                    </div>

                    @if($paymentRate->mo_ta)
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Mô tả</h6>
                            <div class="alert alert-light border">
                                <p class="mb-0">{{ $paymentRate->mo_ta }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Cập nhật lần cuối</h6>
                            <div class="mb-3">
                                <strong>{{ $paymentRate->updated_at->format('d/m/Y H:i:s') }}</strong>
                                <br>
                                <small class="text-muted">
                                    ({{ $paymentRate->updated_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Tính toán nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-primary mb-1">
                                {{ number_format($paymentRate->gia_tien_moi_tiet, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">VND / 1 tiết</div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-success mb-1">
                                {{ number_format($paymentRate->gia_tien_moi_tiet * 15, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">VND / 15 tiết (1 môn)</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-warning mb-1">
                                {{ number_format($paymentRate->gia_tien_moi_tiet * 45, 0, ',', '.') }}
                            </div>
                            <div class="small text-muted">VND / 45 tiết (3 môn)</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Thao tác
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.payment-rates.edit', $paymentRate) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Chỉnh sửa
                        </a>
                        <form action="{{ route('admin.payment-rates.destroy', $paymentRate) }}" 
                              method="POST" 
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa mức lương này?\n\nHành động này không thể hoàn tác!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                Xóa mức lương
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
