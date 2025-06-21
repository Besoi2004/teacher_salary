@extends('layouts.admin')

@section('title', 'Báo cáo Lương Giảng dạy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>
                        Báo cáo Lương Giảng dạy
                    </h5>
                    <div>
                        <button onclick="window.print()" class="btn btn-secondary btn-sm me-2">
                            <i class="fas fa-print me-1"></i>
                            In báo cáo
                        </button>
                        <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($assignments->count() > 0)
                        @php
                            $totalSalary = 0;
                        @endphp
                        
                        @foreach($assignments as $teacherId => $teacherAssignments)
                            @php
                                $teacher = $teacherAssignments->first()->teacher;
                                $teacherTotalSalary = $teacherAssignments->sum(function($assignment) {
                                    return $assignment->calculateSalary();
                                });
                                $totalSalary += $teacherTotalSalary;
                            @endphp
                            
                            <div class="teacher-section mb-4 border rounded p-3">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <h6 class="mb-1">
                                            <i class="fas fa-user me-2"></i>
                                            {{ $teacher->full_name }}
                                        </h6>
                                        <div class="text-muted small">
                                            Mã GV: {{ $teacher->teacher_id }} | 
                                            Khoa: {{ $teacher->department->ten_day_du }} | 
                                            Trình độ: {{ $teacher->degree->ten_trinh_do }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="h5 mb-0 text-success">
                                            {{ number_format($teacherTotalSalary, 0, ',', '.') }}đ
                                        </div>
                                        <small class="text-muted">Tổng lương</small>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Lớp học phần</th>
                                                <th>Môn học</th>
                                                <th>Học kỳ</th>
                                                <th>Vai trò</th>
                                                <th>Giờ LT</th>
                                                <th>Giờ TH</th>
                                                <th>Tổng giờ</th>
                                                <th>Đơn giá</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($teacherAssignments as $assignment)
                                                <tr>
                                                    <td>{{ $assignment->classSubject->class_code }}</td>
                                                    <td>{{ $assignment->classSubject->subject->subject_name }}</td>
                                                    <td>
                                                        <small>{{ $assignment->classSubject->semester->semester_name }}</small>
                                                    </td>
                                                    <td>
                                                        @if($assignment->role === 'primary')
                                                            <span class="badge bg-success">Chính</span>
                                                        @else
                                                            <span class="badge bg-warning">Phụ</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $assignment->theory_hours_assigned }}</td>
                                                    <td class="text-center">{{ $assignment->practice_hours_assigned }}</td>
                                                    <td class="text-center">
                                                        <strong>{{ $assignment->theory_hours_assigned + $assignment->practice_hours_assigned }}</strong>
                                                    </td>
                                                    <td class="text-end">{{ number_format($assignment->hourly_rate, 0, ',', '.') }}đ</td>
                                                    <td class="text-end">
                                                        <strong>{{ number_format($assignment->calculateSalary(), 0, ',', '.') }}đ</strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-secondary">
                                            <tr>
                                                <td colspan="6" class="text-end"><strong>Tổng cộng:</strong></td>
                                                <td class="text-center">
                                                    <strong>{{ $teacherAssignments->sum(function($a) { return $a->theory_hours_assigned + $a->practice_hours_assigned; }) }}</strong>
                                                </td>
                                                <td></td>
                                                <td class="text-end">
                                                    <strong class="text-success">{{ number_format($teacherTotalSalary, 0, ',', '.') }}đ</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Summary Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-3">
                                                <div class="h4 mb-0">{{ $assignments->count() }}</div>
                                                <small>Giáo viên</small>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="h4 mb-0">{{ $assignments->flatten()->count() }}</div>
                                                <small>Phân công</small>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="h4 mb-0">
                                                    {{ $assignments->flatten()->sum(function($a) { return $a->theory_hours_assigned + $a->practice_hours_assigned; }) }}
                                                </div>
                                                <small>Tổng giờ</small>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="h4 mb-0">{{ number_format($totalSalary, 0, ',', '.') }}đ</div>
                                                <small>Tổng lương</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistics by Department -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">
                                            <i class="fas fa-chart-pie me-2"></i>
                                            Thống kê theo Khoa
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $departmentStats = $assignments->flatten()->groupBy(function($assignment) {
                                                return $assignment->teacher->department->ten_day_du;
                                            });
                                        @endphp
                                        
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Khoa</th>
                                                        <th>Số giáo viên</th>
                                                        <th>Số phân công</th>
                                                        <th>Tổng giờ</th>
                                                        <th>Tổng lương</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($departmentStats as $departmentName => $deptAssignments)
                                                        <tr>
                                                            <td>{{ $departmentName }}</td>
                                                            <td>{{ $deptAssignments->pluck('teacher_id')->unique()->count() }}</td>
                                                            <td>{{ $deptAssignments->count() }}</td>
                                                            <td>{{ $deptAssignments->sum(function($a) { return $a->theory_hours_assigned + $a->practice_hours_assigned; }) }}</td>
                                                            <td class="text-success">
                                                                {{ number_format($deptAssignments->sum(function($a) { return $a->calculateSalary(); }), 0, ',', '.') }}đ
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có dữ liệu phân công giảng dạy</h5>
                            <p class="text-muted">Vui lòng tạo phân công giảng dạy để xem báo cáo lương.</p>
                            <a href="{{ route('admin.teaching-assignments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>
                                Thêm Phân công
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card-header .btn,
    .sidebar,
    .navbar {
        display: none !important;
    }
    
    .container-fluid {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .teacher-section {
        page-break-inside: avoid;
        border: 1px solid #000 !important;
    }
}
</style>
@endsection
