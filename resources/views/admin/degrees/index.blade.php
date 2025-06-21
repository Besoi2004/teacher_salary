@extends('layouts.admin')

@section('title', 'Danh sách Bằng cấp')
@section('page-title', 'Danh sách Bằng cấp')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-certificate me-2"></i>
                Danh sách Bằng cấp
            </h2>
            <a href="{{ route('admin.degrees.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Thêm Bằng cấp
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($degrees->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Tên đầy đủ</th>
                                    <th>Tên viết tắt</th>
                                    <th>Số giáo viên</th>
                                    <th>Mô tả</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($degrees as $index => $degree)
                                    <tr>
                                        <td>{{ $degrees->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $degree->ten_day_du }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $degree->ten_viet_tat }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $degree->teachers_count }} giáo viên</span>
                                        </td>
                                        <td>
                                            {{ Str::limit($degree->mo_ta, 50) }}
                                        </td>
                                        <td>{{ $degree->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.degrees.show', $degree) }}" 
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.degrees.edit', $degree) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.degrees.destroy', $degree) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa bằng cấp này?')">
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
                        {{ $degrees->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có bằng cấp nào</h5>
                        <p class="text-muted">Bấm vào nút "Thêm Bằng cấp" để bắt đầu.</p>
                        <a href="{{ route('admin.degrees.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Thêm Bằng cấp đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
