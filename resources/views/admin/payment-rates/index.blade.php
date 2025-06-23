@extends('layouts.admin')

@section('title', 'Quản lý Tiền theo tiết')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>
                        Danh sách Tiền theo tiết
                    </h5>
                    <div>
                        @if(!$hasPaymentRate)
                            <a href="{{ route('admin.payment-rates.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                Thêm mức lương
                            </a>
                        @else
                            <div class="alert alert-info mb-0 py-2 px-3 d-inline-block">
                                <i class="fas fa-info-circle me-1"></i>
                                <small>Hệ thống chỉ cho phép 1 mức lương duy nhất</small>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Thông báo hướng dẫn khi đã có mức lương -->
                    @if($hasPaymentRate)
                        <div class="alert alert-info" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Lưu ý:</strong> Hệ thống chỉ cho phép có một mức lương duy nhất. 
                                    Bạn có thể <strong>chỉnh sửa</strong> hoặc <strong>xóa</strong> mức lương hiện tại để tạo mức lương mới.
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên mức lương</th>
                                    <th>Giá tiền/tiết</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentRates as $index => $rate)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $rate->ten_muc_luong }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ number_format($rate->gia_tien_moi_tiet, 0, ',', '.') }} VND
                                            </span>
                                        </td>
                                        <td>
                                            @if($rate->mo_ta)
                                                <small class="text-muted">{{ Str::limit($rate->mo_ta, 50) }}</small>
                                            @else
                                                <small class="text-muted">Không có mô tả</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($rate->trang_thai)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-secondary">Tạm dừng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                
                                                <a href="{{ route('admin.payment-rates.edit', $rate) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>                                                <form action="{{ route('admin.payment-rates.destroy', $rate) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa mức lương này?\n\nLưu ý: Sau khi xóa, bạn có thể tạo mức lương mới.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="fas fa-money-bill-wave fa-3x mb-3 text-secondary"></i>
                                            <br>
                                            <h5>Chưa có mức lương nào</h5>
                                            <p class="mb-3">Hệ thống cần có ít nhất một mức lương để tính toán tiền dạy</p>
                                            @if(!$hasPaymentRate)
                                                <a href="{{ route('admin.payment-rates.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>
                                                    Tạo mức lương đầu tiên
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($paymentRates->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $paymentRates->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
