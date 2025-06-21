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
                    </form>

                    @if(request()->filled('report_type') && (request()->filled('semester_id') || request()->filled('year')))
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title">0</h4>
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
                                                <h4 class="card-title">0</h4>
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
                                                <h4 class="card-title">0</h4>
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
                                                <h4 class="card-title">0 VND</h4>
                                                <p class="card-text">Tổng tiền dạy</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-money-bill-wave fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Thông tin báo cáo:</strong> Đang phát triển - Tính năng này sẽ hiển thị báo cáo tổng hợp tiền dạy của tất cả giáo viên trong toàn trường.
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
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-code text-muted" style="font-size: 2rem;"></i>
                                            <p class="mt-2 text-muted">Tính năng đang được phát triển...</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="5" class="text-end">Tổng cộng:</th>
                                        <th>0 VND</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
