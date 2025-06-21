@extends('layouts.admin')

@section('title', 'Thêm hệ số giáo viên mới')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-plus me-2"></i>
                    Thêm hệ số giáo viên mới
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
                    <form action="{{ route('admin.teacher-coefficients.store') }}" method="POST">
                        @csrf
                        
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
                                           value="{{ old('ten_bang_cap') }}"
                                           placeholder="VD: Đại học, Thạc sĩ, Tiến sĩ...">
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
                                           value="{{ old('he_so') }}"
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
                                      placeholder="Mô tả chi tiết về hệ số này...">{{ old('mo_ta') }}</textarea>
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
                                       {{ old('trang_thai', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="trang_thai">
                                    Kích hoạt hệ số này
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Lưu hệ số
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
                        Hệ số thông dụng
                    </h5>
                </div>
                <div class="card-body">                    <div class="alert alert-info">
                        <h6><i class="fas fa-graduation-cap me-2"></i>Tham khảo:</h6>
                        <ul class="mb-0">
                            <li><strong>Cử nhân/Kỹ sư:</strong> 1.3</li>
                            <li><strong>Thạc sĩ:</strong> 1.5</li>
                            <li><strong>Tiến sĩ:</strong> 1.7</li>
                            <li><strong>Phó giáo sư:</strong> 2.0</li>
                            <li><strong>Giáo sư:</strong> 2.5</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-lightbulb me-2"></i>Lưu ý:</h6>
                        <ul class="mb-0">
                            <li>Hệ số từ 1.0 đến 10.0</li>
                            <li>Hệ số càng cao, mức lương càng cao</li>
                            <li>Chỉ hệ số được kích hoạt mới hiển thị khi chọn</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
