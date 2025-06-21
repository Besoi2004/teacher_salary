@extends('layouts.admin')

@section('title', 'Thêm Học phần mới')
@section('page-title', 'Thêm Học phần mới')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-plus-circle me-2"></i>
                Thêm Học phần mới
            </h2>
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>
                    Thông tin Học phần
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf
                    
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
                                       value="{{ old('ma_so') }}"
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
                                       value="{{ old('so_tin_chi') }}"
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
                               value="{{ old('ten_hoc_phan') }}"
                               placeholder="Tên đầy đủ của học phần"
                               required>
                        @error('ten_hoc_phan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror                    </div>

                    <div class="mb-3">
                        <label for="he_so_hoc_phan" class="form-label">
                            <i class="fas fa-percentage me-1"></i>
                            Hệ số học phần
                        </label>
                        <input type="number" 
                               class="form-control @error('he_so_hoc_phan') is-invalid @enderror" 
                               id="he_so_hoc_phan" 
                               name="he_so_hoc_phan" 
                               value="{{ old('he_so_hoc_phan', '1.00') }}"
                               step="0.01" 
                               min="0.5" 
                               max="2.0">
                        @error('he_so_hoc_phan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Hệ số quan trọng của học phần (0.5 - 2.0)</div>
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
                                  placeholder="Mô tả chi tiết về học phần...">{{ old('mo_ta') }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Lưu học phần
                        </button>
                    </div>                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate mã số format
    const maSoInput = document.getElementById('ma_so');
    maSoInput.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@endsection
