@extends('layouts.admin')

@section('title', 'Danh sách Khoa')
@section('page-title', 'Danh sách Khoa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-building me-2"></i>
                Danh sách Khoa
            </h2>
            <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Thêm Khoa
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($departments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Tên đầy đủ</th>
                                    <th>Tên viết tắt</th>
                                    
                                    <th>Mô tả nhiệm vụ</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $index => $department)
                                    <tr>
                                        <td>{{ $departments->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $department->ten_day_du }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $department->ten_viet_tat }}</span>
                                        </td>
                                        
                                        <td>
                                            {{ Str::limit($department->mo_ta_nhiem_vu, 50) }}
                                        </td>
                                        <td>{{ $department->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                
                                                <a href="{{ route('admin.departments.edit', $department) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.departments.destroy', $department) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa khoa này?')">
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
                        {{ $departments->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có khoa nào</h5>
                        <p class="text-muted">Bấm vào nút "Thêm Khoa" để bắt đầu.</p>
                        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Thêm Khoa đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
