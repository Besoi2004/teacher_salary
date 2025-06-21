@extends('layouts.admin')

@section('title', 'Thêm Học kỳ mới')
@section('page-title', 'Thêm Học kỳ mới')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    Thêm Học kỳ mới
                </h5>
                <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.semesters.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ten_ki" class="form-label">
                                    Tên học kỳ <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('ten_ki') is-invalid @enderror" 
                                       id="ten_ki" 
                                       name="ten_ki" 
                                       value="{{ old('ten_ki') }}" 
                                       placeholder="Vd: Học kỳ 1, Học kỳ 2, Học kỳ hè"
                                       required>
                                @error('ten_ki')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nam_hoc" class="form-label">
                                    Năm học <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nam_hoc') is-invalid @enderror" 
                                       id="nam_hoc" 
                                       name="nam_hoc" 
                                       value="{{ old('nam_hoc') }}" 
                                       placeholder="Vd: 2024-2025"
                                       required>
                                @error('nam_hoc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ngay_bat_dau" class="form-label">
                                    Ngày bắt đầu <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('ngay_bat_dau') is-invalid @enderror" 
                                       id="ngay_bat_dau" 
                                       name="ngay_bat_dau" 
                                       value="{{ old('ngay_bat_dau') }}" 
                                       required>
                                @error('ngay_bat_dau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ngay_ket_thuc" class="form-label">
                                    Ngày kết thúc <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('ngay_ket_thuc') is-invalid @enderror" 
                                       id="ngay_ket_thuc" 
                                       name="ngay_ket_thuc" 
                                       value="{{ old('ngay_ket_thuc') }}" 
                                       required>
                                @error('ngay_ket_thuc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt học kỳ
                                    </label>
                                </div>
                                <small class="text-muted">Chỉ có một học kỳ được kích hoạt tại một thời điểm</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="ghi_chu" class="form-label">Ghi chú</label>
                                <textarea class="form-control @error('ghi_chu') is-invalid @enderror" 
                                          id="ghi_chu" 
                                          name="ghi_chu" 
                                          rows="3" 
                                          placeholder="Ghi chú thêm về học kỳ...">{{ old('ghi_chu') }}</textarea>
                                @error('ghi_chu')
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
                                    <li>Tên học kỳ: Nhập tên học kỳ như "Học kỳ 1", "Học kỳ 2", "Học kỳ hè"</li>
                                    <li>Năm học: Nhập theo định dạng "2024-2025"</li>
                                    <li>Ngày kết thúc phải sau ngày bắt đầu</li>
                                    <li>Chỉ nên kích hoạt một học kỳ tại một thời điểm</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Lưu Học kỳ
                                </button>
                                <a href="{{ route('admin.semesters.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Hủy bỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validate end date must be after start date
    document.getElementById('ngay_ket_thuc').addEventListener('change', function() {
        const startDate = document.getElementById('ngay_bat_dau').value;
        const endDate = this.value;
        
        if (startDate && endDate && endDate <= startDate) {
            alert('Ngày kết thúc phải sau ngày bắt đầu!');
            this.value = '';
        }
    });
</script>
@endsection
