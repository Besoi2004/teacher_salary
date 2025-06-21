# Sửa lỗi "Cannot end a section without first starting one"

## Mô tả lỗi
- Lỗi: `Cannot end a section without first starting one`
- Xuất hiện khi truy cập view Blade template
- Lỗi Blade template structure

## Nguyên nhân
- **File corruption**: JavaScript code còn sót lại sau `@endsection`
- **Duplicate @endsection**: Có hai `@endsection` trong cùng một file
- **Cấu trúc Blade sai**: Sau khi edit, cấu trúc file bị hỏng

## Chi tiết lỗi trong file
```blade
</div>
@endsection
    const totalHoursValue = document.getElementById('total-hours-value');
    const standardHours = document.getElementById('standard-hours');
    // ... more JavaScript code ...
});
</script>
@endsection  <!-- Duplicate @endsection -->
```

## Cấu trúc đúng của Blade template
```blade
@extends('layouts.admin')

@section('title', 'Page Title')

@section('content')
<!-- HTML content here -->
@endsection

@section('scripts')  <!-- Optional -->
<script>
// JavaScript here
</script>
@endsection
```

## Giải pháp đã thực hiện

### 1. Xóa JavaScript thừa
```blade
<!-- Trước (sai) -->
@endsection
    const totalHoursValue = document.getElementById('total-hours-value');
    // ... JavaScript code ...
@endsection

<!-- Sau (đúng) -->
@endsection
```

### 2. Sửa format HTML
```blade
<!-- Trước (sai) -->
</a>                            <button type="submit">

<!-- Sau (đúng) -->
</a>
<button type="submit">
```

### 3. Đảm bảo cấu trúc đúng
- **Một @extends** duy nhất ở đầu file
- **Mỗi @section** có một **@endsection** tương ứng
- **Không có code** ngoài section (trừ @extends)
- **HTML tags** được đóng đúng thứ tự

## Cấu trúc file sau khi sửa
```blade
@extends('layouts.admin')

@section('title', 'Thêm Lớp học phần')

@section('content')
<div class="container-fluid">
    <!-- Form content -->
</div>
@endsection
```

## Kết quả
- ✅ View load thành công không còn lỗi Blade
- ✅ HTML structure đúng chuẩn
- ✅ Form hiển thị đầy đủ fields
- ✅ Dropdown data hiển thị chính xác

## Cách debug Blade template errors

### 1. Clear view cache
```bash
php artisan view:clear
```

### 2. Kiểm tra cấu trúc file
- Đảm bảo mỗi `@section` có `@endsection`
- Không có code ngoài sections
- HTML tags được đóng đúng

### 3. Kiểm tra extends và includes
- `@extends` phải ở đầu file
- Layout file phải tồn tại
- Include paths phải đúng

## Kinh nghiệm rút ra
- **Luôn backup** file trước khi edit lớn
- **Kiểm tra cấu trúc** Blade sau mỗi lần edit
- **Clear cache** sau khi sửa view files
- **Test view** ngay sau khi thay đổi
- **Không để code** ngoài @section/@endsection

## Files đã sửa
- `resources/views/admin/class-subjects/create.blade.php` - Fixed Blade structure và xóa JavaScript thừa
