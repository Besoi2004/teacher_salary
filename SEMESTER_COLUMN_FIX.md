# Sửa lỗi "Column not found: semester_number"

## Mô tả lỗi
- Lỗi: `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'semester_number' in 'where clause'`
- Xuất hiện khi thao tác CRUD với bảng `semesters`
- SQL lỗi: `select exists(select * from semesters where semester_number = 1 and year = 2025)`

## Nguyên nhân
- **Mismatch giữa database schema và code**: Database sử dụng tên cột tiếng Việt nhưng controllers/views sử dụng tên tiếng Anh
- **Database schema**: `ten_ki`, `nam_hoc`, `ngay_bat_dau`, `ngay_ket_thuc`
- **Code đang sử dụng**: `semester_number`, `year`, `start_date`, `end_date`

## Chi tiết database schema (đúng)
```php
Schema::create('semesters', function (Blueprint $table) {
    $table->id();
    $table->string('ten_ki'); // Tên kì (HK1, HK2, HK3)
    $table->string('nam_hoc'); // Năm học (2024-2025)
    $table->date('ngay_bat_dau'); // Ngày bắt đầu
    $table->date('ngay_ket_thuc'); // Ngày kết thúc
    $table->boolean('is_active')->default(false);
    $table->text('ghi_chu')->nullable();
    $table->timestamps();
});
```

## Giải pháp đã thực hiện

### 1. Sửa SemesterController.php
#### Validation rules:
```php
// Trước (sai):
'semester_name' => 'required|string|max:255',
'semester_number' => 'required|integer|in:1,2,3',
'year' => 'required|integer|min:2020|max:2030',
'start_date' => 'required|date',
'end_date' => 'required|date|after:start_date',

// Sau (đúng):
'ten_ki' => 'required|string|max:255',
'nam_hoc' => 'required|string|max:20',
'ngay_bat_dau' => 'required|date',
'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
'ghi_chu' => 'nullable|string'
```

#### Duplicate checking:
```php
// Trước (sai):
$exists = Semester::where('semester_number', $request->semester_number)
                 ->where('year', $request->year)
                 ->exists();

// Sau (đúng):
$exists = Semester::where('ten_ki', $request->ten_ki)
                 ->where('nam_hoc', $request->nam_hoc)
                 ->exists();
```

### 2. Tạo lại views với field names đúng

#### create.blade.php - Form fields:
```html
<!-- Tên học kỳ -->
<input type="text" name="ten_ki" placeholder="Vd: Học kỳ 1, Học kỳ 2, Học kỳ hè">

<!-- Năm học -->
<input type="text" name="nam_hoc" placeholder="Vd: 2024-2025">

<!-- Ngày bắt đầu -->
<input type="date" name="ngay_bat_dau">

<!-- Ngày kết thúc -->
<input type="date" name="ngay_ket_thuc">

<!-- Checkbox kích hoạt -->
<input type="checkbox" name="is_active" value="1">

<!-- Ghi chú -->
<textarea name="ghi_chu"></textarea>
```

#### edit.blade.php - Hiển thị dữ liệu:
```html
value="{{ old('ten_ki', $semester->ten_ki) }}"
value="{{ old('nam_hoc', $semester->nam_hoc) }}"
value="{{ old('ngay_bat_dau', $semester->ngay_bat_dau?->format('Y-m-d')) }}"
{{ old('is_active', $semester->is_active) ? 'checked' : '' }}
```

#### index.blade.php - Hiển thị trong bảng:
```html
<!-- Tên học kỳ -->
{{ $semester->ten_ki }}

<!-- Năm học -->  
{{ $semester->nam_hoc }}

<!-- Ngày bắt đầu -->
{{ $semester->ngay_bat_dau ? $semester->ngay_bat_dau->format('d/m/Y') : 'N/A' }}

<!-- Trạng thái -->
@if($semester->is_active)
    <span class="badge bg-success">Đang hoạt động</span>
@endif
```

### 3. Mapping table cho reference
| Field cũ (sai) | Field mới (đúng) | Ý nghĩa |
|----------------|------------------|---------|
| `semester_name` | `ten_ki` | Tên học kỳ |
| `semester_number` | `ten_ki` | Số học kỳ (giờ là text) |
| `year` | `nam_hoc` | Năm học |
| `start_date` | `ngay_bat_dau` | Ngày bắt đầu |
| `end_date` | `ngay_ket_thuc` | Ngày kết thúc |
| N/A | `is_active` | Trạng thái kích hoạt |
| N/A | `ghi_chu` | Ghi chú |

## Kết quả
- ✅ CRUD operations hoạt động bình thường
- ✅ Validation chạy đúng với field names mới
- ✅ Không còn lỗi SQL "Column not found"
- ✅ UI/UX được cải thiện với checkbox kích hoạt và ghi chú
- ✅ Date formatting hoạt động đúng

## Files đã sửa
- `app/Http/Controllers/SemesterController.php` - Updated validation và queries
- `resources/views/admin/semesters/create.blade.php` - Rebuilt với field names đúng
- `resources/views/admin/semesters/edit.blade.php` - Rebuilt với field names đúng  
- `resources/views/admin/semesters/index.blade.php` - Updated hiển thị data

## Kinh nghiệm rút ra
- **Luôn đồng bộ** database schema với code
- **Sử dụng tên cột nhất quán** trong toàn bộ ứng dụng
- **Test CRUD operations** sau khi thay đổi schema
- **Backup views cũ** trước khi thay thế hoàn toàn
