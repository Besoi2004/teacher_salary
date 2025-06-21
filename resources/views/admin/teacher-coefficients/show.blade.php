@extends('layouts.admin')

@section('title', 'Chi tiết hệ số giáo viên')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-eye me-2"></i>
                    Chi tiết hệ số: {{ $teacherCoefficient->ten_bang_cap }}
                </h2>
                <div>
                    <a href="{{ route('admin.teacher-coefficients.edit', $teacherCoefficient) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.teacher-coefficients.index') }}" class="btn btn-secondary">
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
                            <h6 class="text-muted">Tên bằng cấp</h6>
                            <div class="mb-3">
                                <strong class="h5">{{ $teacherCoefficient->ten_bang_cap }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Hệ số</h6>
                            <div class="mb-3">
                                <span class="badge bg-primary fs-4 p-3">
                                    {{ $teacherCoefficient->he_so }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Trạng thái</h6>
                            <div class="mb-3">
                                @if($teacherCoefficient->trang_thai)
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
                                <strong>{{ $teacherCoefficient->created_at->format('d/m/Y H:i:s') }}</strong>
                                <br>
                                <small class="text-muted">
                                    ({{ $teacherCoefficient->created_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                    </div>

                    @if($teacherCoefficient->mo_ta)
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Mô tả</h6>
                            <div class="alert alert-light border">
                                <p class="mb-0">{{ $teacherCoefficient->mo_ta }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Cập nhật lần cuối</h6>
                            <div class="mb-3">
                                <strong>{{ $teacherCoefficient->updated_at->format('d/m/Y H:i:s') }}</strong>
                                <br>
                                <small class="text-muted">
                                    ({{ $teacherCoefficient->updated_at->diffForHumans() }})
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
                        Tính toán lương mẫu
                    </h5>
                </div>
                <div class="card-body">
                    <h6 class="text-muted mb-3">Với hệ số {{ $teacherCoefficient->he_so }}:</h6>
                    
                    <!-- Ví dụ 1: 15 tiết -->
                    <div class="border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-8">
                                <small class="text-muted">15 tiết × 150,000 VND</small>
                            </div>
                            <div class="col-4 text-end">
                                <small class="text-muted">× {{ $teacherCoefficient->he_so }}</small>
                            </div>
                        </div>
                        <div class="h5 text-success mb-0">
                            {{ number_format(15 * 150000 * $teacherCoefficient->he_so, 0, ',', '.') }} VND
                        </div>
                    </div>

                    <!-- Ví dụ 2: 30 tiết -->
                    <div class="border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-8">
                                <small class="text-muted">30 tiết × 200,000 VND</small>
                            </div>
                            <div class="col-4 text-end">
                                <small class="text-muted">× {{ $teacherCoefficient->he_so }}</small>
                            </div>
                        </div>
                        <div class="h5 text-primary mb-0">
                            {{ number_format(30 * 200000 * $teacherCoefficient->he_so, 0, ',', '.') }} VND
                        </div>
                    </div>

                    <!-- Ví dụ 3: 45 tiết -->
                    <div class="border rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-8">
                                <small class="text-muted">45 tiết × 180,000 VND</small>
                            </div>
                            <div class="col-4 text-end">
                                <small class="text-muted">× {{ $teacherCoefficient->he_so }}</small>
                            </div>
                        </div>
                        <div class="h5 text-warning mb-0">
                            {{ number_format(45 * 180000 * $teacherCoefficient->he_so, 0, ',', '.') }} VND
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Công thức: <strong>Số tiết × Giá/tiết × Hệ số</strong>
                        </small>
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
                        <a href="{{ route('admin.teacher-coefficients.edit', $teacherCoefficient) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Chỉnh sửa hệ số
                        </a>
                        <form action="{{ route('admin.teacher-coefficients.destroy', $teacherCoefficient) }}" 
                              method="POST" 
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa hệ số này?\n\nHành động này không thể hoàn tác!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                Xóa hệ số
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        So sánh hệ số
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light">
                        <small class="text-muted">Hệ số phổ biến:</small>
                        <ul class="mb-0 mt-2">
                            <li class="{{ $teacherCoefficient->he_so == 1.3 ? 'fw-bold text-primary' : '' }}">Cử nhân/Kỹ sư: 1.3</li>
                            <li class="{{ $teacherCoefficient->he_so == 1.5 ? 'fw-bold text-primary' : '' }}">Thạc sĩ: 1.5</li>
                            <li class="{{ $teacherCoefficient->he_so == 1.7 ? 'fw-bold text-primary' : '' }}">Tiến sĩ: 1.7</li>
                            <li class="{{ $teacherCoefficient->he_so == 2.0 ? 'fw-bold text-primary' : '' }}">Phó giáo sư: 2.0</li>
                            <li class="{{ $teacherCoefficient->he_so == 2.5 ? 'fw-bold text-primary' : '' }}">Giáo sư: 2.5</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
