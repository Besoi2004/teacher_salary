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

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Lỗi:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tab Navigation -->
<div class="row">
    <div class="col-lg-8">
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

                            <div class="row">                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">
                                            <i class="fas fa-book me-1"></i>
                                            Học phần <span class="text-danger">*</span>
                                        </label>                                        <select class="form-select @error('subject_id') is-invalid @enderror" 
                                                id="subject_id" 
                                                name="subject_id" 
                                                required>
                                            <option value="">Chọn học kỳ trước</option>
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                        <div class="form-text">Chọn học kỳ để xem các học phần có sẵn</div>
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
                                </div>                            </div>

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
                      <!-- Tab 2: Phân công hàng loạt -->
                    <div class="tab-pane fade" id="bulk-assignment" role="tabpanel">
                        <form action="{{ route('admin.teaching-assignments.store') }}" method="POST" id="bulkAssignmentForm">
                            @csrf
                            <input type="hidden" name="assignment_type" value="bulk">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bulk_semester_id" class="form-label">
                                            <i class="fas fa-calendar me-1"></i>
                                            Học kỳ <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('semester_id') is-invalid @enderror" 
                                                id="bulk_semester_id" 
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
                                        <label for="bulk_teacher_id" class="form-label">
                                            <i class="fas fa-chalkboard-teacher me-1"></i>
                                            Giảng viên <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                                id="bulk_teacher_id" 
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
                                        <label for="bulk_subject_id" class="form-label">
                                            <i class="fas fa-book me-1"></i>
                                            Học phần <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('subject_id') is-invalid @enderror" 
                                                id="bulk_subject_id" 
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
                                        <label for="bulk_si_so_lop" class="form-label">
                                            <i class="fas fa-users me-1"></i>
                                            Sĩ số lớp mặc định <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control @error('si_so_lop') is-invalid @enderror" 
                                               id="bulk_si_so_lop" 
                                               name="si_so_lop" 
                                               value="{{ old('si_so_lop', 30) }}"
                                               min="1" 
                                               max="100"
                                               required>
                                        @error('si_so_lop')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Sĩ số này sẽ áp dụng cho tất cả lớp được chọn</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-list me-1"></i>
                                            Chọn lớp học phần <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-text mb-2">Chọn học phần trước để xem danh sách lớp</div>                                        <div id="bulk_class_list" class="border rounded p-3" style="min-height: 100px; background-color: #f8f9fa;">
                                            <div class="text-muted text-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Vui lòng chọn học phần để hiển thị danh sách lớp
                                            </div>
                                        </div>                                        @error('class_subject_ids')
                                            <div class="alert alert-danger mt-2">
                                                <div class="d-flex align-items-start">
                                                    <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                                    <div>
                                                        <strong>Xung đột phân công:</strong>
                                                        <pre class="mb-0 mt-2" style="white-space: pre-line; font-size: 14px;">{{ $message }}</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="bulk_ghi_chu" class="form-label">
                                            <i class="fas fa-sticky-note me-1"></i>
                                            Ghi chú
                                        </label>
                                        <textarea class="form-control @error('ghi_chu') is-invalid @enderror" 
                                                  id="bulk_ghi_chu" 
                                                  name="ghi_chu" 
                                                  rows="3"
                                                  placeholder="Ghi chú chung cho tất cả phân công...">{{ old('ghi_chu') }}</textarea>
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
                                    Tạo phân công hàng loạt
                                </button>
                            </div>
                        </form>
                    </div>                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Panel - Assignment Status -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-list-alt me-2"></i>
                    Trạng thái lớp học phần
                </h6>
            </div>
            <div class="card-body">
                <div id="assignment-status-panel">
                    <div class="text-muted text-center py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">Chọn học kỳ và học phần để xem trạng thái phân công</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
/* Custom styles for assigned classes */
.form-check.border-warning {
    position: relative;
}

