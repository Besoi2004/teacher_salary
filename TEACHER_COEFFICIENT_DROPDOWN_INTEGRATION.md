# TEACHER COEFFICIENT DEGREE DROPDOWN INTEGRATION

## Yêu cầu:
Trong trang tạo/sửa hệ số giáo viên, thay đổi trường "Tên bằng cấp" từ **input text** thành **dropdown** với các tùy chọn:
- Chỉ hiển thị các bằng cấp đã được tạo trong hệ thống (từ bảng `degrees`)
- Không cho phép chọn các bằng cấp đã có hệ số
- Hiển thị thông báo khi không có bằng cấp nào có sẵn

## Giải pháp đã triển khai:

### 1. Cập nhật TeacherCoefficientController

#### Import Model mới:
```php
use App\Models\Degree;
```

#### Method `create()`:
- Lấy danh sách tất cả bằng cấp: `Degree::orderBy('ten_day_du')->get()`
- Lấy danh sách bằng cấp đã có hệ số: `TeacherCoefficient::pluck('ten_bang_cap')`
- Truyền cả hai danh sách xuống view

#### Method `edit()`:
- Lấy danh sách tất cả bằng cấp
- Lấy danh sách bằng cấp đã có hệ số (trừ bằng cấp hiện tại)
- Cho phép chọn bằng cấp hiện tại + các bằng cấp chưa có hệ số

### 2. Cập nhật View `create.blade.php`

#### Thay đổi từ Input Text sang Dropdown:
```html
<select class="form-select" id="ten_bang_cap" name="ten_bang_cap" required>
    <option value="">-- Chọn bằng cấp --</option>
    @foreach($degrees as $degree)
        @if(!in_array($degree->ten_day_du, $existingDegrees))
            <option value="{{ $degree->ten_day_du }}">
                {{ $degree->ten_day_du }} ({{ $degree->ten_viet_tat }})
            </option>
        @endif
    @endforeach
</select>
```

#### Thêm logic kiểm tra và thông báo:
- **Khi chưa có bằng cấp nào:** Hiển thị thông báo + link tạo bằng cấp
- **Khi tất cả bằng cấp đã có hệ số:** Hiển thị thông báo + link tạo bằng cấp mới hoặc quản lý hệ số
- **Khi có bằng cấp khả dụng:** Hiển thị form bình thường

#### Thông báo hướng dẫn:
- Form text: "Chỉ hiển thị các bằng cấp chưa có hệ số"
- Alert warning/info tùy trường hợp

### 3. Cập nhật View `edit.blade.php`

#### Dropdown tương tự create:
- Hiển thị bằng cấp hiện tại (đã selected)
- Hiển thị các bằng cấp chưa có hệ số khác
- Không hiển thị các bằng cấp đã có hệ số (trừ hiện tại)

#### Logic hiển thị:
```php
@if(!in_array($degree->ten_day_du, $existingDegrees) || $degree->ten_day_du == $teacherCoefficient->ten_bang_cap)
    <option value="{{ $degree->ten_day_du }}" 
            {{ old('ten_bang_cap', $teacherCoefficient->ten_bang_cap) == $degree->ten_day_du ? 'selected' : '' }}>
        {{ $degree->ten_day_du }} ({{ $degree->ten_viet_tat }})
    </option>
@endif
```

## Tính năng bổ sung:

### 1. Hiển thị tên đầy đủ + viết tắt:
- Format: "Cử nhân Kỹ thuật (CK)" 
- Dữ liệu từ: `ten_day_du` + `ten_viet_tat`

### 2. Validation tự động:
- Chỉ cho phép chọn từ danh sách có sẵn
- Không thể submit form nếu không chọn bằng cấp
- Validation unique vẫn hoạt động ở server-side

### 3. UX/UI improvements:
- Thông báo rõ ràng cho từng trường hợp
- Link trực tiếp đến trang tạo bằng cấp
- Form text giải thích logic hiển thị

## Các trường hợp sử dụng:

### 1. Lần đầu tạo hệ số (chưa có bằng cấp):
- ❌ Hiển thị alert warning
- ✅ Link đến trang tạo bằng cấp
- ❌ Ẩn form

### 2. Có bằng cấp nhưng tất cả đã có hệ số:
- ❌ Hiển thị alert info
- ✅ Link tạo bằng cấp mới hoặc quản lý hệ số
- ❌ Ẩn form

### 3. Có bằng cấp khả dụng:
- ✅ Hiển thị form bình thường
- ✅ Dropdown chỉ hiển thị bằng cấp chưa có hệ số
- ✅ Thông báo hướng dẫn

### 4. Chỉnh sửa hệ số:
- ✅ Hiển thị form
- ✅ Bằng cấp hiện tại được selected
- ✅ Dropdown hiển thị: bằng cấp hiện tại + các bằng cấp chưa có hệ số

## Kết quả:
- ✅ Dropdown thay thế input text
- ✅ Chỉ hiển thị bằng cấp từ hệ thống
- ✅ Không trùng lặp bằng cấp đã có hệ số
- ✅ Thông báo hướng dẫn rõ ràng
- ✅ UX/UI thân thiện
- ✅ Validation chặt chẽ
- ✅ Tích hợp với hệ thống quản lý bằng cấp

## Liên kết với các module:
- **Degrees Management:** Nguồn dữ liệu dropdown
- **Teacher Management:** Sử dụng hệ số để tính lương
- **Salary Calculation:** Áp dụng hệ số vào công thức tính lương

## Test cases:
1. **Tạo bằng cấp → tạo hệ số:** Bằng cấp xuất hiện trong dropdown
2. **Tạo hệ số → tạo hệ số khác:** Bằng cấp đã dùng không xuất hiện
3. **Sửa hệ số:** Bằng cấp hiện tại vẫn có thể chọn
4. **Xóa hệ số → tạo lại:** Bằng cấp xuất hiện lại trong dropdown

Ngày triển khai: 23/06/2025
