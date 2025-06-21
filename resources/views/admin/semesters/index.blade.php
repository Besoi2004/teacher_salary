@extends('layouts.admin')

@section('title', 'Quản lý Học kỳ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Danh sách Học kỳ
                    </h5>
                    <div>
                        <a href="{{ route('admin.semesters.statistics') }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-chart-bar me-1"></i>
                            Thống kê
                        </a>
                        <a href="{{ route('admin.semesters.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            Thêm Học kỳ
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Học kỳ</th>
                                    
                                    <th>Năm học</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($semesters as $index => $semester)
                                    <tr>                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $semester->ten_ki }}</strong>
                                            @if($semester->is_active)
                                                <span class="badge bg-success ms-2">Đang hoạt động</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $semester->nam_hoc }}
                                            </span>
                                        </td>                                        <td>{{ $semester->ngay_bat_dau ? $semester->ngay_bat_dau->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ $semester->ngay_ket_thuc ? $semester->ngay_ket_thuc->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.semesters.show', $semester) }}" 
                                                   class="btn btn-outline-info btn-sm" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.semesters.edit', $semester) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($semester->classSubjects->count() == 0)
                                                    <form action="{{ route('admin.semesters.destroy', $semester) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa học kỳ này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-outline-secondary btn-sm" disabled title="Không thể xóa học kỳ đã có lớp học phần">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                <p>Chưa có học kỳ nào được tạo.</p>
                                                <a href="{{ route('admin.semesters.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>
                                                    Thêm Học kỳ đầu tiên
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