.form-check.border-warning::before {
    content: '';
    position: absolute;
    top: -1px;
    left: -1px;
    right: -1px;
    bottom: -1px;
    background: linear-gradient(45deg, #ffc107, #ffca2c);
    border-radius: 0.375rem;
    opacity: 0.1;
    z-index: -1;
}

.form-check input:disabled + label {
    opacity: 0.7;
    cursor: not-allowed;
}

.form-check input:disabled {
    cursor: not-allowed;
}

select option:disabled {
    color: #6c757d;
    background-color: #f8f9fa;
}

.text-warning {
    color: #b08800 !important;
}

.bg-warning.bg-opacity-10 {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

/* Assignment Status Panel Styles */
#assignment-status-panel .list-group-item {
    transition: all 0.2s ease;
}

#assignment-status-panel .list-group-item:hover {
    transform: translateX(2px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.bg-success.bg-opacity-10 {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.text-success {
    color: #198754 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.border-success {
    border-color: #198754 !important;
}

.border-warning {
    border-color: #ffc107 !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== SCRIPT STARTED ===');    const semesterSelect = document.getElementById('semester_id');
    const subjectSelect = document.getElementById('subject_id');
    const classSubjectSelect = document.getElementById('class_subject_id');
    const siSoLopInput = document.getElementById('si_so_lop');
    
    // Bulk assignment elements
    const bulkSemesterSelect = document.getElementById('bulk_semester_id');
    const bulkSubjectSelect = document.getElementById('bulk_subject_id');
    const bulkClassList = document.getElementById('bulk_class_list');    console.log('Elements:', {
        semesterSelect: !!semesterSelect,
        subjectSelect: !!subjectSelect,
        classSubjectSelect: !!classSubjectSelect,
        siSoLopInput: !!siSoLopInput,
        bulkSemesterSelect: !!bulkSemesterSelect,
        bulkSubjectSelect: !!bulkSubjectSelect,
        bulkClassList: !!bulkClassList
    });
    
    if (!semesterSelect || !subjectSelect || !classSubjectSelect) {
        console.error('Required elements not found!');
        return;
    }
    
    console.log('Script loaded successfully');// Load subjects when semester changes
    semesterSelect.addEventListener('change', function() {
        const semesterId = this.value;
        console.log('Semester changed to:', semesterId);          // Reset dependent dropdowns
        subjectSelect.innerHTML = '<option value="">Đang tải...</option>';
        subjectSelect.disabled = true;
        classSubjectSelect.innerHTML = '<option value="">Chọn học phần trước</option>';
        classSubjectSelect.disabled = true;
        
        // Clear assignment status panel
        clearAssignmentStatusPanel();

        if (semesterId) {
            const apiUrl = `/admin/api/subjects-by-semester/${semesterId}`;
            console.log('Calling API:', apiUrl);
            
            fetch(apiUrl)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data.length, 'subjects');
                    
                    let options = '<option value="">Chọn học phần</option>';
                    data.forEach(subject => {
                        options += `<option value="${subject.id}">${subject.ma_so} - ${subject.ten_hoc_phan}</option>`;
                    });
                    subjectSelect.innerHTML = options;
                    subjectSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    subjectSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                    subjectSelect.disabled = true;
                });        } else {
            subjectSelect.innerHTML = '<option value="">Chọn học kỳ trước</option>';
            subjectSelect.disabled = true;
            
            // Clear assignment status panel
            clearAssignmentStatusPanel();
        }
    });    // Load class subjects when subject changes
    subjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        const semesterId = semesterSelect.value;
        
        console.log('Subject changed to:', subjectId);
          classSubjectSelect.innerHTML = '<option value="">Đang tải...</option>';
        classSubjectSelect.disabled = true;
        
        if (subjectId && semesterId) {
            const apiUrl = `/admin/api/class-subjects-by-subject/${subjectId}?semester_id=${semesterId}`;
            console.log('Loading class subjects:', apiUrl);
              fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    console.log('Class subjects:', data.length, data);
                      let options = '<option value="">Chọn lớp học phần</option>';
                    data.forEach(cls => {
                        const isAssigned = cls.is_assigned;
                        const assignedTeacher = cls.assigned_teacher;
                        
                        // Tạo text cho option
                        let optionText = `${cls.ma_lop} - ${cls.ten_lop}`;
                        if (isAssigned) {
                            optionText += ` (Đã phân công: ${assignedTeacher.ho_ten})`;
                        }
                        
                        // Disable option nếu đã được phân công
                        const disabled = isAssigned ? 'disabled' : '';
                        
                        options += `<option value="${cls.id}" ${disabled}>${optionText}</option>`;
                    });
                    classSubjectSelect.innerHTML = options;
                    classSubjectSelect.disabled = false;
                    
                    // Update assignment status panel
                    updateAssignmentStatusPanel(data);
                })
                .catch(error => {
                    console.error('Error loading classes:', error);
                    classSubjectSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                    classSubjectSelect.disabled = true;
                    
                    // Clear assignment status panel
                    clearAssignmentStatusPanel();
                });        } else {
            classSubjectSelect.innerHTML = '<option value="">Chọn học phần trước</option>';
            classSubjectSelect.disabled = true;
            
            // Clear assignment status panel
            clearAssignmentStatusPanel();
        }
    });
    
    // === BULK ASSIGNMENT LOGIC ===
    
    // Load subjects for bulk assignment when semester changes
    bulkSemesterSelect.addEventListener('change', function() {
        const semesterId = this.value;
        console.log('Bulk semester changed to:', semesterId);
          // Reset dependent elements
        bulkSubjectSelect.innerHTML = '<option value="">Đang tải...</option>';
        bulkSubjectSelect.disabled = true;
        bulkClassList.innerHTML = '<div class="text-muted text-center"><i class="fas fa-info-circle me-2"></i>Vui lòng chọn học phần để hiển thị danh sách lớp</div>';
        
        // Clear assignment status panel
        clearAssignmentStatusPanel();

        if (semesterId) {
            const apiUrl = `/admin/api/subjects-by-semester/${semesterId}`;
            console.log('Calling bulk API:', apiUrl);
            
            fetch(apiUrl)
                .then(response => {
                    console.log('Bulk response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Bulk data received:', data.length, 'subjects');
                    
                    let options = '<option value="">Chọn học phần</option>';
                    data.forEach(subject => {
                        options += `<option value="${subject.id}">${subject.ma_so} - ${subject.ten_hoc_phan}</option>`;
                    });
                    bulkSubjectSelect.innerHTML = options;
                    bulkSubjectSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Bulk error:', error);
                    bulkSubjectSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                    bulkSubjectSelect.disabled = true;
                });        } else {
            bulkSubjectSelect.innerHTML = '<option value="">Chọn học kỳ trước</option>';
            bulkSubjectSelect.disabled = true;
            
            // Clear assignment status panel
            clearAssignmentStatusPanel();
        }
    });
      // Load class subjects for bulk assignment when subject changes
    bulkSubjectSelect.addEventListener('change', function() {
        const subjectId = this.value;
        const semesterId = bulkSemesterSelect.value;
        
        console.log('Bulk subject changed to:', subjectId);
        
        bulkClassList.innerHTML = '<div class="text-muted text-center"><i class="fas fa-spinner fa-spin me-2"></i>Đang tải danh sách lớp...</div>';
        
        if (subjectId && semesterId) {
            const apiUrl = `/admin/api/class-subjects-by-subject/${subjectId}?semester_id=${semesterId}`;
            console.log('Loading bulk class subjects:', apiUrl);
            
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    console.log('Bulk class subjects received:', data.length, data);
                    
                    if (data.length > 0) {
                        let html = '<div class="mb-2"><strong>Chọn các lớp học phần:</strong></div>';
                        html += '<div class="row">';
                          data.forEach((cls, index) => {
                            const isAssigned = cls.is_assigned;
                            const assignedTeacher = cls.assigned_teacher;
                            
                            // Tạo class CSS cho lớp đã được phân công
                            const cardClass = isAssigned ? 'border-warning bg-warning bg-opacity-10' : '';
                            const checkboxDisabled = isAssigned ? 'disabled' : '';
                            const labelClass = isAssigned ? 'text-muted' : '';
                            
                            html += `
                                <div class="col-md-4 mb-2">
                                    <div class="form-check border rounded p-2 ${cardClass}">
                                        <input class="form-check-input bulk-class-checkbox" 
                                               type="checkbox" 
                                               name="class_subject_ids[]" 
                                               value="${cls.id}" 
                                               id="class_${cls.id}" 
                                               ${checkboxDisabled}
                                               data-class-name="${cls.ma_lop}" 
                                               data-subject-name="${cls.ten_lop}">
                                        <label class="form-check-label ${labelClass}" for="class_${cls.id}">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <strong>${cls.ma_lop}</strong><br>
                                                    <small class="text-muted">${cls.ten_lop}</small>
                                                    ${isAssigned ? `
                                                        <br><small class="text-warning">
                                                            <i class="fas fa-user-check me-1"></i>
                                                            Đã phân công: ${assignedTeacher.ho_ten}
                                                        </small>
                                                    ` : ''}
                                                </div>
                                                ${isAssigned ? `
                                                    <div class="ms-2">
                                                        <i class="fas fa-lock text-warning" title="Đã được phân công"></i>
                                                    </div>
                                                ` : ''}
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            `;
                        });
                        
                        html += '</div>';
                        
                        // Đếm số lớp có thể chọn và đã được phân công
                        const availableClasses = data.filter(cls => !cls.is_assigned).length;
                        const assignedClasses = data.filter(cls => cls.is_assigned).length;
                        
                        html += '<div class="mt-3">';
                        html += `<div class="row mb-2">`;
                        html += `<div class="col-md-6">`;
                        html += `<small class="text-muted">Tổng: ${data.length} lớp | Có thể chọn: ${availableClasses} | Đã phân công: ${assignedClasses}</small>`;
                        html += `</div>`;
                        html += `</div>`;
                        
                        if (availableClasses > 0) {
                            html += '<button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="selectAllAvailableClasses()">Chọn tất cả lớp trống</button>';
                        }
                        html += '<button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="deselectAllClasses()">Bỏ chọn tất cả</button>';
                        html += '</div>';
                          bulkClassList.innerHTML = html;
                        
                        // Update assignment status panel for bulk tab
                        updateAssignmentStatusPanel(data);
                    } else {
                        bulkClassList.innerHTML = '<div class="text-muted text-center"><i class="fas fa-exclamation-circle me-2"></i>Không có lớp học phần nào</div>';
                    }                })
                .catch(error => {
                    console.error('Error loading bulk classes:', error);
                    bulkClassList.innerHTML = '<div class="text-danger text-center"><i class="fas fa-exclamation-triangle me-2"></i>Lỗi tải danh sách lớp</div>';
                    
                    // Clear assignment status panel
                    clearAssignmentStatusPanel();
                });        } else {            bulkClassList.innerHTML = '<div class="text-muted text-center"><i class="fas fa-info-circle me-2"></i>Vui lòng chọn học phần để hiển thị danh sách lớp</div>';
            
            // Clear assignment status panel
            clearAssignmentStatusPanel();
        }
    });
    
    // Validate bulk form before submit
    document.getElementById('bulkAssignmentForm').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('input[name="class_subject_ids[]"]:checked');
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một lớp học phần để phân công!');
            return false;
        }
        
        // Confirm bulk assignment
        const teacherSelect = document.getElementById('bulk_teacher_id');
        const teacherName = teacherSelect.options[teacherSelect.selectedIndex].text;
        const classCount = checkedBoxes.length;
        
        const confirmed = confirm(`Bạn có chắc chắn muốn phân công ${classCount} lớp học phần cho giảng viên ${teacherName}?`);
        
        if (!confirmed) {
            e.preventDefault();
            return false;
        }
    });
});

