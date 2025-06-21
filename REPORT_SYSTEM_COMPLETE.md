# BÁTO CÁO HỆ THỐNG TÍNH TIỀN DẠY - LOGIC HOÀN CHỈNH

## Tổng quan
Đã xây dựng hoàn chỉnh logic báo cáo dựa trên công thức tính lương hiện tại:
**Tiền dạy = Số tiết quy đổi × Hệ số giáo viên × Tiền dạy một tiết**

Trong đó:
- **Số tiết quy đổi = Số tiết thực tế × (Hệ số học phần + Hệ số lớp)**
- **Hệ số lớp** được xác định dựa trên số sinh viên trong lớp
- **Hệ số giáo viên** được xác định dựa trên bằng cấp

## 1. BÁO CÁO TIỀN DẠY GIÁO VIÊN TRONG 1 NĂM

### Chức năng:
- Chọn giáo viên và năm học
- Hiển thị báo cáo theo từng học kỳ trong năm
- Tổng hợp toàn năm

### Logic:
- `teacherYearlyReport()`: Controller method chính
- `calculateTeacherSemesterSalary()`: Helper tính lương theo học kỳ
- Lặp qua tất cả học kỳ trong năm được chọn
- Tính tổng tiền dạy cho cả năm

### Hiển thị:
- **Cards thống kê:** Số học kỳ, tổng lớp, tổng tiết, tổng tiền
- **Bảng chính:** Danh sách học kỳ với thống kê
- **Modal chi tiết:** Chi tiết từng lớp trong học kỳ (bảng đầy đủ các hệ số)

## 2. BÁO CÁO TIỀN DẠY GIÁO VIÊN 1 KHOA

### Chức năng:
- Chọn khoa và học kỳ
- Hiển thị tất cả giáo viên trong khoa có dạy trong học kỳ đó
- Tổng hợp theo khoa

### Logic:
- `departmentReport()`: Controller method chính
- Lấy tất cả giáo viên trong khoa được chọn
- Tính lương từng giáo viên trong học kỳ
- Tổng hợp theo khoa

### Hiển thị:
- **Cards thống kê:** Tổng GV, tổng lớp, tổng tiết, tổng tiền của khoa
- **Bảng chính:** Danh sách giáo viên với mã, tên, bằng cấp, thống kê
- **Modal chi tiết:** Chi tiết từng lớp của giáo viên

## 3. BÁO CÁO TIỀN DẠY GIÁO VIÊN TOÀN TRƯỜNG

### Chức năng:
- Hai loại báo cáo: Theo học kỳ / Theo năm học
- Hiển thị thống kê theo từng khoa
- Tổng hợp toàn trường

### Logic:
- `schoolWideReport()`: Controller method chính
- `generateSchoolSemesterReport()`: Báo cáo theo học kỳ
- `generateSchoolYearlyReport()`: Báo cáo theo năm học
- Lặp qua tất cả khoa, tính tổng từng khoa
- Tổng hợp toàn trường

### Hiển thị:
- **Cards thống kê:** Tổng GV, tổng lớp, tổng tiết, tổng tiền toàn trường
- **Bảng chính:** Danh sách khoa với thống kê
- **Liên kết chi tiết:** Link đến báo cáo chi tiết từng khoa
- **Báo cáo năm:** Hiển thị thêm các học kỳ trong năm

## TÍNH NĂNG NÂNG CAO

### 1. Modal chi tiết đầy đủ:
- **Bảng chi tiết lớp:** Mã lớp, tên lớp, học phần, số tiết, số SV
- **Các hệ số:** Hệ số học phần, hệ số lớp, hệ số giáo viên
- **Tính toán:** Tiết quy đổi, tiền dạy từng lớp
- **Format tiền:** Định dạng VND với dấu phẩy

### 2. Liên kết giữa các báo cáo:
- Từ báo cáo toàn trường → báo cáo khoa
- Từ báo cáo khoa → có thể mở rộng đến báo cáo cá nhân
- Tự động điền tham số cho báo cáo con

### 3. Xử lý dữ liệu thông minh:
- **Kiểm tra hệ số:** Tự động dùng hệ số mặc định nếu không tìm thấy
- **Lọc dữ liệu:** Chỉ hiển thị giáo viên/khoa có dạy học
- **Tổng hợp chính xác:** Đảm bảo không trùng lặp khi tính theo năm

## CÔNG THỨC TÍNH TOÁN

### Công thức cơ bản:
```
Tiền dạy một lớp = Số tiết quy đổi × Hệ số GV × Tiền một tiết

Số tiết quy đổi = Số tiết thực tế × (Hệ số học phần + Hệ số lớp)
```

### Lấy hệ số:
- **Hệ số GV:** Từ bảng `teacher_coefficients` theo `ten_bang_cap`
- **Hệ số lớp:** Từ bảng `class_coefficients` theo số sinh viên
- **Tiền một tiết:** Từ bảng `payment_rates` (mức đang hoạt động)

### Xử lý ngoại lệ:
- Không tìm thấy hệ số lớp → dùng hệ số 1.0
- Không tìm thấy hệ số GV → báo lỗi, không tính
- Không tìm thấy tiền một tiết → báo lỗi, không tính

## FILE LIÊN QUAN

### Controller:
- `SalaryCalculationController.php`
  - `teacherYearlyReport()`
  - `departmentReport()`
  - `schoolWideReport()`
  - `calculateTeacherSemesterSalary()` (helper)
  - `generateSchoolSemesterReport()` (helper)
  - `generateSchoolYearlyReport()` (helper)

### Views:
- `admin/reports/teacher-yearly.blade.php`
- `admin/reports/department.blade.php` 
- `admin/reports/school-wide.blade.php`

### Routes:
- `admin/reports/teacher-yearly`
- `admin/reports/department`
- `admin/reports/school-wide`

## TRẠNG THÁI HOÀN THÀNH
✅ **Logic tính toán:** Hoàn chỉnh, dựa trên công thức chuẩn
✅ **Báo cáo giáo viên 1 năm:** Hoàn chỉnh với modal chi tiết
✅ **Báo cáo khoa:** Hoàn chỉnh với modal chi tiết từng GV
✅ **Báo cáo toàn trường:** Hoàn chỉnh theo học kỳ và năm học
✅ **Giao diện:** Bootstrap 5, responsive, modal chi tiết
✅ **Liên kết báo cáo:** Chuyển đổi linh hoạt giữa các báo cáo
✅ **Xử lý lỗi:** An toàn với các trường hợp không có dữ liệu

Hệ thống báo cáo đã hoàn thiện và sẵn sàng sử dụng!
