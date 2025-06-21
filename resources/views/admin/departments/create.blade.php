@extends('layouts.admin')

@section('title', 'Thêm Khoa mới')
@section('page-title', 'Thêm Khoa mới')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-plus-circle me-2"></i>
                Thêm Khoa mới
            </h2>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-building me-2"></i>
                    Thông tin Khoa
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="ten_day_du" class="form-label">
                            <i class="fas fa-heading me-1"></i>
                            Tên đầy đủ <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('ten_day_du') is-invalid @enderror" 
                               id="ten_day_du" 
                               name="ten_day_du" 
                               value="{{ old('ten_day_du') }}"
                               placeholder="Ví dụ: Khoa Công nghệ thông tin"
                               required>
                        @error('ten_day_du')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ten_viet_tat" class="form-label">
                            <i class="fas fa-tag me-1"></i>
                            Tên viết tắt <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('ten_viet_tat') is-invalid @enderror" 
                               id="ten_viet_tat" 
                               name="ten_viet_tat" 
                               value="{{ old('ten_viet_tat') }}"
                               placeholder="Ví dụ: CNTT"
                               required>
                        @error('ten_viet_tat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tên viết tắt phải là duy nhất trong hệ thống.</div>
                    </div>

                    <div class="mb-4">
                        <label for="mo_ta_nhiem_vu" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Mô tả nhiệm vụ
                        </label>
                        <textarea class="form-control @error('mo_ta_nhiem_vu') is-invalid @enderror" 
                                  id="mo_ta_nhiem_vu" 
                                  name="mo_ta_nhiem_vu" 
                                  rows="4"
                                  placeholder="Mô tả nhiệm vụ và hoạt động chính của khoa...">{{ old('mo_ta_nhiem_vu') }}</textarea>
                        @error('mo_ta_nhiem_vu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Lưu Khoa
                        </button>
                        <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Hướng dẫn
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Tên đầy đủ nên mô tả rõ ràng về khoa
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Tên viết tắt nên ngắn gọn và dễ nhớ
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Mô tả nhiệm vụ giúp hiểu rõ chức năng khoa
                    </li>
                    <li>
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Tên viết tắt phải là duy nhất
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