// Helper functions for bulk selection
function selectAllClasses() {
    // Chỉ chọn các checkbox không bị disabled
    const checkboxes = document.querySelectorAll('input[name="class_subject_ids[]"]:not(:disabled)');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function selectAllAvailableClasses() {
    // Chỉ chọn các checkbox không bị disabled (lớp chưa được phân công)
    const checkboxes = document.querySelectorAll('input[name="class_subject_ids[]"]:not(:disabled)');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function deselectAllClasses() {
    const checkboxes = document.querySelectorAll('input[name="class_subject_ids[]"]');
    checkboxes.forEach(checkbox => {
        if (!checkbox.disabled) {
            checkbox.checked = false;
        }
    });
}

function checkConflicts() {
    // Không cần nữa - các lớp đã được phân công sẽ không thể chọn
    console.log('Conflict checking disabled - assigned classes are already marked and disabled');
}

function checkConflictsAuto() {
    // Không cần nữa - các lớp đã được phân công sẽ không thể chọn
    console.log('Auto conflict checking disabled - assigned classes are already marked and disabled');
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Functions for assignment status panel
function updateAssignmentStatusPanel(classSubjects) {
    const panel = document.getElementById('assignment-status-panel');
    
    if (!classSubjects || classSubjects.length === 0) {
        clearAssignmentStatusPanel();
        return;
    }
    
    const assignedClasses = classSubjects.filter(cls => cls.is_assigned);
    const availableClasses = classSubjects.filter(cls => !cls.is_assigned);
    
    let html = `
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Tổng quan</h6>
                <small class="text-muted">${classSubjects.length} lớp</small>
            </div>
            <div class="row text-center">
                <div class="col-6">
                    <div class="bg-success bg-opacity-10 rounded p-2">
                        <div class="h5 mb-1 text-success">${availableClasses.length}</div>
                        <small class="text-success">Có thể phân công</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-warning bg-opacity-10 rounded p-2">
                        <div class="h5 mb-1 text-warning">${assignedClasses.length}</div>
                        <small class="text-warning">Đã phân công</small>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    if (availableClasses.length > 0) {
        html += `
            <div class="mb-3">
                <h6 class="text-success mb-2">
                    <i class="fas fa-circle-check me-1"></i>
                    Lớp chưa phân công (${availableClasses.length})
                </h6>
                <div class="list-group list-group-flush">
        `;
        
        availableClasses.forEach(cls => {
            html += `
                <div class="list-group-item list-group-item-action p-2 border-0 bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-success">${cls.ma_lop}</strong>
                            <br><small class="text-muted">${cls.ten_lop}</small>
                        </div>
                        <i class="fas fa-plus-circle text-success"></i>
                    </div>
                </div>
            `;
        });
        
        html += '</div></div>';
    }
    
    if (assignedClasses.length > 0) {
        html += `
            <div class="mb-3">
                <h6 class="text-warning mb-2">
                    <i class="fas fa-user-check me-1"></i>
                    Lớp đã phân công (${assignedClasses.length})
                </h6>
                <div class="list-group list-group-flush">
        `;
        
        assignedClasses.forEach(cls => {
            html += `
                <div class="list-group-item list-group-item-action p-2 border-0 bg-warning bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong class="text-warning">${cls.ma_lop}</strong>
                            <br><small class="text-muted">${cls.ten_lop}</small>
                            <br><small class="text-primary">
                                <i class="fas fa-user me-1"></i>
                                ${cls.assigned_teacher.ho_ten}
                            </small>
                        </div>
                        <i class="fas fa-lock text-warning"></i>
                    </div>
                </div>
            `;
        });
        
        html += '</div></div>';
    }
    
    panel.innerHTML = html;
}

function clearAssignmentStatusPanel() {
    const panel = document.getElementById('assignment-status-panel');
    panel.innerHTML = `
        <div class="text-muted text-center py-4">
            <i class="fas fa-info-circle fa-2x mb-2"></i>
            <p class="mb-0">Chọn học kỳ và học phần để xem trạng thái phân công</p>
        </div>
    `;
}
</script>
@endpush
