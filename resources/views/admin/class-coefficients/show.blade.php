@extends('layouts.admin')

@section('title', 'Chi tiết Hệ số Lớp')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.class-coefficients.index') }}">Hệ số Lớp</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>
                <h4 class="page-title">Chi tiết Hệ số Lớp</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="ps-0" style="width: 200px;">ID:</th>
                                            <td class="text-muted">#{{ $classCoefficient->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Khoảng sinh viên:</th>
                                            <td>
                                                <span class="badge bg-info fs-6">
                                                    {{ $classCoefficient->tu_sv }} - {{ $classCoefficient->den_sv }} sinh viên
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Hệ số:</th>
                                            <td class="text-primary fw-bold fs-5">{{ $classCoefficient->he_so }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Trạng thái:</th>
                                            <td>
                                                @if($classCoefficient->trang_thai)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Ngưng hoạt động</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Mô tả:</th>
                                            <td class="text-muted">
                                                {{ $classCoefficient->mo_ta ?: 'Không có mô tả' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Ngày tạo:</th>
                                            <td class="text-muted">
                                                {{ $classCoefficient->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Cập nhật lần cuối:</th>
                                            <td class="text-muted">
                                                {{ $classCoefficient->updated_at->format('d/m/Y H:i:s') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Thao tác</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.class-coefficients.edit', $classCoefficient) }}" 
                                           class="btn btn-warning">
                                            <i class="mdi mdi-pencil me-1"></i> Chỉnh sửa
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.class-coefficients.destroy', $classCoefficient) }}" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa hệ số lớp này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="mdi mdi-delete me-1"></i> Xóa
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('admin.class-coefficients.index') }}" 
                                           class="btn btn-secondary">
                                            <i class="mdi mdi-arrow-left me-1"></i> Quay lại danh sách
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Thông tin bổ sung -->
                            <div class="card border mt-3">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Thông tin bổ sung</h5>
                                </div>
                                <div class="card-body">
                                    <small class="text-muted">
                                        <i class="mdi mdi-information-outline me-1"></i>
                                        Hệ số lớp được sử dụng để tính toán lương dựa trên số lượng sinh viên trong lớp.
                                        Lớp có nhiều sinh viên sẽ có hệ số cao hơn.
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
