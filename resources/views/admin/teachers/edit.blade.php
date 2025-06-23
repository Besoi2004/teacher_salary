@extends('layouts.admin')

@section('title', 'Chỉnh sửa Giáo viên')
@section('page-title', 'Chỉnh sửa Giáo viên')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa Giáo viên: {{ $teacher->ho_ten }}
            </h2>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-user-tie me-2"></i>
                    Thông tin Giáo viên
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ma_so" class="form-label">
                                    <i class="fas fa-id-card me-1"></i>
                                    Mã số giáo viên
                                </label>
                                <input type="text" 
                                       class="form-control @error('ma_so') is-invalid @enderror" 
                                       id="ma_so" 
                                       name="ma_so" 
                                       value="{{ old('ma_so', $teacher->ma_so) }}"
                                       placeholder="Để trống để tự động sinh mã">
                                @error('ma_so')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Bỏ trống để hệ thống tự động sinh mã.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ho_ten" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('ho_ten') is-invalid @enderror" 
                                       id="ho_ten" 
                                       name="ho_ten" 
                                       value="{{ old('ho_ten', $teacher->ho_ten) }}"
                                       placeholder="Nhập họ và tên đầy đủ"
                                       required>
                                @error('ho_ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ngay_sinh" class="form-label">
                                    <i class="fas fa-birthday-cake me-1"></i>
                                    Ngày sinh <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('ngay_sinh') is-invalid @enderror" 
                                       id="ngay_sinh" 
                                       name="ngay_sinh" 
                                       value="{{ old('ngay_sinh', $teacher->ngay_sinh) }}"
                                       required>
                                @error('ngay_sinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dien_thoai" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Điện thoại
                                </label>
                                <input type="tel" 
                                       class="form-control @error('dien_thoai') is-invalid @enderror" 
                                       id="dien_thoai" 
                                       name="dien_thoai" 
                                       value="{{ old('dien_thoai', $teacher->dien_thoai) }}"
                                       placeholder="Số điện thoại liên hệ">
                                @error('dien_thoai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i>
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $teacher->email) }}"
                               placeholder="Địa chỉ email"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department_id" class="form-label">
                                    <i class="fas fa-building me-1"></i>
                                    Khoa <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('department_id') is-invalid @enderror" 
                                        id="department_id" 
                                        name="department_id" 
                                        required>
                                    <option value="">Chọn khoa</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" 
                                                {{ old('department_id', $teacher->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->ten_day_du }} ({{ $department->ten_viet_tat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="degree_id" class="form-label">
                                    <i class="fas fa-certificate me-1"></i>
                                    Bằng cấp <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('degree_id') is-invalid @enderror" 
                                        id="degree_id" 
                                        name="degree_id" 
                                        required>
                                    <option value="">Chọn bằng cấp</option>
                                    @foreach($degrees as $degree)
                                        <option value="{{ $degree->id }}" 
                                                {{ old('degree_id', $teacher->degree_id) == $degree->id ? 'selected' : '' }}>
                                            {{ $degree->ten_day_du }} ({{ $degree->ten_viet_tat }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('degree_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Cập nhật Giáo viên
                        </button>

                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">
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
