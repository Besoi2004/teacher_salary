@extends('layouts.admin')

@section('title', 'Chi tiết Giáo viên')
@section('page-title', 'Chi tiết Giáo viên')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-user-tie me-2"></i>
                Chi tiết Giáo viên
            </h2>
            <div>
                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa
                </a>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Thông tin Cá nhân
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-id-card me-1"></i>
                                Mã số giáo viên:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-primary fs-6">{{ $teacher->ma_so }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar me-1"></i>
                                Ngày sinh:
                            </label>
                            <div class="form-control-plaintext">
                                {{ $teacher->ngay_sinh ? $teacher->ngay_sinh->format('d/m/Y') : 'Chưa cập nhật' }}
                                @if($teacher->ngay_sinh)
                                    <small class="text-muted">({{ $teacher->ngay_sinh->age }} tuổi)</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-user me-1"></i>
                        Họ và tên:
                    </label>
                    <div class="form-control-plaintext fs-5">
                        {{ $teacher->ho_ten }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-envelope me-1"></i>
                                Email:
                            </label>
                            <div class="form-control-plaintext">
                                <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-phone me-1"></i>
                                Điện thoại:
                            </label>
                            <div class="form-control-plaintext">
                                <a href="tel:{{ $teacher->dien_thoai }}">{{ $teacher->dien_thoai }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-building me-1"></i>
                                Khoa:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-info fs-6">{{ $teacher->department->ten_khoa }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-graduation-cap me-1"></i>
                                Bằng cấp:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-success fs-6">{{ $teacher->degree->ten_bang_cap }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Ngày tạo:
                            </label>
                            <div class="form-control-plaintext">
                                {{ $teacher->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-edit me-1"></i>
                                Cập nhật lần cuối:
                            </label>
                            <div class="form-control-plaintext">
                                {{ $teacher->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Thống kê Giảng dạy
                </h5>
            </div>
            <div class="card-body">
                @php
                    $assignments = $teacher->teachingAssignments ?? collect();
                    $totalClasses = $assignments->count();
                    $totalHours = $assignments->sum(function($ta) {
                        return $ta->theory_hours_assigned + $ta->practice_hours_assigned;
                    });
                    $totalSalary = $assignments->sum(function($ta) {
                        return $ta->calculateSalary();
                    });
                @endphp
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-primary mb-1">{{ $totalClasses }}</div>
                            <div class="small text-muted">Lớp đang dạy</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-success mb-1">{{ $totalHours }}</div>
                            <div class="small text-muted">Tổng giờ dạy</div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="border rounded p-3 mb-3">
                        <div class="h4 text-warning mb-1">
                            {{ number_format($totalSalary, 0, ',', '.') }} VND
                        </div>
                        <div class="small text-muted">Tổng lương dự kiến</div>
                    </div>
                </div>
            </div>
        </div>

        @if($assignments->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Lớp đang dạy
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($assignments->take(5) as $assignment)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $assignment->classSubject->ma_lop }}</h6>
                                <p class="mb-1 small text-muted">{{ $assignment->classSubject->ten_lop }}</p>
                                <small>
                                    <span class="badge bg-{{ $assignment->role == 'Giảng viên chính' ? 'primary' : 'secondary' }}">
                                        {{ $assignment->role }}
                                    </span>
                                </small>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted">
                                    {{ $assignment->theory_hours_assigned + $assignment->practice_hours_assigned }} giờ
                                </div>
                                <div class="small text-success">
                                    {{ number_format($assignment->calculateSalary(), 0, ',', '.') }} VND
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($assignments->count() > 5)
                    <div class="list-group-item px-0 text-center">
                        <small class="text-muted">
                            Và {{ $assignments->count() - 5 }} lớp khác...
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
