<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Teaching Assignment - Simple</h1>
        
        <form action="{{ route('admin.teaching-assignments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="assignment_type" value="single">
            
            <div class="row">
                <div class="col-md-4">
                    <label for="semester_id" class="form-label">Học kỳ</label>
                    <select class="form-select" id="semester_id" name="semester_id" required>
                        <option value="">Chọn học kỳ</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ $semester->ten_ki }} - {{ $semester->nam_hoc }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="subject_id" class="form-label">Học phần</label>
                    <select class="form-select" id="subject_id" name="subject_id" required>
                        <option value="">Chọn học kỳ trước</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="class_subject_id" class="form-label">Lớp học phần</label>
                    <select class="form-select" id="class_subject_id" name="class_subject_id" required>
                        <option value="">Chọn học phần trước</option>
                    </select>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="teacher_id" class="form-label">Giảng viên</label>
                    <select class="form-select" id="teacher_id" name="teacher_id" required>
                        <option value="">Chọn giảng viên</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->ho_ten }} ({{ $teacher->ma_so }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="si_so_lop" class="form-label">Sĩ số lớp</label>
                    <input type="number" class="form-control" id="si_so_lop" name="si_so_lop" value="30" min="1" max="100" required>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Tạo phân công</button>
                <a href="{{ route('admin.teaching-assignments.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
        
        <div class="mt-4" id="debug-info">
            <h3>Debug Info</h3>
            <pre id="debug-content"></pre>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const semesterSelect = document.getElementById('semester_id');
        const subjectSelect = document.getElementById('subject_id');
        const classSubjectSelect = document.getElementById('class_subject_id');
        const debugContent = document.getElementById('debug-content');
        
        function log(message) {
            console.log(message);
            debugContent.textContent += new Date().toLocaleTimeString() + ': ' + JSON.stringify(message) + '\n';
        }
        
        log('Create simple script loaded');
        
        semesterSelect.addEventListener('change', function() {
            const semesterId = this.value;
            log('Semester changed to: ' + semesterId);
            
            if (semesterId) {
                const apiUrl = `/admin/api/subjects-by-semester/${semesterId}`;
                log('Calling API: ' + apiUrl);
                
                fetch(apiUrl)
                    .then(response => {
                        log('Response status: ' + response.status);
                        return response.json();
                    })
                    .then(data => {
                        log('Data received: ' + data.length + ' subjects');
                        log(data);
                        
                        let options = '<option value="">Chọn học phần</option>';
                        data.forEach(subject => {
                            options += `<option value="${subject.id}">${subject.ma_so} - ${subject.ten_hoc_phan}</option>`;
                        });
                        subjectSelect.innerHTML = options;
                        subjectSelect.disabled = false;
                    })
                    .catch(error => {
                        log('Error: ' + error.message);
                    });
            } else {
                subjectSelect.innerHTML = '<option value="">Chọn học kỳ trước</option>';
                subjectSelect.disabled = true;
            }
        });
        
        subjectSelect.addEventListener('change', function() {
            const subjectId = this.value;
            const semesterId = semesterSelect.value;
            
            if (subjectId && semesterId) {
                const apiUrl = `/admin/api/class-subjects-by-subject/${subjectId}?semester_id=${semesterId}`;
                log('Loading class subjects: ' + apiUrl);
                
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        log('Class subjects: ' + data.length);
                        
                        let options = '<option value="">Chọn lớp học phần</option>';
                        data.forEach(cls => {
                            options += `<option value="${cls.id}">${cls.ma_lop} - ${cls.ten_lop}</option>`;
                        });
                        classSubjectSelect.innerHTML = options;
                        classSubjectSelect.disabled = false;
                    })
                    .catch(error => {
                        log('Error loading classes: ' + error.message);
                    });
            }
        });
    });
    </script>
</body>
</html>
