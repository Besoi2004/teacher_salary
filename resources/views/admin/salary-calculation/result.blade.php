@extends('layouts.admin')

@section('title', 'Kết quả tính tiền dạy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.salary-calculation.index') }}">Tính tiền dạy</a></li>
                        <li class="breadcrumb-item active">Kết quả</li>
                    </ol>
                </div>
                <h4 class="page-title">Kết quả tính tiền dạy</h4>
            </div>
        </div>
    </div>

    <!-- Thông tin giáo viên -->
    <div class="row">
        <div class="col-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-account-circle me-2"></i>
                        Thông tin giáo viên
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold" style="width: 140px;">Mã số:</td>
                                        <td>{{ $teacher->ma_so }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Họ tên:</td>
                                        <td>{{ $teacher->ho_ten }}</td>
                                    </tr>                                    <tr>
                                        <td class="fw-bold">Khoa/Bộ môn:</td>
                                        <td>{{ $teacher->department->ten_day_du ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless mb-0">
                                <tbody>                                    <tr>
                                        <td class="fw-bold" style="width: 140px;">Bằng cấp:</td>
                                        <td>{{ $teacher->degree->ten_day_du ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Học kỳ:</td>
                                        <td>{{ $semester->ten_ki }} - {{ $semester->nam_hoc }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Hệ số giáo viên:</td>
                                        <td><span class="badge bg-info fs-6">{{ $teacherCoefficient->he_so }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết tính toán -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-calculator me-2"></i>
                        Chi tiết tính toán
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" style="width: 60px;">STT</th>
                                    <th>Mã lớp</th>
                                    <th>Tên lớp</th>
                                    <th>Tên học phần</th>
                                    <th class="text-center">Số tiết</th>
                                    <th class="text-center">Số SV</th>
                                    <th class="text-center">Hệ số HP</th>
                                    <th class="text-center">Hệ số lớp</th>
                                    <th class="text-center">Tiết quy đổi</th>
                                    <th class="text-center">Hệ số GV</th>
                                    <th class="text-end">Tiền/tiết</th>
                                    <th class="text-end">Tiền dạy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculations as $calc)
                                    <tr>
                                        <td class="text-center">{{ $calc['stt'] }}</td>
                                        <td><span class="badge bg-secondary">{{ $calc['ma_lop'] }}</span></td>
                                        <td>{{ $calc['ten_lop'] }}</td>
                                        <td>{{ $calc['ten_hoc_phan'] }}</td>
                                        <td class="text-center">{{ $calc['so_tiet'] }}</td>
                                        <td class="text-center">{{ $calc['so_sinh_vien'] }}</td>
                                        <td class="text-center">{{ $calc['he_so_hoc_phan'] }}</td>
                                        <td class="text-center">{{ $calc['he_so_lop'] }}</td>
                                        <td class="text-center fw-bold text-primary">{{ $calc['tiet_quy_doi'] }}</td>
                                        <td class="text-center">{{ $calc['he_so_gv'] }}</td>
                                        <td class="text-end">{{ number_format($calc['tien_mot_tiet'], 0, ',', '.') }} đ</td>
                                        <td class="text-end fw-bold text-success">{{ number_format($calc['tien_day'], 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng kết tiền lương -->
    <div class="row">
        <div class="col-12">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-cash-multiple me-2"></i>
                        Tổng kết tiền lương
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted mb-1">Tổng số lớp dạy</h6>
                                <h4 class="text-primary mb-0">{{ count($calculations) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted mb-1">Tổng số tiết</h6>
                                <h4 class="text-info mb-0">{{ array_sum(array_column($calculations, 'so_tiet')) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3">
                                <h6 class="text-muted mb-1">Tổng tiết quy đổi</h6>
                                <h4 class="text-warning mb-0">{{ number_format(array_sum(array_column($calculations, 'tiet_quy_doi')), 1) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3 bg-success text-white">
                                <h6 class="mb-1 text-white-50">TỔNG TIỀN LƯƠNG</h6>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalSalary, 0, ',', '.') }} đ</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút điều hướng -->
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <a href="{{ route('admin.salary-calculation.index') }}" class="btn btn-secondary me-2">
                    <i class="mdi mdi-arrow-left me-1"></i> Tính toán khác
                </a>
                
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .breadcrumb, .btn, .card-header { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
    .table { font-size: 12px; }
}
</style>
@endsection
