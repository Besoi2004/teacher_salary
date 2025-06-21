# Sửa lỗi "Route not defined"

## Mô tả lỗi
- Lỗi: `Route [teachers.index] not defined.`
- Xuất hiện khi thực hiện CRUD operations (create, update, delete)
- Tương tự cho các controller khác: subjects, departments, degrees

## Nguyên nhân
- **Route prefix chưa nhất quán**: Routes được định nghĩa với prefix `admin.` nhưng controllers redirect về route không có prefix
- **Ví dụ**: Route định nghĩa là `admin.teachers.index` nhưng controller redirect về `teachers.index`

## Chi tiết lỗi

### Routes được định nghĩa (đúng):
```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('teachers', TeacherController::class);
    // Tạo route: admin.teachers.index
});
```

### Controllers redirect (sai):
```php
return redirect()->route('teachers.index')->with('success', '...');
// Tìm route: teachers.index (không tồn tại)
```

## Giải pháp đã thực hiện

### 1. Sửa TeacherController.php
```php
// Trước (sai):
return redirect()->route('teachers.index')->with('success', '...');

// Sau (đúng):
return redirect()->route('admin.teachers.index')->with('success', '...');
```

### 2. Sửa SubjectController.php
```php
// Sửa tất cả redirect từ 'subjects.index' thành 'admin.subjects.index'
```

### 3. Sửa DepartmentController.php
```php
// Sửa tất cả redirect từ 'departments.index' thành 'admin.departments.index'
```

### 4. Sửa DegreeController.php
```php
// Sửa tất cả redirect từ 'degrees.index' thành 'admin.degrees.index'
```

## Kết quả
- ✅ Tất cả CRUD operations hoạt động bình thường
- ✅ Create, Update, Delete redirect đúng trang
- ✅ Success/Error messages hiển thị đúng
- ✅ Không còn lỗi "Route not defined"

## Kinh nghiệm rút ra
- **Luôn kiểm tra route prefix** khi sử dụng redirect
- **Sử dụng named routes nhất quán** trong toàn bộ ứng dụng
- **Test CRUD operations** sau khi thay đổi routes
- **Sử dụng `php artisan route:list`** để kiểm tra route names

## Files đã sửa
- `app/Http/Controllers/TeacherController.php`
- `app/Http/Controllers/SubjectController.php` 
- `app/Http/Controllers/DepartmentController.php`
- `app/Http/Controllers/DegreeController.php`

Tất cả đều đã được cập nhật để sử dụng route names với prefix `admin.` đúng cách.
