# Laravel Teacher Salary Management System

## Tổng quan dự án
Hệ thống quản lý tính lương giáo viên được xây dựng bằng Laravel với giao diện tiếng Việt và sidebar menu có thể thu gọn.

## Cấu trúc chức năng

### 1. Quản lý Giáo viên
- **Bằng cấp (Degrees)**: Quản lý trình độ học vấn
- **Khoa (Departments)**: Quản lý các khoa trong trường
- **Giáo viên (Teachers)**: Quản lý thông tin giáo viên
- **Thống kê**: Báo cáo thống kê giáo viên theo khoa và bằng cấp

### 2. Quản lý Lớp học phần
- **Môn học (Subjects)**: Quản lý danh sách môn học
- **Học kỳ (Semesters)**: Quản lý các học kỳ
- **Lớp học phần (Class Subjects)**: Quản lý lớp học cụ thể cho từng môn
- **Phân công Giảng dạy (Teaching Assignments)**: Phân công giáo viên cho lớp học phần
- **Báo cáo Lương**: Tính toán và hiển thị lương giảng dạy

## Tính năng đã hoàn thành

### Database & Models
✅ Tất cả migrations đã được tạo và chạy thành công
✅ Tất cả models với relationships hoàn chỉnh
✅ Seeders với dữ liệu mẫu

### Controllers
✅ AdminController - Dashboard và thống kê tổng quan
✅ DegreeController - CRUD bằng cấp
✅ DepartmentController - CRUD khoa
✅ TeacherController - CRUD giáo viên với tự động tạo mã GV
✅ SubjectController - CRUD môn học
✅ SemesterController - CRUD học kỳ với validation
✅ ClassSubjectController - CRUD lớp học phần với logic tính giờ
✅ TeachingAssignmentController - CRUD phân công với tính lương tự động

### Views & UI
✅ Layout admin với sidebar responsive
✅ Dashboard với thống kê tổng quan và quick actions
✅ Tất cả views cho Teacher Management (index, create, edit, show)
✅ Tất cả views cho Subjects (index, create, edit)
✅ Views cho Semesters (index, create, edit)
✅ Views cho Class Subjects (index, create)
✅ Views cho Teaching Assignments (index, create, salary-report)
✅ Giao diện Bootstrap 5 responsive
✅ Vietnamese language interface
✅ Form validation với error handling

### Business Logic
✅ Tự động tạo mã giáo viên (GV0001, GV0002...)
✅ Validation unique cho mã giáo viên, mã môn học, mã lớp
✅ Tính toán lương tự động (giờ × đơn giá)
✅ Validation tổng giờ học = tín chỉ × 15
✅ Kiểm tra phân công không vượt quá giờ lớp học phần
✅ Soft constraints cho việc xóa (không xóa nếu có dữ liệu liên quan)

### Routes & Navigation
✅ Tất cả routes với admin prefix
✅ Sidebar menu collapsible với 2 nhóm chức năng chính
✅ Breadcrumb navigation
✅ Quick action links trên dashboard

## Cấu trúc Database

### Teacher Management Tables:
- `degrees` - Bằng cấp
- `departments` - Khoa
- `teachers` - Giáo viên

### Class Subject Management Tables:
- `subjects` - Môn học
- `semesters` - Học kỳ
- `class_subjects` - Lớp học phần
- `teaching_assignments` - Phân công giảng dạy

## Tính năng nổi bật

### 1. Dashboard thông minh
- Hiển thị số liệu thống kê tổng quan
- Quick actions cho các chức năng chính
- Tổng lương giảng dạy được tính tự động

### 2. Quản lý giáo viên
- Tự động tạo mã giáo viên
- Liên kết với khoa và bằng cấp
- Validation đầy đủ

### 3. Quản lý lớp học phần
- Tính toán giờ học tự động
- Validation logic nghiệp vụ
- Phân công linh hoạt với nhiều vai trò

### 4. Tính lương tự động
- Tính lương theo giờ và đơn giá
- Báo cáo chi tiết theo giáo viên
- Thống kê theo khoa

### 5. Giao diện thân thiện
- Responsive design
- Vietnamese interface
- Bootstrap 5 modern UI
- Collapsible sidebar menu

## Cách sử dụng

1. **Khởi động server**: `php artisan serve`
2. **Truy cập**: http://127.0.0.1:8000
3. **Dashboard**: Xem tổng quan và sử dụng quick actions
4. **Quản lý Giáo viên**: Thêm khoa, bằng cấp, sau đó thêm giáo viên
5. **Quản lý Lớp học phần**: Thêm môn học, học kỳ, lớp học phần, rồi phân công giáo viên
6. **Xem báo cáo**: Truy cập báo cáo lương để xem chi tiết

## Dữ liệu mẫu có sẵn
- 5 bằng cấp (Cử nhân, Thạc sĩ, Tiến sĩ, v.v.)
- 5 khoa (CNTT, Toán, Vật lý, v.v.)
- 8 môn học (Lập trình, Cấu trúc dữ liệu, v.v.)
- 4 học kỳ (2024-2025, 2025-2026)

## Hệ thống hoàn chỉnh và sẵn sàng sử dụng!
