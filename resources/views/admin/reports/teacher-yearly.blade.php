@extends('layouts.admin')

@section('title', 'Báo cáo tiền dạy giáo viên trong 1 năm')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Báo cáo</li>
                        <li class="breadcrumb-item active">Báo cáo tiền dạy GV trong 1 năm</li>
                    </ol>
                </div>
                <h4 class="page-title">Báo cáo tiền dạy giáo viên trong 1 năm</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports.teacher-yearly') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="teacher_id" class="form-label">Chọn giáo viên</label>
                            <select name="teacher_id" id="teacher_id" class="form-select" required>
                                <option value="">-- Chọn giáo viên --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->ma_so }} - {{ $teacher->ho_ten }}
                                        @if($teacher->department)
                                            ({{ $teacher->department->ten_viet_tat }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="year" class="form-label">Chọn năm học</label>
                            <select name="year" id="year" class="form-select" required>
                                <option value="">-- Chọn năm học --</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->nam_hoc }}" {{ request('year') == $year->nam_hoc ? 'selected' : '' }}>
                                        {{ $year->nam_hoc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Xem báo cáo
                            </button>
                            <a href="{{ route('admin.reports.teacher-yearly') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh me-2"></i>Làm mới
                            </a>
                        </div>
                    </form>

                    @if(request()->filled('teacher_id') && request()->filled('year'))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Thông tin báo cáo:</strong> Đang phát triển - Tính năng này sẽ hiển thị báo cáo chi tiết tiền dạy của giáo viên trong cả năm học.
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Học kỳ</th>
                                        <th>Số lớp dạy</th>
                                        <th>Tổng số tiết</th>
                                        <th>Tổng tiền dạy</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-code text-muted" style="font-size: 2rem;"></i>
                                            <p class="mt-2 text-muted">Tính năng đang được phát triển...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">Báo cáo tiền dạy giáo viên trong 1 năm</h4>
                            <p class="text-muted">Vui lòng chọn giáo viên và năm học để xem báo cáo</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
