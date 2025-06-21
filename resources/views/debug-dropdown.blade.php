@extends('layouts.admin')

@section('title', 'Debug Dropdown')
@section('page-title', 'Debug Dropdown')

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Debug Dropdown Test</h2>
        <p>So sánh với test-dropdown để tìm lỗi</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <label for="semester_id" class="form-label">Học kỳ</label>
        <select class="form-select" id="semester_id">
            <option value="">Chọn học kỳ</option>
            @foreach($semesters as $semester)
                <option value="{{ $semester->id }}">{{ $semester->ten_ki }} - {{ $semester->nam_hoc }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-4">
        <label for="subject_id" class="form-label">Học phần</label>
        <select class="form-select" id="subject_id">
            <option value="">Chọn học kỳ trước</option>
        </select>
    </div>
    
    <div class="col-md-4">
        <label for="class_subject_id" class="form-label">Lớp học phần</label>
        <select class="form-select" id="class_subject_id">
            <option value="">Chọn học phần trước</option>
        </select>
    </div>
</div>

<div class="mt-4" id="debug-info">
    <h3>Debug Info</h3>
    <pre id="debug-content"></pre>
</div>
@endsection

@section('scripts')
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
    
    log('Script loaded');
    
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
});
</script>
@endsection
