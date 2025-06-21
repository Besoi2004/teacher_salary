@extends('layouts.admin')

@section('title', 'Phân công Giảng dạy')
@section('page-title', 'Phân công Giảng dạy')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-user-plus me-2"></i>
                Phân công Giảng dạy
            </h2>
            <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Quay lại
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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tab Navigation -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="assignmentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" 
                                id="single-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#single-assignment" 
                                type="button" 
                                role="tab">
                            <i class="fas fa-user me-2"></i>
                            Phân công từng lớp
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" 
                                id="bulk-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#bulk-assignment" 
                                type="button" 
                                role="tab">
                            <i class="fas fa-users me-2"></i>
                            Phân công hàng loạt
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="assignmentTabsContent">
                    <!-- Tab 1: Phân công từng lớp -->
                    <div class="tab-pane fade show active" id="single-assignment" role="tabpanel">
                        <form action="{{ route('admin.teaching-assignments.store') }}" method="POST" id="singleAssignmentForm">
                            @csrf
                            <input type="hidden" name="assignment_type" value="single">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="semester_id" class="form-label">
                                            <i class="fas fa-calendar me-1"></i>
                                            Học kỳ <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('semester_id') is-invalid @enderror" 
                                                id="semester_id" 
                                                name="semester_id" 
                                                required>
                                            <option value="">Chọn học kỳ</option>
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->ten_ki }} - {{ $semester->nam_hoc }}
                                                    @if($semester->is_active)
                                                        (Đang hoạt động)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('semester_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="teacher_id" class="form-label">
                                            <i class="fas fa-chalkboard-teacher me-1"></i>
                                            Giảng viên <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                                id="teacher_id" 
                                                name="teacher_id" 
                                                required>
                                            <option value="">Chọn giảng viên</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->ho_ten }} ({{ $teacher->ma_so }}) - {{ $teacher->department->ten_viet_tat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">
                                            <i class="fas fa-book me-1"></i>
                                            Học phần <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('subject_id') is-invalid @enderror" 
                                                id="subject_id" 
                                                name="subject_id" 
                                                required>
                                            <option value="">Chọn học kỳ trước</option>
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Chọn học kỳ để xem các học phần có sẵn</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class_subject_id" class="form-label">
                                            <i class="fas fa-chalkboard me-1"></i>
                                            Lớp học phần <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('class_subject_id') is-invalid @enderror" 
                                                id="class_subject_id" 
                                                name="class_subject_id" 
                                                required>
                                            <option value="">Chọn học phần trước</option>
                                        </select>
                                        @error('class_subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Chọn học phần để xem các lớp có sẵn</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Info Display -->
                            <div class="row" id="classInfoSection" style="display: none;">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle me-2"></i>Thông tin lớp học phần:</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Mã lớp:</strong> <span id="classCode">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Tên lớp:</strong> <span id="className">-</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Sĩ số hiện tại:</strong> <span id="currentStudents">-</span> sinh viên
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="si_so_lop" class="form-label">
                                            <i class="fas fa-users me-1"></i>
                                            Sĩ số lớp <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control @error('si_so_lop') is-invalid @enderror" 
                                               id="si_so_lop" 
                                               name="si_so_lop" 
                                               value="{{ old('si_so_lop', 30) }}"
                                               min="1" 
                                               max="100"
                                               required>
                                        @error('si_so_lop')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Số sinh viên thực tế trong lớp</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ghi_chu" class="form-label">
                                            <i class="fas fa-sticky-note me-1"></i>
                                            Ghi chú
                                        </label>
                                        <textarea class="form-control @error('ghi_chu') is-invalid @enderror" 
                                                  id="ghi_chu" 
                                                  name="ghi_chu" 
                                                  rows="3"
                                                  placeholder="Ghi chú thêm về phân công này...">{{ old('ghi_chu') }}</textarea>
                                        @error('ghi_chu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Tạo phân công
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Tab 2: Phân công hàng loạt (placeholder) -->
                    <div class="tab-pane fade" id="bulk-assignment" role="tabpanel">
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Phân công hàng loạt</h5>
                            <p class="text-muted">Tính năng này sẽ được phát triển sau.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const semesterSelect = document.getElementById('semester_id');
    const subjectSelect = document.getElementById('subject_id');
    const classSubjectSelect = document.getElementById('class_subject_id');
    const classInfoSection = document.getElementById('classInfoSection');
    const siSoLopInput = document.getElementById('si_so_lop');

    console.log('Script loaded');
    
    // Load subjects when semester changes
    semesterSelect.addEventListener('change', function() {
        const semesterId = this.value;
        console.log('Semester changed to: ' + semesterId);
        
        // Reset dependent dropdowns
        classSubjectSelect.innerHTML = '<option value="">Chọn học phần trước</option>';
        classSubjectSelect.disabled = true;
        classInfoSection.style.display = 'none';
        
        if (semesterId) {
            const apiUrl = `/admin/api/subjects-by-semester/${semesterId}`;
            console.log('Calling API: ' + apiUrl);
            
            fetch(apiUrl)
                .then(response => {
                    console.log('Response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Data received: ' + data.length + ' subjects');
                    console.log(data);
                    
                    let options = '<option value="">Chọn học phần</option>';
                    data.forEach(subject => {
                        options += `<option value="${subject.id}">${subject.ma_so} - ${subject.ten_hoc_phan}</option>`;
                    });
                    subjectSelect.innerHTML = options;
                    subjectSelect.disabled = false;
                })
                .catch(error => {
                    console.log('Error: ' + error.message);
                    subjectSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                    subjectSelect.disabled = true;
                });
        } else {
            subjectSelect.innerHTML = '<option value="">Chọn học kỳ trước</option>';
            subjectSelect.disabled = true;
        }
    });
    
    // Load class subjects when subject changes
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        const semesterId = semesterSelect.value;
        
        console.log('Subject changed to: ' + subjectId);
        
        classInfoSection.style.display = 'none';
        
        if (subjectId && semesterId) {
            const apiUrl = `/admin/api/class-subjects-by-subject/${subjectId}?semester_id=${semesterId}`;
            console.log('Loading class subjects: ' + apiUrl);
            
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    console.log('Class subjects: ' + data.length);
                    
                    let options = '<option value="">Chọn lớp học phần</option>';
                    data.forEach(cls => {
                        options += `<option value="${cls.id}" data-code="${cls.ma_lop}" data-name="${cls.ten_lop}" data-students="${cls.si_so_lop}">${cls.ma_lop} - ${cls.ten_lop}</option>`;
                    });
                    classSubjectSelect.innerHTML = options;
                    classSubjectSelect.disabled = false;
                })
                .catch(error => {
                    console.log('Error loading classes: ' + error.message);
                    classSubjectSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                    classSubjectSelect.disabled = true;
                });
        } else {
            classSubjectSelect.innerHTML = '<option value="">Chọn học phần trước</option>';
            classSubjectSelect.disabled = true;
        }
    });

    // Show class info when class subject changes
    classSubjectSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        console.log('Class subject changed to: ' + this.value);
        
        if (this.value) {
            const classCode = selectedOption.dataset.code;
            const className = selectedOption.dataset.name;
            const currentStudents = selectedOption.dataset.students;
            
            console.log('Class info:', { classCode, className, currentStudents });
            
            document.getElementById('classCode').textContent = classCode;
            document.getElementById('className').textContent = className;
            document.getElementById('currentStudents').textContent = currentStudents;
            
            // Update si so lop input with current value
            siSoLopInput.value = currentStudents;
            
            classInfoSection.style.display = 'block';
        } else {
            classInfoSection.style.display = 'none';
        }
    });
});
</script>
@endsection
