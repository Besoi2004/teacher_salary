<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hệ thống tính tiền dạy giảng viên')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: white;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .navbar-brand {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4 class="text-white text-center mb-4">
                        <i class="fas fa-graduation-cap"></i>
                        Quản lý Giáo viên
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Trang chủ
                        </a>
                          <!-- Dropdown Quản lý Giáo viên -->
                        <div class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#teacherManagement" 
                               role="button" 
                               aria-expanded="false">
                                <span>
                                    <i class="fas fa-users me-2"></i>
                                    Quản lý Giáo viên
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </a>                            <div class="collapse" id="teacherManagement">
                                <div class="ms-3">
                                    <a class="nav-link {{ request()->routeIs('admin.degrees.*') ? 'active' : '' }}" href="{{ route('admin.degrees.index') }}">
                                        <i class="fas fa-certificate me-2"></i>
                                        Bằng cấp
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" href="{{ route('admin.departments.index') }}">
                                        <i class="fas fa-building me-2"></i>
                                        Khoa
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
                                        <i class="fas fa-user-tie me-2"></i>
                                        Giáo viên
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}" href="{{ route('admin.statistics') }}">
                                        <i class="fas fa-chart-bar me-2"></i>
                                        Thống kê Giáo viên
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dropdown Quản lý Lớp học phần -->
                        <div class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#classManagement" 
                               role="button" 
                               aria-expanded="false">
                                <span>
                                    <i class="fas fa-chalkboard-teacher me-2"></i>
                                    Quản lý Lớp học phần
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </a>                            <div class="collapse" id="classManagement">
                                <div class="ms-3">
                                    <a class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}">
                                        <i class="fas fa-book me-2"></i>
                                        Học phần
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.semesters.*') ? 'active' : '' }}" href="{{ route('admin.semesters.index') }}">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Kì học
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.class-subjects.*') ? 'active' : '' }}" href="{{ route('admin.class-subjects.index') }}">
                                        <i class="fas fa-chalkboard me-2"></i>
                                        Lớp học phần
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.teaching-assignments.*') ? 'active' : '' }}" href="{{ route('admin.teaching-assignments.index') }}">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Phân công giảng viên
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content p-0">
                <!-- Header -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
                        <div class="navbar-nav ms-auto">
                            <span class="nav-item nav-link">
                                <i class="fas fa-user-circle me-2"></i>
                                Admin
                            </span>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
