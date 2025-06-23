@extends('layouts.admin')

@section('title', 'Chỉnh sửa Bằng cấp')
@section('page-title', 'Chỉnh sửa Bằng cấp')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa Bằng cấp
            </h2>
            <div>
                
                <a href="{{ route('admin.degrees.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-certificate me-2"></i>
                    Thông tin Bằng cấp
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.degrees.update', $degree) }}" method="POST">
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
                               value="{{ old('ten_day_du', $degree->ten_day_du) }}"
                               placeholder="Ví dụ: Tiến sĩ Công nghệ thông tin"
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
                               value="{{ old('ten_viet_tat', $degree->ten_viet_tat) }}"
                               placeholder="Ví dụ: TS.CNTT"
                               required>
                        @error('ten_viet_tat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Tên viết tắt phải là duy nhất trong hệ thống.</div>
                    </div>

                    <div class="mb-4">
                        <label for="mo_ta" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Mô tả
                        </label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" 
                                  name="mo_ta" 
                                  rows="4"
                                  placeholder="Mô tả chi tiết về bằng cấp này...">{{ old('mo_ta', $degree->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Cập nhật Bằng cấp
                        </button>
                        
                        <a href="{{ route('admin.degrees.index') }}" class="btn btn-outline-secondary">
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
