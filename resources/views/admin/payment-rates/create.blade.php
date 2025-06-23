@extends('layouts.admin')

@section('title', 'Thêm mức lương mới')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-plus me-2"></i>
                    Thêm mức lương mới
                </h2>
                <a href="{{ route('admin.payment-rates.index') }}" class="btn btn-secondary">
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
                        Thông tin mức lương
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment-rates.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ten_muc_luong" class="form-label">
                                        Tên mức lương <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ten_muc_luong') is-invalid @enderror" 
                                           id="ten_muc_luong" 
                                           name="ten_muc_luong" 
                                           value="{{ old('ten_muc_luong') }}"
                                           placeholder="VD: Giảng viên chính, Thạc sĩ, Tiến sĩ...">
                                    @error('ten_muc_luong')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gia_tien_moi_tiet" class="form-label">
                                        Giá tiền mỗi tiết (VND) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('gia_tien_moi_tiet') is-invalid @enderror" 
                                           id="gia_tien_moi_tiet" 
                                           name="gia_tien_moi_tiet" 
                                           value="{{ old('gia_tien_moi_tiet') }}"
                                           min="0" 
                                           step="0.01"
                                           placeholder="VD: 150000">
                                    @error('gia_tien_moi_tiet')
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
                                      placeholder="Mô tả chi tiết về mức lương này...">{{ old('mo_ta') }}</textarea>
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
                                    Kích hoạt mức lương này
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Lưu mức lương
                            </button>
                            <a href="{{ route('admin.payment-rates.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
