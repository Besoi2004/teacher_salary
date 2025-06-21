@extends('layouts.admin')

@section('title', 'Quản lý Lớp học phần')
@section('page-title', 'Quản lý Lớp học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-chalkboard-teacher me-2"></i>
                Danh sách Lớp học phần
            </h2>
            <a href="{{ route('admin.class-subjects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Thêm lớp học phần
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-search me-2"></i>
                    Tìm kiếm & Lọc
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.class-subjects.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="search" class="form-label">
                                    <i class="fas fa-search me-1"></i>
                                    Tìm kiếm
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Nhập tên lớp hoặc mã lớp...">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="semester_id" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Học kỳ
                                </label>
                                <select class="form-select" id="semester_id" name="semester_id">
                                    <option value="">Tất cả học kỳ</option>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->ten_ki }} - {{ $semester->nam_hoc }}
                                            @if($semester->is_active)
                                                (Đang hoạt động)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="subject_id" class="form-label">
                                    <i class="fas fa-book me-1"></i>
                                    Học phần
                                </label>
                                <select class="form-select" id="subject_id" name="subject_id">
                                    <option value="">Tất cả học phần</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->ma_so }} - {{ $subject->ten_hoc_phan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Tìm kiếm
                            </button>
                            <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>
                                Làm mới
                            </a>
                        </div>
                        
                        @if(request()->hasAny(['search', 'semester_id', 'subject_id']))
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-filter me-1"></i>
                                    Đang lọc - Tìm thấy {{ $classSubjects->count() }} kết quả
                                </small>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Danh sách Lớp học phần
                    <span class="badge bg-secondary ms-2">{{ $classSubjects->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                @if($classSubjects->count() > 0)
                    <div class="table-responsive">                        <table class="table table-striped table-hover">                            <thead class="table-dark">
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i>Mã lớp</th>
                                    <th><i class="fas fa-chalkboard me-1"></i>Tên lớp</th>
                                    <th><i class="fas fa-book me-1"></i>Học phần</th>
                                    <th><i class="fas fa-calendar me-1"></i>Học kỳ</th>
                                    <th class="text-center"><i class="fas fa-cogs me-1"></i>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classSubjects as $classSubject)                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $classSubject->ma_lop }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $classSubject->ten_lop }}</strong>
                                        @if($classSubject->ghi_chu)
                                            <br><small class="text-muted">{{ Str::limit($classSubject->ghi_chu, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge bg-info">{{ $classSubject->subject->ma_so }}</span>
                                            <br><small>{{ $classSubject->subject->ten_hoc_phan }}</small>
                                        </div>
                                    </td><td>
                                        <span class="badge bg-warning text-dark">
                                            {{ $classSubject->semester->ten_ki }} {{ $classSubject->semester->nam_hoc }}
                                        </span>
                                        @if($classSubject->semester->is_active)
                                            <br><small class="text-success"><i class="fas fa-circle me-1"></i>Đang hoạt động</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.class-subjects.show', $classSubject) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.class-subjects.edit', $classSubject) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.class-subjects.destroy', $classSubject) }}" 
                                                  method="POST" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa lớp học phần này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có lớp học phần nào</h5>
                        <p class="text-muted">Bấm nút "Thêm lớp học phần" để tạo lớp học phần đầu tiên.</p>
                        <a href="{{ route('admin.class-subjects.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Thêm lớp học phần đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Auto submit form when dropdown changes
    const semesterSelect = document.getElementById('semester_id');
    const subjectSelect = document.getElementById('subject_id');
    const searchForm = document.querySelector('form[action*="class-subjects"]');
    
    if (semesterSelect) {
        semesterSelect.addEventListener('change', function() {
            searchForm.submit();
        });
    }
    
    if (subjectSelect) {
        subjectSelect.addEventListener('change', function() {
            searchForm.submit();
        });
    }
    
    // Search on Enter key
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });
    }
    
    // Clear search functionality
    const clearBtn = document.querySelector('.btn-outline-secondary');
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Clear all form inputs
            document.getElementById('search').value = '';
            document.getElementById('semester_id').value = '';
            document.getElementById('subject_id').value = '';
            // Submit form to show all results
            searchForm.submit();
        });
    }
});
</script>
@endsection
