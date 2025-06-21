@extends('layouts.admin')

@section('title', 'Chi tiết Phân công')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-eye me-2"></i>
                    Chi tiết Phân công
                </h2>
                <div>
                    <a href="{{ route('admin.teaching-assignments.edit', $assignment) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Thông tin Phân công
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Giảng viên</h6>
                            <div class="mb-3">
                                <strong>{{ $assignment->teacher->ho_ten }}</strong>
                                <br>
                                <small class="text-muted">Mã số: {{ $assignment->teacher->ma_so }}</small>
                                <br>
                                <small class="text-muted">Khoa: {{ $assignment->teacher->department->ten_viet_tat }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Lớp học phần</h6>
                            <div class="mb-3">
                                <strong>{{ $assignment->classSubject->ma_lop }}</strong>
                                <br>
                                <small class="text-muted">Học phần: {{ $assignment->classSubject->subject->ten_hoc_phan }}</small>
                                <br>
                                <small class="text-muted">Sĩ số: {{ $assignment->classSubject->si_so_lop }} sinh viên</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Học kỳ</h6>
                            <div class="mb-3">
                                <strong>{{ $assignment->classSubject->semester->ten_ki }}</strong>
                                <br>
                                <small class="text-muted">Năm học: {{ $assignment->classSubject->semester->nam_hoc }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Ngày tạo</h6>
                            <div class="mb-3">
                                <strong>{{ $assignment->created_at->format('d/m/Y H:i') }}</strong>
                                <br>
                                <small class="text-muted">Cập nhật: {{ $assignment->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                    </div>

                    @if($assignment->ghi_chu)
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Ghi chú</h6>
                            <div class="alert alert-info">
                                {{ $assignment->ghi_chu }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Thống kê
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-primary mb-1">{{ $assignment->classSubject->subject->so_tin_chi }}</div>
                            <div class="small text-muted">Số tín chỉ</div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-success mb-1">{{ $assignment->classSubject->subject->so_tiet }}</div>
                            <div class="small text-muted">Số tiết</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="border rounded p-3 mb-3">
                            <div class="h4 text-info mb-1">{{ $assignment->classSubject->subject->he_so_hoc_phan }}</div>
                            <div class="small text-muted">Hệ số học phần</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Thao tác
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.teaching-assignments.edit', $assignment) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Chỉnh sửa
                        </a>
                        <form action="{{ route('admin.teaching-assignments.destroy', $assignment) }}" 
                              method="POST" 
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa phân công này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
