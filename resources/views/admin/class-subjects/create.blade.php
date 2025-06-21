@extends('layouts.admin')

@section('title', 'Thêm Lớp học phần')
@section('page-title', 'Thêm Lớp học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-plus-circle me-2"></i>
                Thêm Lớp học phần mới
            </h2>
            <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-chalkboard-teacher me-2"></i>
                    Thông tin Lớp học phần
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.class-subjects.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
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
                                        <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
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
                        
                        <div class="col-md-6">
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
                                        <option value="{{ $subject->id }}" 
                                                data-ma-so="{{ $subject->ma_so }}" 
                                                data-ten="{{ $subject->ten_hoc_phan }}"
                                                {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->ma_so }} - {{ $subject->ten_hoc_phan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                    </div>                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="so_lop" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i>
                                    Số lớp cần tạo <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('so_lop') is-invalid @enderror" 
                                       id="so_lop" 
                                       name="so_lop" 
                                       value="{{ old('so_lop', 1) }}"
                                       min="1" 
                                       max="10"
                                       required>
                                @error('so_lop')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Hệ thống sẽ tự động tạo mã lớp và tên lớp theo quy tắc</div>
                            </div>
                        </div>
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
                                  placeholder="Ghi chú thêm về các lớp học phần này...">{{ old('ghi_chu') }}</textarea>
                        @error('ghi_chu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Tạo lớp học phần
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Học phần đã có lớp
                </h5>
            </div>
            <div class="card-body">
                @if($subjectsWithClasses->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($subjectsWithClasses as $subject)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">{{ $subject->ten_hoc_phan }}</h6>
                                    <small class="text-muted">{{ $subject->ma_so }}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $subject->class_subjects_count }} lớp</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">Chưa có học phần nào có lớp</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subjectSelect = document.getElementById('subject_id');
    const soLopInput = document.getElementById('so_lop');
    const previewContent = document.getElementById('preview-content');
    
    function updatePreview() {
        const selectedSubject = subjectSelect.options[subjectSelect.selectedIndex];
        const soLop = parseInt(soLopInput.value);
        
        if (selectedSubject.value && soLop > 0) {
            const maSo = selectedSubject.getAttribute('data-ma-so');
            const tenHocPhan = selectedSubject.getAttribute('data-ten');
            
            let html = '<div class="small">';
            html += '<strong>Sẽ tạo ' + soLop + ' lớp:</strong><br>';
            
            for (let i = 1; i <= soLop; i++) {
                const soThuTu = i.toString().padStart(2, '0');
                const maLop = maSo + '_' + soThuTu;
                const tenLop = tenHocPhan + '_N' + soThuTu;
                
                html += '<div class="mb-1">';
                html += '<span class="badge bg-primary me-1">' + maLop + '</span>';
                html += '<small>' + tenLop + '</small>';
                html += '</div>';
            }
            
            html += '</div>';
            previewContent.innerHTML = html;
        } else {
            previewContent.innerHTML = '<small class="text-muted">Vui lòng chọn học phần và nhập số lớp để xem trước</small>';
        }
    }
    
    subjectSelect.addEventListener('change', updatePreview);
    soLopInput.addEventListener('input', updatePreview);
    
    // Initialize preview
    updatePreview();
});
</script>
@endsection
