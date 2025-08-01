@extends('layouts.admin')

@section('title', 'Thêm Học kỳ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>
                        Thêm Học kỳ mới
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.semesters.store') }}" method="POST">
                        @csrf
                        
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
                                           value="{{ old('semester_name') }}" 
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
                                        <option value="1" {{ old('semester_number') == '1' ? 'selected' : '' }}>Học kỳ 1</option>
                                        <option value="2" {{ old('semester_number') == '2' ? 'selected' : '' }}>Học kỳ 2</option>
                                        <option value="3" {{ old('semester_number') == '3' ? 'selected' : '' }}>Học kỳ hè</option>
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
                                           value="{{ old('year', date('Y')) }}" 
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
                                           value="{{ old('start_date') }}" 
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
                                           value="{{ old('end_date') }}" 
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="border p-3 mb-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Hướng dẫn:
                                    </h6>
                                    <ul class="mb-0 small text-muted">
                                        <li>Tên học kỳ nên mô tả rõ ràng và đầy đủ</li>
                                        <li>Học kỳ 1: thường từ tháng 9 đến tháng 1</li>
                                        <li>Học kỳ 2: thường từ tháng 2 đến tháng 6</li>
                                        <li>Học kỳ hè: thường từ tháng 7 đến tháng 8</li>
                                        <li>Không thể tạo trùng học kỳ trong cùng một năm học</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Lưu Học kỳ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate semester name when semester_number and year change
    const semesterNumber = document.getElementById('semester_number');
    const year = document.getElementById('year');
    const semesterName = document.getElementById('semester_name');
    
    function updateSemesterName() {
        if (semesterNumber.value && year.value) {
            const semesterText = semesterNumber.value == '3' ? 'hè' : semesterNumber.value;
            semesterName.value = `Học kỳ ${semesterText} năm học ${year.value}-${parseInt(year.value) + 1}`;
        }
    }
    
    semesterNumber.addEventListener('change', updateSemesterName);
    year.addEventListener('change', updateSemesterName);
});
</script>
@endsection
