<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hệ thống tính tiền dạy giảng viên')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
        
        .sidebar .nav-link {
            color: white;
            transition: all 0.3s;
            padding: 0.75rem 1rem;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
            border-left: 4px solid white;
        }
        
        .main-content {
            margin-left: 250px;
            background-color: #f8f9fa;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .main-content .navbar {
            position: sticky;
            top: 0;
            z-index: 999;
            backdrop-filter: blur(10px);
            background-color: rgba(255,255,255,0.95) !important;
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Animation for collapse */
        .collapse {
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
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
                                    </a>                                </div>
                            </div>
                        </div>
                        
                        <!-- Dropdown Tính tiền dạy -->
                        <div class="nav-item">
                            <a class="nav-link d-flex justify-content-between align-items-center" 
                               data-bs-toggle="collapse" 
                               href="#paymentManagement" 
                               role="button" 
                               aria-expanded="false">
                                <span>
                                    <i class="fas fa-money-bill-wave me-2"></i>
                                    Tính tiền dạy
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </a>                            <div class="collapse" id="paymentManagement">
                                <div class="ms-3">
                                    <a class="nav-link {{ request()->routeIs('admin.payment-rates.*') ? 'active' : '' }}" href="{{ route('admin.payment-rates.index') }}">
                                        <i class="fas fa-dollar-sign me-2"></i>
                                        Tiền theo tiết
                                    </a>                                    <a class="nav-link {{ request()->routeIs('admin.teacher-coefficients.*') ? 'active' : '' }}" href="{{ route('admin.teacher-coefficients.index') }}">
                                        <i class="fas fa-user-graduate me-2"></i>
                                        Hệ số giáo viên
                                    </a>                                    <a class="nav-link {{ request()->routeIs('admin.class-coefficients.*') ? 'active' : '' }}" href="{{ route('admin.class-coefficients.index') }}">
                                        <i class="fas fa-users me-2"></i>
                                        Hệ số lớp
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.salary-calculation.*') ? 'active' : '' }}" href="{{ route('admin.salary-calculation.index') }}">
                                        <i class="fas fa-calculator me-2"></i>
                                        Tính tiền dạy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
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
                    @endif                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Giữ trạng thái dropdown khi chuyển trang
        document.addEventListener('DOMContentLoaded', function() {
            // Lưu trạng thái dropdown
            const collapses = document.querySelectorAll('.collapse');
            collapses.forEach(collapse => {
                collapse.addEventListener('shown.bs.collapse', function() {
                    localStorage.setItem(this.id + '_state', 'open');
                });
                
                collapse.addEventListener('hidden.bs.collapse', function() {
                    localStorage.setItem(this.id + '_state', 'closed');
                });
                
                // Khôi phục trạng thái dropdown
                const state = localStorage.getItem(collapse.id + '_state');
                if (state === 'open') {
                    const bsCollapse = new bootstrap.Collapse(collapse, {
                        show: true
                    });
                }
            });
            
            // Smooth scroll cho sidebar
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Thêm hiệu ứng ripple
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
        
        // Thêm hiệu ứng loading khi chuyển trang
        window.addEventListener('beforeunload', function() {
            document.body.style.opacity = '0.8';
        });
    </script>
    
    <style>
        /* Hiệu ứng ripple cho nav-link */
        .sidebar .nav-link {
            position: relative;
            overflow: hidden;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        /* Loading effect */
        body {
            transition: opacity 0.3s ease;
        }
    </style>
    
    @stack('scripts')
</body>
</html>
