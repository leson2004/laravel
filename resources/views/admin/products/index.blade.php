@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-lg-6">
            <h2 class="fw-bold">Danh sách sản phẩm</h2>
        </div>
        <div class="col-lg-6 text-end">
            <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên SP</th>
                    <th>Mô tả</th>
                    <th>Số lượng</th>
                    <th>Giá (VNĐ)</th>
                    <th>Chất liệu gọng</th>
                    <th>Màu tròng</th>
                    <th>Chất liệu tròng</th>
                    <th>Thương hiệu</th>
                    <th>Trọng lượng (g)</th>
                    <th>Loại</th>
                    <th width="200px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        
                        <!-- Ảnh sản phẩm -->
                        <td>
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail"
                                     style="width:80px; height:80px; object-fit:cover;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>

                        <td>{{ $product->name }}</td>
                        <td class="text-truncate" style="max-width: 150px;">{{ $product->description }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->frame_material }}</td>
                        <td>{{ $product->lens_color }}</td>
                        <td>{{ $product->lens_material }}</td>
                        <td>{{ $product->brand }}</td>
                        <td>{{ $product->weight }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ route('admin.products.show', $product->id) }}">
                                <i class="bi bi-eye"></i> Xem
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', $product->id) }}">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
