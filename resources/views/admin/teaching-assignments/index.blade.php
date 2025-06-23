@extends('layouts.admin')

@section('title', 'Quản lý Phân công Giảng dạy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users-cog me-2"></i>
                        Danh sách Phân công Giảng dạy
                    </h5>
                    <div>
                        
                        <a href="{{ route('admin.teaching-assignments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            Thêm Phân công
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
                                    <th>Mã GV</th>
                                    <th>Tên GV</th>
                                    <th>Lớp học phần</th>
                                    <th>Sĩ số lớp</th>
                                    <th>Học kỳ</th>
                                    <th>Năm học</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>                                @forelse($assignments as $index => $assignment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $assignment->teacher->ma_so }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $assignment->teacher->ho_ten }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $assignment->teacher->department->ten_viet_tat }}</small>
                                        </td>                                        <td>
                                            <div>
                                                <strong>{{ $assignment->classSubject->ma_lop }}</strong>
                                                <br>
                                                <span class="text">{{ $assignment->classSubject->ten_lop }}</span>
                                                <br>
                                                
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $assignment->classSubject->si_so_lop }} sinh viên</span>
                                        </td>
                                        <td>
                                            <strong>{{ $assignment->classSubject->semester->ten_ki }}</strong>
                                        </td>                                        <td>
                                            <strong>{{ $assignment->classSubject->semester->nam_hoc }}</strong>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                
                                                <a href="{{ route('admin.teaching-assignments.edit', $assignment) }}" 
                                                   class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.teaching-assignments.destroy', $assignment) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa phân công này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-user-times fa-3x mb-3"></i>
                                                <p>Chưa có phân công giảng dạy nào.</p>
                                                <a href="{{ route('admin.teaching-assignments.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>
                                                    Thêm Phân công đầu tiên
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
