@extends('layouts.admin')

@section('title', 'Chỉnh sửa Lớp học phần')
@section('page-title', 'Chỉnh sửa Lớp học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa Lớp học phần
            </h2>
            <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Thông tin Lớp học phần
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.class-subjects.update', $classSubject) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ma_lop" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i>
                                    Mã lớp <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('ma_lop') is-invalid @enderror" 
                                       id="ma_lop" 
                                       name="ma_lop" 
                                       value="{{ old('ma_lop', $classSubject->ma_lop) }}"
                                       placeholder="VD: CS101_01, MATH201_02..."
                                       required>
                                @error('ma_lop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ten_lop" class="form-label">
                                    <i class="fas fa-chalkboard me-1"></i>
                                    Tên lớp <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('ten_lop') is-invalid @enderror" 
                                       id="ten_lop" 
                                       name="ten_lop" 
                                       value="{{ old('ten_lop', $classSubject->ten_lop) }}"
                                       placeholder="VD: Lập trình cơ bản_N01..."
                                       required>
                                @error('ten_lop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="semester_id" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Học kỳ <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('semester_id') is-invalid @enderror" 
                                        id="semester_id" 
                                        name="semester_id" 
                                        required>
                                    <option value="">Chọn học kỳ</option>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" {{ old('semester_id', $classSubject->semester_id) == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->ten_ki }} - {{ $semester->nam_hoc }}
                                            @if($semester->is_active)
                                                (Đang hoạt động)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('semester_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="subject_id" class="form-label">
                                    <i class="fas fa-book me-1"></i>
                                    Học phần <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('subject_id') is-invalid @enderror" 
                                        id="subject_id" 
                                        name="subject_id" 
                                        required>
                                    <option value="">Chọn học phần</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id', $classSubject->subject_id) == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->ma_so }} - {{ $subject->ten_hoc_phan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ghi_chu" class="form-label">
                            <i class="fas fa-sticky-note me-1"></i>
                            Ghi chú
                        </label>
                        <textarea class="form-control @error('ghi_chu') is-invalid @enderror" 
                                  id="ghi_chu" 
                                  name="ghi_chu" 
                                  rows="3"
                                  placeholder="Ghi chú thêm về lớp học phần này...">{{ old('ghi_chu', $classSubject->ghi_chu) }}</textarea>
                        @error('ghi_chu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($classSubject->teachingAssignments->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Cảnh báo:</strong> Lớp học phần này đã có {{ $classSubject->teachingAssignments->count() }} phân công giảng dạy. 
                            Việc thay đổi thông tin có thể ảnh hưởng đến dữ liệu liên quan.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Cập nhật lớp học phần
                        </button>
                    </div>
                </form>
            </div>
        </div>    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate form before submit
    const form = document.querySelector('form');
    const maLopInput = document.getElementById('ma_lop');
    const tenLopInput = document.getElementById('ten_lop');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate mã lớp format
        const maLopPattern = /^[A-Z0-9]+_\d{2}$/;
        if (!maLopPattern.test(maLopInput.value)) {
            alert('Mã lớp phải có định dạng: [MÃ_HỌC_PHẦN]_[SỐ_THỨ_TỰ]. Ví dụ: CS101_01');
            maLopInput.focus();
            e.preventDefault();
            return;
        }
        
        // Validate tên lớp format  
        const tenLopPattern = /^.+_N\d{2}$/;
        if (!tenLopPattern.test(tenLopInput.value)) {
            alert('Tên lớp phải có định dạng: [TÊN_HỌC_PHẦN]_N[SỐ_THỨ_TỰ]. Ví dụ: Lập trình cơ bản_N01');
            tenLopInput.focus();
            e.preventDefault();
            return;
        }
    });
    
    // Auto uppercase mã lớp
    maLopInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endsection
