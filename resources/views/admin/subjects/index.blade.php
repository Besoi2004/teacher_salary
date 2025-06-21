@extends('layouts.admin')

@section('title', 'Danh sách Học phần')
@section('page-title', 'Danh sách Học phần')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-book me-2"></i>
                Danh sách Học phần
            </h2>
            <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Thêm Học phần
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($subjects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">                                <tr>
                                    <th>#</th>
                                    <th>Mã số</th>
                                    <th>Tên học phần</th>
                                    <th>Số tín chỉ</th>
                                    <th>Hệ số</th>
                                    <th>Số tiết</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $index => $subject)
                                    <tr>
                                        <td>{{ $subjects->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $subject->ma_so }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $subject->ten_hoc_phan }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $subject->so_tin_chi }} TC</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark">{{ $subject->he_so_hoc_phan }}</span>
                                        </td>                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $subject->so_tiet }} tiết</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.subjects.show', $subject) }}" 
                                                   class="btn btn-sm btn-outline-info"
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.subjects.edit', $subject) }}" 
                                                   class="btn btn-sm btn-outline-warning"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.subjects.destroy', $subject) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa học phần này?')">
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
                        {{ $subjects->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có học phần nào</h5>
                        <p class="text-muted">Bấm vào nút "Thêm Học phần" để bắt đầu.</p>
                        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Thêm Học phần đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
