@extends('layouts.admin')

@section('title', 'Thống kê Học kỳ')
@section('page-title', 'Thống kê Học kỳ')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-chart-bar me-2"></i>
                Thống kê Học kỳ
            </h2>
            <a href="{{ route('admin.semesters.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại danh sách
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $semesters->count() }}</h4>
                        <p class="mb-0">Tổng số học kỳ</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x"></i>
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
                        <h4>{{ $semesters->sum('class_subjects_count') }}</h4>
                        <p class="mb-0">Tổng lớp học phần</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $semesters->sum('total_assignments') }}</h4>
                        <p class="mb-0">Tổng phân công</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $semesters->where('is_active', true)->count() }}</h4>
                        <p class="mb-0">Học kỳ đang hoạt động</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-play-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Statistics Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Chi tiết thống kê theo học kỳ
                </h5>
            </div>
            <div class="card-body">
                @if($semesters->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th><i class="fas fa-calendar me-1"></i>Học kỳ</th>
                                    <th><i class="fas fa-clock me-1"></i>Thời gian</th>
                                    <th><i class="fas fa-toggle-on me-1"></i>Trạng thái</th>
                                    <th><i class="fas fa-chalkboard-teacher me-1"></i>Lớp học phần</th>
                                    <th><i class="fas fa-user-tie me-1"></i>Phân công giảng dạy</th>
                                    <th><i class="fas fa-chart-pie me-1"></i>Tỷ lệ phân công</th>
                                    <th class="text-center"><i class="fas fa-cogs me-1"></i>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semesters as $semester)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $semester->ten_ki }}</strong>
                                            <br><small class="text-muted">{{ $semester->nam_hoc }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fas fa-play text-success me-1"></i>{{ $semester->ngay_bat_dau ? $semester->ngay_bat_dau->format('d/m/Y') : 'N/A' }}
                                            <br>
                                            <i class="fas fa-stop text-danger me-1"></i>{{ $semester->ngay_ket_thuc ? $semester->ngay_ket_thuc->format('d/m/Y') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($semester->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Đang hoạt động
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-pause-circle me-1"></i>Không hoạt động
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $semester->class_subjects_count }}</span>
                                        lớp
                                    </td>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $semester->total_assignments ?? 0 }}</span>
                                        phân công
                                    </td>
                                    <td>
                                        @php
                                            $assignmentRate = $semester->class_subjects_count > 0 ? 
                                                round(($semester->total_assignments ?? 0) / $semester->class_subjects_count * 100, 1) : 0;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                {{ $assignmentRate >= 100 ? 'bg-success' : 
                                                   ($assignmentRate >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min($assignmentRate, 100) }}%"
                                                 aria-valuenow="{{ $assignmentRate }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ $assignmentRate }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.semesters.show', $semester) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.semesters.edit', $semester) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có dữ liệu học kỳ</h5>
                        <p class="text-muted">Hãy tạo học kỳ để xem thống kê.</p>
                        <a href="{{ route('admin.semesters.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Tạo học kỳ mới
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Số lượng lớp học phần theo học kỳ
                </h5>
            </div>
            <div class="card-body">
                <canvas id="classSubjectsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Tỷ lệ học kỳ hoạt động
                </h5>
            </div>
            <div class="card-body">
                <canvas id="activeStatusChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Class Subjects Chart
    const classSubjectsCtx = document.getElementById('classSubjectsChart').getContext('2d');
    const classSubjectsChart = new Chart(classSubjectsCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($semesters as $semester)
                    '{{ $semester->ten_ki }} {{ $semester->nam_hoc }}',
                @endforeach
            ],
            datasets: [{
                label: 'Số lớp học phần',
                data: [
                    @foreach($semesters as $semester)
                        {{ $semester->class_subjects_count }},
                    @endforeach
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Active Status Chart
    const activeStatusCtx = document.getElementById('activeStatusChart').getContext('2d');
    const activeCount = {{ $semesters->where('is_active', true)->count() }};
    const inactiveCount = {{ $semesters->where('is_active', false)->count() }};
    
    const activeStatusChart = new Chart(activeStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Đang hoạt động', 'Không hoạt động'],
            datasets: [{
                data: [activeCount, inactiveCount],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endsection
