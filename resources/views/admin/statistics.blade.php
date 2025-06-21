@extends('layouts.admin')

@section('title', 'Thống kê Giáo viên')
@section('page-title', 'Thống kê Giáo viên')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-chart-bar me-2"></i>
            Thống kê Giáo viên
        </h2>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-building me-2"></i>
                    Thống kê theo Khoa
                </h5>
            </div>
            <div class="card-body">
                @if($departmentStats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Khoa</th>
                                    <th>Tên viết tắt</th>
                                    <th class="text-center">Số giáo viên</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentStats as $department)
                                    <tr>
                                        <td>{{ $department->ten_day_du }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $department->ten_viet_tat }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $department->teachers_count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <th colspan="2">Tổng cộng:</th>
                                    <th class="text-center">
                                        <span class="badge bg-dark fs-6">{{ $departmentStats->sum('teachers_count') }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-building fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Chưa có dữ liệu khoa</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-certificate me-2"></i>
                    Thống kê theo Bằng cấp
                </h5>
            </div>
            <div class="card-body">
                @if($degreeStats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Bằng cấp</th>
                                    <th>Tên viết tắt</th>
                                    <th class="text-center">Số giáo viên</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($degreeStats as $degree)
                                    <tr>
                                        <td>{{ $degree->ten_day_du }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $degree->ten_viet_tat }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $degree->teachers_count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <th colspan="2">Tổng cộng:</th>
                                    <th class="text-center">
                                        <span class="badge bg-dark fs-6">{{ $degreeStats->sum('teachers_count') }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-certificate fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Chưa có dữ liệu bằng cấp</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Biểu đồ phân bố
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Phân bố theo Khoa:</h6>
                        @foreach($departmentStats as $department)
                            @php
                                $total = $departmentStats->sum('teachers_count');
                                $percentage = $total > 0 ? ($department->teachers_count / $total) * 100 : 0;
                            @endphp
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $department->ten_viet_tat }}</span>
                                    <span>{{ $department->teachers_count }} ({{ number_format($percentage, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Phân bố theo Bằng cấp:</h6>
                        @foreach($degreeStats as $degree)
                            @php
                                $total = $degreeStats->sum('teachers_count');
                                $percentage = $total > 0 ? ($degree->teachers_count / $total) * 100 : 0;
                            @endphp
                            <div class="mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $degree->ten_viet_tat }}</span>
                                    <span>{{ $degree->teachers_count }} ({{ number_format($percentage, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-info" 
                                         role="progressbar" 
                                         style="width: {{ $percentage }}%"
                                         aria-valuenow="{{ $percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-primary">
                <i class="fas fa-users me-2"></i>
                Xem danh sách Giáo viên
            </a>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-success">
                <i class="fas fa-building me-2"></i>
                Quản lý Khoa
            </a>
            <a href="{{ route('admin.degrees.index') }}" class="btn btn-info">
                <i class="fas fa-certificate me-2"></i>
                Quản lý Bằng cấp
            </a>
        </div>
    </div>
</div>
@endsection
