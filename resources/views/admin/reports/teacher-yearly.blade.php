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
                    </form>                    @if($reportData)
                        <div class="alert alert-success">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Báo cáo tiền dạy:</strong> 
                            {{ $reportData['teacher']->ho_ten }} - {{ $reportData['year'] }}
                            ({{ $reportData['teacher']->department->ten_viet_tat ?? 'N/A' }})
                        </div>
                        
                        <!-- Thống kê tổng quan -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ count($reportData['semesters']) }}</h3>
                                        <p>Số học kỳ dạy</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ array_sum(array_column($reportData['semesters'], 'classes_count')) }}</h3>
                                        <p>Tổng số lớp</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ array_sum(array_column($reportData['semesters'], 'total_hours')) }}</h3>
                                        <p>Tổng số tiết</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ number_format($reportData['total_year'], 0, ',', '.') }}</h3>
                                        <p>Tổng tiền (VND)</p>
                                    </div>
                                </div>
                            </div>
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
                                    @foreach($reportData['semesters'] as $semesterData)
                                        <tr>
                                            <td>
                                                <strong>{{ $semesterData['semester']->ten_ki }} {{ $semesterData['semester']->nam_hoc }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $semesterData['classes_count'] }} lớp</span>
                                            </td>
                                            <td>{{ $semesterData['total_hours'] }} tiết</td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    {{ number_format($semesterData['total_salary'], 0, ',', '.') }} VND
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#detailModal{{ $loop->index }}">
                                                    <i class="fas fa-eye me-1"></i>Chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th>Tổng năm {{ $reportData['year'] }}</th>
                                        <th>{{ array_sum(array_column($reportData['semesters'], 'classes_count')) }} lớp</th>
                                        <th>{{ array_sum(array_column($reportData['semesters'], 'total_hours')) }} tiết</th>
                                        <th class="text-success fw-bold">{{ number_format($reportData['total_year'], 0, ',', '.') }} VND</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Modal chi tiết cho từng học kỳ -->
                        @foreach($reportData['semesters'] as $index => $semesterData)
                            <div class="modal fade" id="detailModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Chi tiết {{ $semesterData['semester']->ten_ki }} {{ $semesterData['semester']->nam_hoc }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Mã lớp</th>
                                                            <th>Tên lớp</th>
                                                            <th>Học phần</th>
                                                            <th>Số tiết</th>
                                                            <th>SV</th>
                                                            <th>Hệ số HP</th>
                                                            <th>Hệ số lớp</th>
                                                            <th>Tiết quy đổi</th>
                                                            <th>Tiền dạy</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($semesterData['details'] as $detail)
                                                            <tr>
                                                                <td>{{ $detail['ma_lop'] }}</td>
                                                                <td>{{ $detail['ten_lop'] }}</td>
                                                                <td>{{ $detail['ten_hoc_phan'] }}</td>
                                                                <td>{{ $detail['so_tiet'] }}</td>
                                                                <td>{{ $detail['so_sinh_vien'] }}</td>
                                                                <td>{{ $detail['he_so_hoc_phan'] }}</td>
                                                                <td>{{ $detail['he_so_lop'] }}</td>
                                                                <td>{{ $detail['tiet_quy_doi'] }}</td>
                                                                <td>{{ number_format($detail['tien_day'], 0, ',', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
