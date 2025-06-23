# PAYMENT RATE SINGLE RECORD RESTRICTION

## Yêu cầu:
Hệ thống chỉ cho phép có **1 mức lương duy nhất** trong bảng `payment_rates`:
- Khi đã có 1 mức lương → không thể thêm mới
- Chỉ có thể **sửa** hoặc **xóa** mức lương hiện có
- Hiển thị thông báo rõ ràng cho người dùng

## Giải pháp đã triển khai:

### 1. Cập nhật PaymentRateController

#### Method `index()`:
- Thêm biến `$hasPaymentRate` để kiểm tra đã có mức lương chưa
- Truyền biến này xuống view để điều khiển giao diện

#### Method `create()`:
- Kiểm tra `PaymentRate::exists()`
- Nếu đã có → redirect về index với thông báo lỗi
- Nếu chưa có → cho phép tạo mới

#### Method `store()`:
- Kiểm tra lại `PaymentRate::exists()` trước khi lưu
- Đảm bảo không có race condition
- Thông báo lỗi nếu vi phạm quy tắc

#### Method `destroy()`:
- Cập nhật thông báo success để thông báo có thể tạo mới

### 2. Cập nhật View `index.blade.php`

#### Header Card:
- **Khi chưa có mức lương:** Hiển thị nút "Thêm mức lương"
- **Khi đã có mức lương:** Hiển thị thông báo "Hệ thống chỉ cho phép 1 mức lương duy nhất"

#### Thông báo hướng dẫn:
- Thêm alert thông tin khi đã có mức lương
- Giải thích rõ: chỉ có thể sửa hoặc xóa

#### Empty state (khi chưa có dữ liệu):
- Thông báo rõ ràng hơn
- Nút "Tạo mức lương đầu tiên" ngay trong bảng
- Icon và text phù hợp

#### Confirm xóa:
- Thêm thông báo trong popup confirm
- Giải thích rằng sau khi xóa có thể tạo mới

## Các trường hợp sử dụng:

### 1. Chưa có mức lương:
- ✅ Hiển thị nút "Thêm mức lương"
- ✅ Cho phép truy cập `/create`
- ✅ Cho phép `POST` để tạo mới
- ✅ Hiển thị thông báo khuyến khích tạo

### 2. Đã có 1 mức lương:
- ✅ Ẩn nút "Thêm mức lương"
- ✅ Hiển thị thông báo hướng dẫn
- ✅ Chặn truy cập `/create` → redirect với thông báo
- ✅ Chặn `POST` → redirect với thông báo
- ✅ Chỉ cho phép Edit và Delete

### 3. Khi xóa mức lương duy nhất:
- ✅ Thông báo confirm rõ ràng
- ✅ Thông báo success sau khi xóa
- ✅ Tự động chuyển về trạng thái "chưa có mức lương"

## Thông báo người dùng:

### Thông báo lỗi (khi cố tạo thêm):
```
"Hệ thống chỉ cho phép có một mức lương duy nhất. Vui lòng sửa hoặc xóa mức lương hiện tại để tạo mới!"
```

### Thông báo hướng dẫn (trên trang index):
```
"Lưu ý: Hệ thống chỉ cho phép có một mức lương duy nhất. 
Bạn có thể chỉnh sửa hoặc xóa mức lương hiện tại để tạo mức lương mới."
```

### Thông báo xóa thành công:
```
"Mức lương theo tiết đã được xóa thành công! Bạn có thể tạo mức lương mới."
```

## Kết quả:
- ✅ Hệ thống chỉ cho phép 1 mức lương duy nhất
- ✅ Giao diện thông minh (ẩn/hiện nút phù hợp)
- ✅ Thông báo rõ ràng, dễ hiểu
- ✅ Chặn được tất cả các cách thức tạo trùng
- ✅ UX/UI thân thiện với người dùng

## Test cases:
1. **Lần đầu vào trang:** Chưa có dữ liệu → hiển thị nút tạo
2. **Tạo mức lương đầu tiên:** Thành công → ẩn nút tạo, hiện thông báo
3. **Cố tạo thêm qua URL:** Redirect với thông báo lỗi
4. **Sửa mức lương:** Hoạt động bình thường
5. **Xóa mức lương:** Thành công → hiện lại nút tạo

Ngày triển khai: 23/06/2025
