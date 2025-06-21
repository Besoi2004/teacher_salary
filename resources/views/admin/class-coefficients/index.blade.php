@extends('layouts.admin')

@section('title', 'Quản lý Hệ số Lớp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hệ số Lớp</li>
                    </ol>
                </div>
                <h4 class="page-title">Quản lý Hệ số Lớp</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <a href="{{ route('admin.class-coefficients.create') }}" class="btn btn-primary mb-2">
                                <i class="mdi mdi-plus-circle me-2"></i> Thêm Hệ số Lớp
                            </a>
                        </div>
                    </div>

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

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Khoảng Sinh viên</th>
                                    <th>Hệ số</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th style="width: 125px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classCoefficients as $index => $coefficient)
                                    <tr>
                                        <td>{{ $classCoefficients->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $coefficient->tu_sv }} - {{ $coefficient->den_sv }} SV
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary">{{ $coefficient->he_so }}</span>
                                        </td>
                                        <td>{{ $coefficient->mo_ta ?: 'Không có mô tả' }}</td>
                                        <td>
                                            @if($coefficient->trang_thai)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-danger">Ngưng</span>
                                            @endif
                                        </td>
                                        <td>{{ $coefficient->created_at->format('d/m/Y') }}</td>                                        <td>
                                            <a href="{{ route('admin.class-coefficients.show', $coefficient) }}" 
                                               class="action-icon btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.class-coefficients.edit', $coefficient) }}" 
                                               class="action-icon btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.class-coefficients.destroy', $coefficient) }}" 
                                                  class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-icon btn btn-sm btn-outline-danger" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-center">
                                                <i class="mdi mdi-information-outline h1 text-muted"></i>
                                                <h4 class="mt-2">Không có dữ liệu</h4>
                                                <p class="text-muted">Chưa có hệ số lớp nào được tạo.</p>
                                                <a href="{{ route('admin.class-coefficients.create') }}" class="btn btn-primary">
                                                    Thêm hệ số lớp đầu tiên
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($classCoefficients->hasPages())
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        Hiển thị {{ $classCoefficients->firstItem() }} đến {{ $classCoefficients->lastItem() }} 
                                        trong tổng số {{ $classCoefficients->total() }} bản ghi
                                    </div>
                                    {{ $classCoefficients->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
