@extends('layouts.admin')

@section('title', 'Chỉnh sửa Phân công Giảng dạy')
@section('page-title', 'Chỉnh sửa Phân công Giảng dạy')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa Phân công Giảng dạy
            </h2>
            <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại
            </a>
        </div>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Lỗi:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Thông tin phân công
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.teaching-assignments.update', $teachingAssignment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">
                                    <i class="fas fa-chalkboard-teacher me-1"></i>
                                    Giảng viên <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                        id="teacher_id" 
                                        name="teacher_id" 
                                        required>
                                    <option value="">Chọn giảng viên</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                                {{ old('teacher_id', $teachingAssignment->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->ho_ten }} ({{ $teacher->ma_so }}) - {{ $teacher->department->ten_viet_tat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="class_subject_id" class="form-label">
                                    <i class="fas fa-chalkboard me-1"></i>
                                    Lớp học phần <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('class_subject_id') is-invalid @enderror" 
                                        id="class_subject_id" 
                                        name="class_subject_id" 
                                        required>
                                    <option value="">Chọn lớp học phần</option>
                                    @foreach($classSubjects as $classSubject)
                                        <option value="{{ $classSubject->id }}" 
                                                {{ old('class_subject_id', $teachingAssignment->class_subject_id) == $classSubject->id ? 'selected' : '' }}>
                                            {{ $classSubject->ma_lop }} - {{ $classSubject->subject->ten_hoc_phan }} 
                                            ({{ $classSubject->semester->ten_ki }} - {{ $classSubject->semester->nam_hoc }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="si_so_lop" class="form-label">
                                    <i class="fas fa-users me-1"></i>
                                    Sĩ số lớp <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('si_so_lop') is-invalid @enderror" 
                                       id="si_so_lop" 
                                       name="si_so_lop" 
                                       value="{{ old('si_so_lop', $teachingAssignment->classSubject->si_so_lop ?? 30) }}"
                                       min="1" 
                                       max="100"
                                       required>
                                @error('si_so_lop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Số sinh viên thực tế trong lớp</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ghi_chu" class="form-label">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    Ghi chú
                                </label>
                                <textarea class="form-control @error('ghi_chu') is-invalid @enderror" 
                                          id="ghi_chu" 
                                          name="ghi_chu" 
                                          rows="3"
                                          placeholder="Ghi chú thêm về phân công này...">{{ old('ghi_chu', $teachingAssignment->ghi_chu) }}</textarea>
                                @error('ghi_chu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Cập nhật phân công
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
