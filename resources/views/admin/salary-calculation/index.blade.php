@extends('layouts.admin')

@section('title', 'Tính tiền dạy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tính tiền dạy</li>
                    </ol>
                </div>
                <h4 class="page-title">Tính tiền dạy theo giáo viên</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.salary-calculation.calculate') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="semester_id" class="form-label">Chọn Học kỳ <span class="text-danger">*</span></label>
                                    <select class="form-select @error('semester_id') is-invalid @enderror" 
                                            id="semester_id" name="semester_id" required>
                                        <option value="">-- Chọn học kỳ --</option>
                                        @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}" 
                                                    {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                                {{ $semester->ten_ki }} - {{ $semester->nam_hoc }}
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
                                    <label for="teacher_id" class="form-label">Chọn Giáo viên <span class="text-danger">*</span></label>
                                    <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                            id="teacher_id" name="teacher_id" required>
                                        <option value="">-- Chọn giáo viên --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" 
                                                    {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->ma_so }} - {{ $teacher->ho_ten }} 
                                                ({{ $teacher->department->ten_viet_tat ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="mdi mdi-calculator me-2"></i>
                                Tính tiền dạy
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-muted">
                                <i class="mdi mdi-information-outline h2"></i>
                                <h5 class="mt-2">Hướng dẫn sử dụng</h5>
                                <p class="mb-0">
                                    1. Chọn học kỳ cần tính lương<br>
                                    2. Chọn giáo viên cần tính lương<br>
                                    3. Nhấn "Tính tiền dạy" để xem kết quả chi tiết
                                </p>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <strong>Công thức tính:</strong> 
                                        Tiền dạy = Số tiết quy đổi × Hệ số giáo viên × Tiền dạy một tiết<br>
                                        <strong>Số tiết quy đổi:</strong> 
                                        Số tiết thực tế × (Hệ số học phần + Hệ số lớp)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
