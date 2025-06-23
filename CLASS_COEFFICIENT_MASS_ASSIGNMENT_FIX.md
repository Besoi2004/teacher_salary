# CLASS COEFFICIENT MASS ASSIGNMENT FIX

## Lỗi phát hiện:
```
Add [_token] to fillable property to allow mass assignment on [App\Models\ClassCoefficient].
```

## Nguyên nhân:
- Model `ClassCoefficient` chưa khai báo thuộc tính `$fillable`
- Laravel cố gắng gán tất cả dữ liệu từ form (bao gồm `_token`) vào model
- `_token` (CSRF token) không phải là trường database và không nên được gán vào model

## Giải pháp đã áp dụng:

### 1. Cập nhật Model ClassCoefficient

#### Thêm thuộc tính fillable:
```php
protected $fillable = [
    'tu_sv',
    'den_sv', 
    'he_so',
    'mo_ta',
    'trang_thai'
];
```

#### Thêm casting cho kiểu dữ liệu:
```php
protected $casts = [
    'trang_thai' => 'boolean',
    'he_so' => 'decimal:2'
];
```

#### Thêm các method hỗ trợ:
- `getCoefficientByStudentCount()`: Tìm hệ số theo số sinh viên
- `isValidRange()`: Kiểm tra khoảng hợp lệ
- `getRangeDescriptionAttribute()`: Mô tả khoảng

### 2. Cập nhật Controller

#### Thay đổi từ `$request->all()` sang data filtering:

**Method store():**
```php
$data = [
    'tu_sv' => $request->tu_sv,
    'den_sv' => $request->den_sv,
    'he_so' => $request->he_so,
    'mo_ta' => $request->mo_ta,
    'trang_thai' => $request->boolean('trang_thai')
];
ClassCoefficient::create($data);
```

**Method update():**
```php
$data = [
    'tu_sv' => $request->tu_sv,
    'den_sv' => $request->den_sv,
    'he_so' => $request->he_so,
    'mo_ta' => $request->mo_ta,
    'trang_thai' => $request->boolean('trang_thai')
];
$classCoefficient->update($data);
```

#### Ưu điểm của giải pháp:
- **An toàn:** Chỉ cho phép gán những trường được phép
- **Rõ ràng:** Dễ hiểu trường nào được gán
- **Boolean handling:** Xử lý đúng kiểu boolean cho `trang_thai`
- **Loại bỏ _token:** Không cố gán CSRF token vào model

## Lý do không thêm _token vào fillable:

### ❌ Không nên làm:
```php
protected $fillable = ['tu_sv', 'den_sv', 'he_so', 'mo_ta', 'trang_thai', '_token'];
```

### ✅ Lý do:
1. `_token` không phải trường database
2. `_token` chỉ dùng để CSRF protection
3. Gây confuse cho developers khác
4. Không tuân thủ best practices của Laravel

## Cấu trúc database class_coefficients:

```sql
- id (bigint, auto_increment, primary key)
- tu_sv (integer) - Từ số sinh viên
- den_sv (integer) - Đến số sinh viên  
- he_so (decimal 5,2) - Hệ số lớp
- mo_ta (text, nullable) - Mô tả
- trang_thai (boolean) - Trạng thái hoạt động
- created_at (timestamp)
- updated_at (timestamp)
```

## Form data flow:

### Trước khi sửa:
```
Form → Controller → $request->all() → Model → Lỗi mass assignment
```

### Sau khi sửa:
```
Form → Controller → Data filtering → Model → Success
```

## Validation:
```php
$request->validate([
    'tu_sv' => 'required|integer|min:0',
    'den_sv' => 'required|integer|min:0|gte:tu_sv',
    'he_so' => 'required|numeric|min:0',
    'mo_ta' => 'nullable|string|max:500',
    'trang_thai' => 'boolean'
]);
```

## View form handling:
- `trang_thai` sử dụng select dropdown với options 1/0
- `$request->boolean('trang_thai')` tự động chuyển đổi về boolean
- CSRF token được Laravel tự động thêm vào form

## Kết quả:
- ✅ Lỗi mass assignment đã được khắc phục
- ✅ Model có cấu trúc rõ ràng và an toàn
- ✅ Controller xử lý dữ liệu chính xác
- ✅ Không còn cố gán _token vào model
- ✅ Boolean field được xử lý đúng cách
- ✅ Code tuân thủ Laravel best practices

## Test cases:
1. **Tạo hệ số lớp mới:** Form submit thành công, dữ liệu lưu đúng
2. **Sửa hệ số lớp:** Cập nhật thành công, giữ nguyên validation
3. **Checkbox trang_thai:** Cả check/uncheck đều hoạt động đúng
4. **CSRF protection:** Vẫn hoạt động bình thường

Ngày sửa: 23/06/2025
