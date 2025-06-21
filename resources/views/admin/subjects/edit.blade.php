@extends('layouts.admin')

@section('title', 'Chỉnh sửa Học phần')
@section('page-title', 'Chỉnh sửa Học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-edit me-2"></i>
                Chỉnh sửa Học phần
            </h2>
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-book me-2"></i>
                    Thông tin Học phần
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ma_so" class="form-label">
                                    <i class="fas fa-hashtag me-1"></i>
                                    Mã số học phần <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('ma_so') is-invalid @enderror" 
                                       id="ma_so" 
                                       name="ma_so" 
                                       value="{{ old('ma_so', $subject->ma_so) }}"
                                       placeholder="VD: CS101, MATH201..."
                                       required>
                                @error('ma_so')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="so_tin_chi" class="form-label">
                                    <i class="fas fa-credit-card me-1"></i>
                                    Số tín chỉ <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('so_tin_chi') is-invalid @enderror" 
                                       id="so_tin_chi" 
                                       name="so_tin_chi" 
                                       value="{{ old('so_tin_chi', $subject->so_tin_chi) }}"
                                       min="1" 
                                       max="10"
                                       required>
                                @error('so_tin_chi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ten_hoc_phan" class="form-label">
                            <i class="fas fa-book-open me-1"></i>
                            Tên học phần <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('ten_hoc_phan') is-invalid @enderror" 
                               id="ten_hoc_phan" 
                               name="ten_hoc_phan" 
                               value="{{ old('ten_hoc_phan', $subject->ten_hoc_phan) }}"
                               placeholder="Tên đầy đủ của học phần"
                               required>
                        @error('ten_hoc_phan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="he_so_hoc_phan" class="form-label">
                                    <i class="fas fa-percentage me-1"></i>
                                    Hệ số học phần
                                </label>
                                <input type="number" 
                                       class="form-control @error('he_so_hoc_phan') is-invalid @enderror" 
                                       id="he_so_hoc_phan" 
                                       name="he_so_hoc_phan" 
                                       value="{{ old('he_so_hoc_phan', $subject->he_so_hoc_phan) }}"
                                       step="0.01" 
                                       min="0.5" 
                                       max="2.0">
                                @error('he_so_hoc_phan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Hệ số tính lương cho học phần (0.5 - 2.0)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-clock me-1"></i>
                                    Số tiết học
                                </label>
                                <div class="form-control-plaintext bg-light rounded p-2">
                                    <span id="so_tiet_display">{{ $subject->so_tiet }}</span> tiết
                                    <small class="text-muted d-block">Tự động tính: Tín chỉ × 15</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">
                            <i class="fas fa-align-left me-1"></i>
                            Mô tả
                        </label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                  id="mo_ta" 
                                  name="mo_ta" 
                                  rows="4"
                                  placeholder="Mô tả chi tiết về học phần...">{{ old('mo_ta', $subject->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($subject->classSubjects->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Cảnh báo:</strong> Học phần này đã có {{ $subject->classSubjects->count() }} lớp học phần. 
                            Việc thay đổi thông tin có thể ảnh hưởng đến dữ liệu liên quan.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Cập nhật học phần
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
                    <i class="fas fa-info-circle me-2"></i>
                    Hướng dẫn
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Lưu ý:</h6>
                    <ul class="mb-0">
                        <li>Mã số học phần phải là duy nhất</li>
                        <li>Số tín chỉ thường từ 1-4 cho môn cơ bản</li>
                        <li>Hệ số học phần ảnh hưởng đến lương giảng dạy</li>
                        <li>Số tiết = Tín chỉ × 15 (tự động tính)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto calculate và hiển thị số tiết based on tín chỉ
    const tinChiInput = document.getElementById('so_tin_chi');
    const soTietDisplay = document.getElementById('so_tiet_display');
    
    function updateSoTiet() {
        const tinChi = parseInt(tinChiInput.value);
        if (tinChi && tinChi > 0) {
            const soTiet = tinChi * 15;
            soTietDisplay.textContent = soTiet;
        } else {
            soTietDisplay.textContent = '0';
        }
    }
    
    tinChiInput.addEventListener('input', updateSoTiet);
    
    // Validate mã số format
    const maSoInput = document.getElementById('ma_so');
    maSoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endsection
