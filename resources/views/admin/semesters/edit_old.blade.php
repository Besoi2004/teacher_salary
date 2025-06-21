@extends('layouts.admin')

@section('title', 'Chỉnh sửa Học kỳ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh sửa Học kỳ: {{ $semester->semester_name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.semesters.update', $semester) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="semester_name" class="form-label">
                                        Tên Học kỳ <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('semester_name') is-invalid @enderror" 
                                           id="semester_name" 
                                           name="semester_name" 
                                           value="{{ old('semester_name', $semester->semester_name) }}" 
                                           placeholder="Vd: Học kỳ 1 năm học 2024-2025"
                                           required>
                                    @error('semester_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="semester_number" class="form-label">
                                        Học kỳ <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('semester_number') is-invalid @enderror" 
                                            id="semester_number" 
                                            name="semester_number" 
                                            required>
                                        <option value="">Chọn học kỳ</option>
                                        <option value="1" {{ old('semester_number', $semester->semester_number) == '1' ? 'selected' : '' }}>Học kỳ 1</option>
                                        <option value="2" {{ old('semester_number', $semester->semester_number) == '2' ? 'selected' : '' }}>Học kỳ 2</option>
                                        <option value="3" {{ old('semester_number', $semester->semester_number) == '3' ? 'selected' : '' }}>Học kỳ hè</option>
                                    </select>
                                    @error('semester_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="year" class="form-label">
                                        Năm bắt đầu <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('year') is-invalid @enderror" 
                                           id="year" 
                                           name="year" 
                                           value="{{ old('year', $semester->year) }}" 
                                           min="2020" 
                                           max="2030"
                                           required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">
                                        Ngày bắt đầu <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date', $semester->start_date) }}" 
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">
                                        Ngày kết thúc <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date', $semester->end_date) }}" 
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($semester->classSubjects->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Cảnh báo:</strong> Học kỳ này đã có {{ $semester->classSubjects->count() }} lớp học phần. 
                                Việc thay đổi thông tin có thể ảnh hưởng đến dữ liệu liên quan.
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Cập nhật Học kỳ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
