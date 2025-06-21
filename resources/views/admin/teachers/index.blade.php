@extends('layouts.admin')

@section('title', 'Danh sách Giáo viên')
@section('page-title', 'Danh sách Giáo viên')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-user-tie me-2"></i>
                Danh sách Giáo viên
            </h2>            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Thêm Giáo viên
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($teachers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Mã số</th>
                                    <th>Họ tên</th>
                                    <th>Khoa</th>
                                    <th>Bằng cấp</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teachers as $index => $teacher)
                                    <tr>
                                        <td>{{ $teachers->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $teacher->ma_so }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $teacher->ho_ten }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-birthday-cake me-1"></i>
                                                    {{ $teacher->ngay_sinh->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $teacher->department->ten_viet_tat }}</span>
                                            <br>
                                            <small class="text-muted">{{ $teacher->department->ten_day_du }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $teacher->degree->ten_viet_tat }}</span>
                                            <br>
                                            <small class="text-muted">{{ $teacher->degree->ten_day_du }}</small>
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope me-1"></i>
                                            {{ $teacher->email }}
                                        </td>
                                        <td>
                                            @if($teacher->dien_thoai)
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $teacher->dien_thoai }}
                                            @else
                                                <span class="text-muted">Chưa có</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.teachers.show', $teacher) }}" 
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.teachers.edit', $teacher) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa giáo viên này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $teachers->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có giáo viên nào</h5>
                        <p class="text-muted">Bấm vào nút "Thêm Giáo viên" để bắt đầu.</p>                        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Thêm Giáo viên đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
