@extends('layouts.admin')

@section('title', 'Báo cáo tiền dạy giáo viên toàn trường')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Báo cáo</li>
                        <li class="breadcrumb-item active">Báo cáo tiền dạy GV toàn trường</li>
                    </ol>
                </div>
                <h4 class="page-title">Báo cáo tiền dạy giáo viên toàn trường</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports.school-wide') }}" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label">Loại báo cáo</label>
                            <select name="report_type" class="form-select" required>
                                <option value="">-- Chọn loại báo cáo --</option>
                                <option value="semester" {{ request('report_type') == 'semester' ? 'selected' : '' }}>Theo học kỳ</option>
                                <option value="yearly" {{ request('report_type') == 'yearly' ? 'selected' : '' }}>Theo năm học</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="semester-select" style="{{ request('report_type') == 'semester' ? '' : 'display: none;' }}">
                            <label for="semester_id" class="form-label">Chọn học kỳ</label>
                            <select name="semester_id" id="semester_id" class="form-select">
                                <option value="">-- Chọn học kỳ --</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->ten_ki }} {{ $semester->nam_hoc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3" id="year-select" style="{{ request('report_type') == 'yearly' ? '' : 'display: none;' }}">
                            <label for="year" class="form-label">Chọn năm học</label>
                            <select name="year" id="year" class="form-select">
                                <option value="">-- Chọn năm học --</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->nam_hoc }}" {{ request('year') == $year->nam_hoc ? 'selected' : '' }}>
                                        {{ $year->nam_hoc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Xem báo cáo
                            </button>
                            <a href="{{ route('admin.reports.school-wide') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh me-2"></i>Làm mới
                            </a>
                        </div>
                    </form>                    @if($reportData)
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title">{{ $reportData['summary']['total_teachers'] }}</h4>
                                                <p class="card-text">Tổng số giáo viên</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-users fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title">{{ $reportData['summary']['total_classes'] }}</h4>
                                                <p class="card-text">Tổng số lớp</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-chalkboard fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title">{{ $reportData['summary']['total_hours'] }}</h4>
                                                <p class="card-text">Tổng số tiết</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title">{{ number_format($reportData['summary']['total_salary'], 0, ',', '.') }}</h4>
                                                <p class="card-text">Tổng tiền dạy (VND)</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-money-bill-wave fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-success">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Báo cáo tiền dạy toàn trường:</strong> 
                            @if($reportData['type'] == 'semester')
                                {{ $reportData['semester']->ten_ki }} {{ $reportData['semester']->nam_hoc }}
                            @else
                                Năm học {{ $reportData['year'] }}
                            @endif
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-warning">
                                    <tr>
                                        <th>STT</th>
                                        <th>Khoa</th>
                                        <th>Số giáo viên</th>
                                        <th>Số lớp dạy</th>
                                        <th>Tổng số tiết</th>
                                        <th>Tổng tiền dạy</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportData['departments'] as $index => $deptData)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $deptData['department']->ten_day_du }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $deptData['department']->ten_viet_tat }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $deptData['teachers_count'] }} GV</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $deptData['classes_count'] }} lớp</span>
                                            </td>
                                            <td>{{ $deptData['total_hours'] }} tiết</td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    {{ number_format($deptData['total_salary'], 0, ',', '.') }} VND
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.reports.department') }}?department_id={{ $deptData['department']->id }}&semester_id={{ $reportData['type'] == 'semester' ? $reportData['semester']->id : '' }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Xem chi tiết khoa">
                                                    <i class="fas fa-eye me-1"></i>Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng cộng:</th>
                                        <th>{{ $reportData['summary']['total_hours'] }} tiết</th>
                                        <th class="text-success fw-bold">{{ number_format($reportData['summary']['total_salary'], 0, ',', '.') }} VND</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        @if($reportData['type'] == 'yearly')
                            <div class="mt-4">
                                <h5>Chi tiết theo học kỳ trong năm {{ $reportData['year'] }}:</h5>
                                <div class="row">
                                    @foreach($reportData['semesters'] as $semester)
                                        <div class="col-md-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $semester->ten_ki }} {{ $semester->nam_hoc }}</h6>
                                                    <p class="card-text">
                                                        <a href="{{ route('admin.reports.school-wide') }}?report_type=semester&semester_id={{ $semester->id }}" 
                                                           class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-chart-line me-1"></i>Xem báo cáo chi tiết
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-university text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3 text-muted">Báo cáo tiền dạy giáo viên toàn trường</h4>
                            <p class="text-muted">Vui lòng chọn loại báo cáo và thời gian để xem báo cáo</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportTypeSelect = document.querySelector('select[name="report_type"]');
    const semesterSelect = document.getElementById('semester-select');
    const yearSelect = document.getElementById('year-select');
    
    reportTypeSelect.addEventListener('change', function() {
        if (this.value === 'semester') {
            semesterSelect.style.display = 'block';
            yearSelect.style.display = 'none';
        } else if (this.value === 'yearly') {
            semesterSelect.style.display = 'none';
            yearSelect.style.display = 'block';
        } else {
            semesterSelect.style.display = 'none';
            yearSelect.style.display = 'none';
        }
    });
});
</script>
@endsection
