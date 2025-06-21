@extends('layouts.admin')

@section('title', 'Chi tiết Lớp học phần')
@section('page-title', 'Chi tiết Lớp học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-chalkboard-teacher me-2"></i>
                Chi tiết Lớp học phần
            </h2>
            <div>
                <a href="{{ route('admin.class-subjects.edit', $classSubject) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa
                </a>
                <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-secondary">
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
                    Thông tin Lớp học phần
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-hashtag me-1"></i>
                                Mã lớp:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-primary fs-6">{{ $classSubject->ma_lop }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-credit-card me-1"></i>
                                Số tín chỉ:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-success fs-6">{{ $classSubject->credits }} tín chỉ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-chalkboard me-1"></i>
                        Tên lớp:
                    </label>
                    <div class="form-control-plaintext fs-5">
                        {{ $classSubject->ten_lop }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-book me-1"></i>
                                Học phần:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-info fs-6">{{ $classSubject->subject->ma_so }}</span>
                                - {{ $classSubject->subject->ten_hoc_phan }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar me-1"></i>
                                Học kỳ:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-warning text-dark fs-6">
                                    {{ $classSubject->semester->ten_ki }} {{ $classSubject->semester->nam_hoc }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock me-1"></i>
                                Giờ lý thuyết:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-primary fs-6">{{ $classSubject->theory_hours }} giờ</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-laptop-code me-1"></i>
                                Giờ thực hành:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-success fs-6">{{ $classSubject->practice_hours }} giờ</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-users me-1"></i>
                                Sinh viên:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-{{ $classSubject->current_students > $classSubject->max_students ? 'danger' : 'info' }} fs-6">
                                    {{ $classSubject->current_students }}/{{ $classSubject->max_students }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($classSubject->ghi_chu)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-sticky-note me-1"></i>
                        Ghi chú:
                    </label>
                    <div class="form-control-plaintext">
                        <div class="bg-light p-3 rounded">
                            {{ $classSubject->ghi_chu }}
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Ngày tạo:
                            </label>
                            <div class="form-control-plaintext">
                                {{ $classSubject->created_at->format('d/m/Y H:i') }}
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
                                {{ $classSubject->updated_at->format('d/m/Y H:i') }}
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
                    Thống kê
                </h5>
            </div>
            <div class="card-body">
                @php
                    $assignments = $classSubject->teachingAssignments;
                    $totalTeachers = $assignments->count();
                    $totalHours = $assignments->sum(function($ta) {
                        return $ta->theory_hours_assigned + $ta->practice_hours_assigned;                    });
                @endphp
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-primary mb-1">{{ $totalTeachers }}</div>
                            <div class="small text-muted">Giảng viên</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-success mb-1">{{ $classSubject->si_so_lop }}</div>
                            <div class="small text-muted">Sĩ số lớp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($assignments->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    Giảng viên phụ trách
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($assignments as $assignment)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $assignment->teacher->ho_ten }}</h6>
                                <p class="mb-1 small text-muted">{{ $assignment->teacher->ma_so }}</p>
                                <small>
                                    <span class="badge bg-{{ $assignment->role == 'Giảng viên chính' ? 'primary' : 'secondary' }}">
                                        {{ $assignment->role }}
                                    </span>
                                </small>
                            </div>                            <div class="text-end">
                                <small class="text-muted">
                                    Phân công giảng dạy
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
