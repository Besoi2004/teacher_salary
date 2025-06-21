@extends('layouts.admin')

@section('title', 'Chỉnh sửa hệ số giáo viên')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa hệ số: {{ $teacherCoefficient->ten_bang_cap }}
                </h2>
                <a href="{{ route('admin.teacher-coefficients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Thông tin hệ số
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.teacher-coefficients.update', $teacherCoefficient) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ten_bang_cap" class="form-label">
                                        Tên bằng cấp <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ten_bang_cap') is-invalid @enderror" 
                                           id="ten_bang_cap" 
                                           name="ten_bang_cap" 
                                           value="{{ old('ten_bang_cap', $teacherCoefficient->ten_bang_cap) }}"
                                           placeholder="VD: Cử nhân/Kỹ sư, Thạc sĩ, Tiến sĩ...">
                                    @error('ten_bang_cap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="he_so" class="form-label">
                                        Hệ số <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('he_so') is-invalid @enderror" 
                                           id="he_so" 
                                           name="he_so" 
                                           value="{{ old('he_so', $teacherCoefficient->he_so) }}"
                                           min="1" 
                                           max="10"
                                           step="0.1"
                                           placeholder="VD: 1.5">
                                    @error('he_so')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mo_ta" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                      id="mo_ta" 
                                      name="mo_ta" 
                                      rows="3"
                                      placeholder="Mô tả chi tiết về hệ số này...">{{ old('mo_ta', $teacherCoefficient->mo_ta) }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="trang_thai" 
                                       name="trang_thai" 
                                       value="1" 
                                       {{ old('trang_thai', $teacherCoefficient->trang_thai) ? 'checked' : '' }}>
                                <label class="form-check-label" for="trang_thai">
                                    Kích hoạt hệ số này
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Cập nhật hệ số
                            </button>
                            <a href="{{ route('admin.teacher-coefficients.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin hiện tại
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Bằng cấp hiện tại:</small>
                        <div class="fw-bold">{{ $teacherCoefficient->ten_bang_cap }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Hệ số hiện tại:</small>
                        <div>
                            <span class="badge bg-primary fs-6 p-2">{{ $teacherCoefficient->he_so }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Trạng thái hiện tại:</small>
                        <div>
                            @if($teacherCoefficient->trang_thai)
                                <span class="badge bg-success">Đang hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Tạm dừng</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Ngày tạo:</small>
                        <div class="fw-bold">{{ $teacherCoefficient->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Cập nhật lần cuối:</small>
                        <div class="fw-bold">{{ $teacherCoefficient->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Tính toán mẫu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Ví dụ tính lương:</h6>
                        <p class="mb-2">Với hệ số <strong>{{ $teacherCoefficient->he_so }}</strong>:</p>
                        <ul class="mb-0">
                            <li>15 tiết × 150,000 VND × {{ $teacherCoefficient->he_so }} = <strong>{{ number_format(15 * 150000 * $teacherCoefficient->he_so, 0, ',', '.') }} VND</strong></li>
                            <li>30 tiết × 200,000 VND × {{ $teacherCoefficient->he_so }} = <strong>{{ number_format(30 * 200000 * $teacherCoefficient->he_so, 0, ',', '.') }} VND</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Hướng dẫn
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Lưu ý:</h6>
                        <ul class="mb-0">
                            <li>Tên bằng cấp phải khớp với bảng "Bằng cấp" trong quản lý giáo viên</li>
                            <li>Hệ số từ 1.0 đến 10.0, bước nhảy 0.1</li>
                            <li>Hệ số càng cao, lương tính ra càng cao</li>
                            <li>Tắt trạng thái sẽ ẩn hệ số này khỏi hệ thống tính lương</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
