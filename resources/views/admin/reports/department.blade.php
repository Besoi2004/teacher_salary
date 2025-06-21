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
                                        {{ $department->ten_viet_tat }} - {{ $department->ten_day_du }}
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
                    </form>                    @if($reportData)
                        <div class="alert alert-success">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Báo cáo tiền dạy:</strong> 
                            {{ $reportData['department']->ten_day_du }} - {{ $reportData['semester']->ten_ki }} {{ $reportData['semester']->nam_hoc }}
                        </div>
                        
                        <!-- Thống kê tổng quan -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ $reportData['total_teachers'] }}</h3>
                                        <p>Số giáo viên dạy</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ $reportData['total_classes'] }}</h3>
                                        <p>Tổng số lớp</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ $reportData['total_hours'] }}</h3>
                                        <p>Tổng số tiết</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h3>{{ number_format($reportData['total_salary'], 0, ',', '.') }}</h3>
                                        <p>Tổng tiền (VND)</p>
                                    </div>
                                </div>
                            </div>
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
                                    @foreach($reportData['teachers'] as $index => $teacherData)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $teacherData['teacher']->ma_so }}</td>
                                            <td>
                                                <strong>{{ $teacherData['teacher']->ho_ten }}</strong>
                                            </td>
                                            <td>
                                                @if($teacherData['teacher']->degree)
                                                    <span class="badge bg-info">{{ $teacherData['teacher']->degree->ten_viet_tat }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $teacherData['classes_count'] }} lớp</span>
                                            </td>
                                            <td>{{ $teacherData['total_hours'] }} tiết</td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    {{ number_format($teacherData['total_salary'], 0, ',', '.') }} VND
                                                </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#teacherModal{{ $index }}">
                                                    <i class="fas fa-eye me-1"></i>Chi tiết
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Tổng cộng:</th>
                                        <th>{{ $reportData['total_classes'] }} lớp</th>
                                        <th>{{ $reportData['total_hours'] }} tiết</th>
                                        <th class="text-success fw-bold">{{ number_format($reportData['total_salary'], 0, ',', '.') }} VND</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <!-- Modal chi tiết cho từng giáo viên -->
                        @foreach($reportData['teachers'] as $index => $teacherData)
                            <div class="modal fade" id="teacherModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Chi tiết: {{ $teacherData['teacher']->ho_ten }} - {{ $reportData['semester']->ten_ki }} {{ $reportData['semester']->nam_hoc }}
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
                                                        @foreach($teacherData['details'] as $detail)
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
