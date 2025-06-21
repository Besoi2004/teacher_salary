# Hệ thống Quản lý Lương Giáo viên

Hệ thống quản lý lương giáo viên được xây dựng bằng Laravel 11, giúp quản lý thông tin giáo viên, phân công giảng dạy và tính toán lương một cách hiệu quả.

## Tính năng chính

### 1. Quản lý Giáo viên
- ✅ Thêm, sửa, xóa thông tin giáo viên
- ✅ Quản lý theo khoa, bằng cấp
- ✅ Hiển thị danh sách và thống kê

### 2. Quản lý Học phần và Lớp học
- ✅ Quản lý môn học/học phần
- ✅ Quản lý học kỳ
- ✅ Quản lý lớp học phần
- ✅ Thống kê theo học kỳ

### 3. Phân công Giảng dạy
- ✅ **Phân công từng lớp**: Phân công một giáo viên cho một lớp học phần
- ✅ **Phân công hàng loạt**: Chọn nhiều lớp cùng lúc cho một giáo viên
- ✅ **Kiểm tra trùng lặp**: Không cho phép 2 giáo viên cùng dạy 1 lớp
- ✅ **Hiển thị trạng thái**: Lớp đã được phân công hiển thị màu vàng và không thể chọn
- ✅ **Panel trạng thái**: Hiển thị danh sách lớp đã/chưa được phân công

### 4. Giao diện thân thiện
- ✅ Dropdown cascade: Học kỳ → Học phần → Lớp học phần
- ✅ Responsive design với Bootstrap 5
- ✅ Thông báo lỗi chi tiết và rõ ràng
- ✅ Icons FontAwesome

## Công nghệ sử dụng

- **Backend**: Laravel 11 (PHP 8.1+)
- **Database**: SQLite (có thể chuyển sang MySQL/PostgreSQL)
- **Frontend**: Bootstrap 5, FontAwesome, JavaScript
- **Other**: Composer, NPM

## Cài đặt

1. **Clone repository**
```bash
git clone https://github.com/YOUR_USERNAME/teacher-salary-management.git
cd teacher-salary-management
```

2. **Cài đặt dependencies**
```bash
composer install
npm install
```

3. **Cấu hình môi trường**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Cấu hình database trong file .env**
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

5. **Chạy migration và seeder**
```bash
touch database/database.sqlite
php artisan migrate --seed
```

6. **Khởi động server**
```bash
php artisan serve
```

Truy cập: `http://localhost:8000/admin`

## Cấu trúc Database

- **teachers**: Thông tin giáo viên
- **departments**: Khoa/Bộ môn
- **degrees**: Bằng cấp
- **subjects**: Học phần/Môn học
- **semesters**: Học kỳ
- **class_subjects**: Lớp học phần
- **teaching_assignments**: Phân công giảng dạy

## Tác giả

Được phát triển với ❤️

## Giấy phép

Dự án này sử dụng giấy phép MIT.

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
