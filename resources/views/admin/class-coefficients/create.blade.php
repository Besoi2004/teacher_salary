@extends('layouts.admin')

@section('title', 'Thêm Hệ số Lớp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.class-coefficients.index') }}">Hệ số Lớp</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>
                <h4 class="page-title">Thêm Hệ số Lớp</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.class-coefficients.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tu_sv" class="form-label">Từ số sinh viên <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tu_sv') is-invalid @enderror" 
                                           id="tu_sv" name="tu_sv" value="{{ old('tu_sv') }}" 
                                           min="0" required>
                                    @error('tu_sv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ví dụ: 0, 30, 50...</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="den_sv" class="form-label">Đến số sinh viên <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('den_sv') is-invalid @enderror" 
                                           id="den_sv" name="den_sv" value="{{ old('den_sv') }}" 
                                           min="0" required>
                                    @error('den_sv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ví dụ: 29, 49, 99...</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="he_so" class="form-label">Hệ số <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('he_so') is-invalid @enderror" 
                                           id="he_so" name="he_so" value="{{ old('he_so') }}" 
                                           step="0.01" min="0" required>
                                    @error('he_so')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ví dụ: 0.8, 1.0, 1.2, 1.5...</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trang_thai" class="form-label">Trạng thái</label>
                                    <select class="form-select @error('trang_thai') is-invalid @enderror" 
                                            id="trang_thai" name="trang_thai">
                                        <option value="1" {{ old('trang_thai', 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ old('trang_thai') == 0 ? 'selected' : '' }}>Ngưng hoạt động</option>
                                    </select>
                                    @error('trang_thai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mo_ta" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                      id="mo_ta" name="mo_ta" rows="3" 
                                      placeholder="Mô tả về hệ số lớp này...">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.class-coefficients.index') }}" class="btn btn-secondary me-2">
                                <i class="mdi mdi-arrow-left me-1"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save me-1"></i> Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('tu_sv').addEventListener('input', function() {
    var tuSv = parseInt(this.value);
    var denSvInput = document.getElementById('den_sv');
    if (tuSv >= 0) {
        denSvInput.min = tuSv;
        if (parseInt(denSvInput.value) < tuSv) {
            denSvInput.value = tuSv;
        }
    }
});
</script>
@endsection
