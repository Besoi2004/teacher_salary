@extends('layouts.admin')

@section('title', 'Báo cáo tiền dạy giáo viên 1 khoa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Báo cáo</li>
                        <li class="breadcrumb-item active">Báo cáo tiền dạy GV 1 khoa</li>
                    </ol>
                </div>
                <h4 class="page-title">Báo cáo tiền dạy giáo viên 1 khoa</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports.department') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="department_id" class="form-label">Chọn khoa</label>
                            <select name="department_id" id="department_id" class="form-select" required>
                                <option value="">-- Chọn khoa --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->ten_viet_tat }} - {{ $department->ten_khoa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="semester_id" class="form-label">Chọn học kỳ</label>
                            <select name="semester_id" id="semester_id" class="form-select" required>
                                <option value="">-- Chọn học kỳ --</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->ten_ki }} {{ $semester->nam_hoc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Xem báo cáo
                            </button>
                            <a href="{{ route('admin.reports.department') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh me-2"></i>Làm mới
                            </a>
                        </div>
                    </form>

                    @if(request()->filled('department_id') && request()->filled('semester_id'))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Thông tin báo cáo:</strong> Đang phát triển - Tính năng này sẽ hiển thị báo cáo tổng hợp tiền dạy của tất cả giáo viên trong khoa.
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã GV</th>
                                        <th>Họ tên</th>
                                        <th>Bằng cấp</th>
                                        <th>Số lớp dạy</th>
                                        <th>Tổng số tiết</th>
                                        <th>Tổng tiền dạy</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-code text-muted" style="font-size: 2rem;"></i>
                                            <p class="mt-2 text-muted">Tính năng đang được phát triển...</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="6" class="text-end">Tổng cộng:</th>
                                        <th>0 VND</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-building text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">Báo cáo tiền dạy giáo viên 1 khoa</h4>
                            <p class="text-muted">Vui lòng chọn khoa và học kỳ để xem báo cáo</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
