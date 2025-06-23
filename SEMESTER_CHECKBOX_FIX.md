# SEMESTER CHECKBOX FIX

## Vấn đề đã phát hiện:
- Khi bỏ check checkbox "Kích hoạt học kỳ" trong form edit, hệ thống không ghi nhận thay đổi
- Nguyên nhân: Checkbox khi không được check sẽ không gửi dữ liệu lên server

## Giải pháp đã áp dụng:

### 1. Cập nhật View (Form)
**Files:** 
- `resources/views/admin/semesters/edit.blade.php`
- `resources/views/admin/semesters/create.blade.php`

**Thay đổi:**
- Thêm hidden input với giá trị 0 trước checkbox
- Khi checkbox không được check: gửi giá trị 0
- Khi checkbox được check: gửi giá trị 1 (override giá trị hidden)

```html
<!-- Hidden input để đảm bảo luôn có giá trị gửi lên khi checkbox không được check -->
<input type="hidden" name="is_active" value="0">
<input class="form-check-input" 
       type="checkbox" 
       id="is_active" 
       name="is_active" 
       value="1"
       {{ old('is_active', $semester->is_active) ? 'checked' : '' }}>
```

### 2. Cập nhật Controller
**File:** `app/Http/Controllers/SemesterController.php`

**Thay đổi trong method store():**
- Thêm validation cho `is_active`
- Sử dụng `$request->boolean('is_active')` để xử lý giá trị boolean
- Logic: nếu kích hoạt học kỳ này, tự động tắt tất cả học kỳ khác
- Tạo data array rõ ràng thay vì dùng `$request->all()`

**Thay đổi trong method update():**
- Thêm validation cho `is_active`
- Sử dụng `$request->boolean('is_active')` để xử lý giá trị boolean
- Logic: nếu kích hoạt học kỳ này, tự động tắt tất cả học kỳ khác (trừ chính nó)
- Tạo data array rõ ràng thay vì dùng `$request->all()`

## Tính năng bổ sung:
- **Chỉ có 1 học kỳ active:** Khi kích hoạt một học kỳ, tất cả học kỳ khác sẽ tự động bị tắt
- **Xử lý boolean chính xác:** Sử dụng `$request->boolean()` để đảm bảo giá trị đúng kiểu

## Kết quả:
- ✅ Checkbox "Kích hoạt học kỳ" hoạt động chính xác (cả check và uncheck)
- ✅ Hệ thống chỉ cho phép 1 học kỳ active tại một thời điểm
- ✅ Dữ liệu được lưu đúng trong database
- ✅ Form validation hoạt động chính xác

## Test case:
1. **Tạo học kỳ mới với is_active = true:** Tất cả học kỳ khác tự động chuyển thành false
2. **Tạo học kỳ mới với is_active = false:** Không ảnh hưởng học kỳ khác
3. **Edit học kỳ: check is_active:** Tất cả học kỳ khác tự động chuyển thành false
4. **Edit học kỳ: uncheck is_active:** Học kỳ đó chuyển thành false, học kỳ khác không đổi
5. **Validation:** Form vẫn hoạt động bình thường với các trường khác

Ngày sửa: 23/06/2025
