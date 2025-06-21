@extends('layouts.admin')

@section('title', 'Trang chủ - Hệ thống quản lý giáo viên')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>
            Tổng quan hệ thống
        </h2>
    </div>
</div>

<!-- Teacher Management Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Tổng số Giáo viên</h5>
                        <h2 class="mb-0">{{ $stats['total_teachers'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tie fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.teachers.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Tổng số Khoa</h5>
                        <h2 class="mb-0">{{ $stats['total_departments'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-building fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.departments.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Tổng số Bằng cấp</h5>
                        <h2 class="mb-0">{{ $stats['total_degrees'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-certificate fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.degrees.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Class Subject Management Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Tổng Môn học</h5>
                        <h2 class="mb-0">{{ $stats['total_subjects'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.subjects.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Tổng Học kỳ</h5>
                        <h2 class="mb-0">{{ $stats['total_semesters'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.semesters.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Lớp học phần</h5>
                        <h2 class="mb-0">{{ $stats['total_class_subjects'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.class-subjects.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Phân công GD</h5>
                        <h2 class="mb-0">{{ $stats['total_assignments'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users-cog fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.teaching-assignments.index') }}" class="text-white text-decoration-none">
                    Xem chi tiết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Chức năng chính
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary w-100 py-3">
                            <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                            Thêm Giáo viên
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.departments.create') }}" class="btn btn-success w-100 py-3">
                            <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                            Thêm Khoa
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.degrees.create') }}" class="btn btn-info w-100 py-3">
                            <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                            Thêm Bằng cấp
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.statistics') }}" class="btn btn-warning w-100 py-3">
                            <i class="fas fa-chart-bar fa-2x d-block mb-2"></i>
                            Xem Thống kê
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Thao tác nhanh
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Teacher Management Quick Actions -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-users me-2"></i>
                            Quản lý Giáo viên
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.teachers.create') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-plus me-2"></i>
                                    Thêm Giáo viên
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.departments.create') }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-building me-2"></i>
                                    Thêm Khoa
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.degrees.create') }}" class="btn btn-outline-info w-100">
                                    <i class="fas fa-certificate me-2"></i>
                                    Thêm Bằng cấp
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.statistics') }}" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Thống kê
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Class Subject Management Quick Actions -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-danger mb-3">
                            <i class="fas fa-chalkboard-teacher me-2"></i>
                            Quản lý Lớp học phần
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.subjects.create') }}" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-book me-2"></i>
                                    Thêm Môn học
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.semesters.create') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-calendar-plus me-2"></i>
                                    Thêm Học kỳ
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.class-subjects.create') }}" class="btn btn-outline-dark w-100">
                                    <i class="fas fa-chalkboard me-2"></i>
                                    Thêm Lớp HP
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('admin.teaching-assignments.create') }}" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Phân công GD
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
