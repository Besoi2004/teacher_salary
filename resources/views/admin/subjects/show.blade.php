@extends('layouts.admin')

@section('title', 'Chi tiết Học phần')
@section('page-title', 'Chi tiết Học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-book me-2"></i>
                Chi tiết Học phần
            </h2>
            <div>
                <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>
                    Chỉnh sửa
                </a>
                <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">
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
                    Thông tin Học phần
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-hashtag me-1"></i>
                                Mã số học phần:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-primary fs-6">{{ $subject->ma_so }}</span>
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
                                <span class="badge bg-success fs-6">{{ $subject->so_tin_chi }} tín chỉ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-book-open me-1"></i>
                        Tên học phần:
                    </label>
                    <div class="form-control-plaintext fs-5">
                        {{ $subject->ten_hoc_phan }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-percentage me-1"></i>
                                Hệ số học phần:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-info fs-6">{{ $subject->he_so_hoc_phan }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock me-1"></i>
                                Số tiết học:
                            </label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-warning text-dark fs-6">{{ $subject->so_tiet }} tiết</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($subject->mo_ta)
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-align-left me-1"></i>
                        Mô tả:
                    </label>
                    <div class="form-control-plaintext">
                        <div class="bg-light p-3 rounded">
                            {{ $subject->mo_ta }}
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
                                {{ $subject->created_at->format('d/m/Y H:i') }}
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
                                {{ $subject->updated_at->format('d/m/Y H:i') }}
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
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-primary mb-1">{{ $subject->classSubjects->count() }}</div>
                            <div class="small text-muted">Lớp học phần</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-success mb-1">
                                {{ $subject->classSubjects->sum('current_students') }}
                            </div>
                            <div class="small text-muted">Sinh viên</div>
                        </div>
                    </div>
                </div>
                
                @php
                    $totalAssignments = $subject->classSubjects->sum(function($cs) {
                        return $cs->teachingAssignments->count();
                    });
                    $totalSalary = $subject->classSubjects->sum(function($cs) {
                        return $cs->teachingAssignments->sum(function($ta) {
                            return $ta->calculateSalary();
                        });
                    });
                @endphp
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-info mb-1">{{ $totalAssignments }}</div>
                            <div class="small text-muted">Phân công</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-warning mb-1">
                                {{ number_format($totalSalary / 1000000, 1) }}M
                            </div>
                            <div class="small text-muted">Tổng lương</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($subject->classSubjects->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Lớp học phần
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($subject->classSubjects->take(5) as $classSubject)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $classSubject->ma_lop }}</h6>
                                <p class="mb-1 small text-muted">{{ $classSubject->ten_lop }}</p>
                                <small>
                                    <i class="fas fa-users me-1"></i>
                                    {{ $classSubject->current_students }}/{{ $classSubject->max_students }}
                                </small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">
                                    {{ $classSubject->semester->ten_ki }} {{ $classSubject->semester->nam_hoc }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($subject->classSubjects->count() > 5)
                    <div class="list-group-item px-0 text-center">
                        <small class="text-muted">
                            Và {{ $subject->classSubjects->count() - 5 }} lớp khác...
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
