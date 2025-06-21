# COLUMN NAME FIX - BÁTO CÁO HỆ THỐNG

## Lỗi gặp phải:
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'ten_khoa' in 'order clause' 
(Connection: mysql, SQL: select * from `departments` order by `ten_khoa` asc)
```

## Nguyên nhân:
Trong bảng `departments`, tên cột là `ten_day_du` (tên đầy đủ) chứ không phải `ten_khoa`.

## Cấu trúc bảng departments thực tế:
```sql
CREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten_day_du VARCHAR(255) NOT NULL,        -- Tên đầy đủ khoa
    ten_viet_tat VARCHAR(255) UNIQUE NOT NULL, -- Tên viết tắt
    mo_ta_nhiem_vu TEXT NULL,                -- Mô tả nhiệm vụ
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Các thay đổi đã thực hiện:

### 1. Controller: `SalaryCalculationController.php`
```php
// Cũ: Department::orderBy('ten_khoa')
// Mới: Department::orderBy('ten_day_du')
```

**Các vị trí đã sửa:**
- `departmentReport()` method (dòng ~168)
- `generateSchoolSemesterReport()` method (dòng ~357) 
- `generateSchoolYearlyReport()` method (dòng ~421)

### 2. View: `admin/reports/department.blade.php`
```blade
<!-- Cũ: {{ $department->ten_khoa }} -->
<!-- Mới: {{ $department->ten_day_du }} -->
```

**Các vị trí đã sửa:**
- Option text trong dropdown khoa (dòng ~33)
- Tiêu đề báo cáo (dòng ~62)

### 3. View: `admin/reports/school-wide.blade.php`
```blade
<!-- Cũ: {{ $deptData['department']->ten_khoa }} -->
<!-- Mới: {{ $deptData['department']->ten_day_du }} -->
```

**Vị trí đã sửa:**
- Hiển thị tên khoa trong bảng báo cáo (dòng ~158)

## Kết quả:
✅ **Lỗi Column not found đã được khắc phục**
✅ **Các báo cáo có thể truy cập được:**
- `/admin/reports/teacher-yearly`
- `/admin/reports/department` 
- `/admin/reports/school-wide`

✅ **Dữ liệu hiển thị chính xác:**
- Tên đầy đủ khoa: `ten_day_du`
- Tên viết tắt khoa: `ten_viet_tat`

## Lưu ý cho tương lai:
Khi làm việc với bảng `departments`, sử dụng:
- `ten_day_du`: Tên đầy đủ khoa (VD: "Khoa Công nghệ Thông tin")
- `ten_viet_tat`: Tên viết tắt khoa (VD: "CNTT")
- **KHÔNG có cột** `ten_khoa`

Hệ thống báo cáo giờ đây hoạt động bình thường!
