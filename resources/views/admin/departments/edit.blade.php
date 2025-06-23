@extends('layouts.admin')

@section('title', 'Chỉnh sửa Khoa')
@section('page-title', 'Chỉnh sửa Khoa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa Khoa
            </h2>
            <div>

                <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Quay lại
                </a>
            </div>
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
                <form action="{{ route('admin.departments.update', $department) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="ten_day_du" class="form-label">
                            <i class="fas fa-heading me-1"></i>
                            Tên đầy đủ <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('ten_day_du') is-invalid @enderror" 
                               id="ten_day_du" 
                               name="ten_day_du" 
                               value="{{ old('ten_day_du', $department->ten_day_du) }}"
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
                               value="{{ old('ten_viet_tat', $department->ten_viet_tat) }}"
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
                                  placeholder="Mô tả nhiệm vụ và hoạt động chính của khoa...">{{ old('mo_ta_nhiem_vu', $department->mo_ta_nhiem_vu) }}</textarea>
                        @error('mo_ta_nhiem_vu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Cập nhật Khoa
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


</div>
@endsection
