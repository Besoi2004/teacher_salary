# Sửa lỗi không chọn được học kỳ trong Class Subjects Create

## Mô tả lỗi
- Lỗi: Không thể chọn học kỳ trong form tạo lớp học phần
- URL: `http://127.0.0.1:8000/admin/class-subjects/create`
- Dropdown học kỳ không hiển thị dữ liệu

## Nguyên nhân
1. **Field name mismatch**: View sử dụng `$semester->semester_name` nhưng database có field `ten_ki`
2. **Database schema inconsistency**: Form sử dụng các field không tồn tại trong database
3. **Controller validation**: Validation rules không khớp với database schema

## Database Schema (đúng)
```php
Schema::create('class_subjects', function (Blueprint $table) {
    $table->id();
    $table->foreignId('semester_id')->constrained('semesters');
    $table->foreignId('subject_id')->constrained('subjects');
    $table->string('ma_lop')->unique(); // Mã lớp
    $table->string('ten_lop'); // Tên lớp
    $table->integer('so_sinh_vien')->default(0); // Số sinh viên
    $table->text('ghi_chu')->nullable(); // Ghi chú
    $table->timestamps();
});
```

## Giải pháp đã thực hiện

### 1. Sửa ClassSubjectController.php
#### Validation rules cũ (sai):
```php
'class_code' => 'required|string|max:20|unique:class_subjects',
'class_name' => 'required|string|max:255',
'credits' => 'required|integer|min:1|max:10',
'theory_hours' => 'required|integer|min:0',
'practice_hours' => 'required|integer|min:0',
'max_students' => 'required|integer|min:1|max:200',
```

#### Validation rules mới (đúng):
```php
'ma_lop' => 'required|string|max:20|unique:class_subjects',
'ten_lop' => 'required|string|max:255',
'subject_id' => 'required|exists:subjects,id',
'semester_id' => 'required|exists:semesters,id',
'so_sinh_vien' => 'required|integer|min:0|max:200',
'ghi_chu' => 'nullable|string'
```

### 2. Sửa Create View
#### Form fields cũ (sai):
```html
<input name="class_code" ...>
<input name="class_name" ...>
<input name="credits" ...>
<input name="theory_hours" ...>
<input name="practice_hours" ...>
<input name="max_students" ...>
```

#### Form fields mới (đúng):
```html
<input name="ma_lop" ...>
<input name="ten_lop" ...>
<input name="so_sinh_vien" ...>
<textarea name="ghi_chu" ...>
```

#### Dropdown semester cũ (sai):
```blade
@foreach($semesters as $semester)
    <option value="{{ $semester->id }}">
        {{ $semester->semester_name }}
    </option>
@endforeach
```

#### Dropdown semester mới (đúng):
```blade
@foreach($semesters as $semester)
    <option value="{{ $semester->id }}">
        {{ $semester->ten_ki }} - {{ $semester->nam_hoc }}
    </option>
@endforeach
```

#### Dropdown subject mới (đúng):
```blade
@foreach($subjects as $subject)
    <option value="{{ $subject->id }}">
        {{ $subject->ma_hoc_phan }} - {{ $subject->ten_hoc_phan }}
    </option>
@endforeach
```

### 3. Simplification
- **Loại bỏ** các field không tồn tại: `credits`, `theory_hours`, `practice_hours`, `max_students`
- **Thông tin này** lấy từ subject đã chọn
- **Đơn giản hóa** form chỉ gồm: mã lớp, tên lớp, số sinh viên hiện tại, ghi chú
- **Xóa JavaScript** tính toán phức tạp không cần thiết

### 4. Mapping table
| Field cũ (sai) | Field mới (đúng) | Lấy từ |
|----------------|------------------|--------|
| `class_code` | `ma_lop` | User input |
| `class_name` | `ten_lop` | User input |
| `credits` | N/A | subjects.so_tin_chi |
| `theory_hours` | N/A | subjects.so_tiet |
| `practice_hours` | N/A | subjects.so_tiet |
| `max_students` | `so_sinh_vien` | User input |
| N/A | `ghi_chu` | User input |

## Kết quả
- ✅ Dropdown học kỳ hiển thị đúng dữ liệu
- ✅ Dropdown môn học hiển thị đúng dữ liệu  
- ✅ Form validation hoạt động đúng
- ✅ CRUD operations hoạt động bình thường
- ✅ UI đơn giản, dễ sử dụng hơn

## Files đã sửa
- `app/Http/Controllers/ClassSubjectController.php` - Updated validation rules
- `resources/views/admin/class-subjects/create.blade.php` - Rebuilt form với đúng field names

## Kinh nghiệm rút ra
- **Luôn đối chiếu** form fields với database schema
- **Không tạo fields** không tồn tại trong database
- **Sử dụng relationships** để lấy dữ liệu liên quan thay vì duplicate
- **Đơn giản hóa** form để tăng UX
- **Test dropdown data** sau khi thay đổi field names
