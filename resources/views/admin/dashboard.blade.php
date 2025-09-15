{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-speedometer2"></i> Admin Dashboard
        </h1>
        <p class="text-muted">
            Chào mừng đến với trang quản trị! Từ đây, bạn có thể quản lý sản phẩm, danh mục và đơn hàng.
        </p>
    </div>

    <div class="row g-4">
        <!-- Quản lý sản phẩm -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100 text-center">
                <div class="card-body py-5">
                    <div class="mb-3">
                        <i class="bi bi-box-seam display-4 text-primary"></i>
                    </div>
                    <h4 class="fw-bold">Quản lý Sản phẩm</h4>
                    <p class="text-muted">Thêm, chỉnh sửa và xóa sản phẩm của bạn.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right-circle"></i> Đi tới
                    </a>
                </div>
            </div>
        </div>

        <!-- Quản lý danh mục -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100 text-center">
                <div class="card-body py-5">
                    <div class="mb-3">
                        <i class="bi bi-tags display-4 text-secondary"></i>
                    </div>
                    <h4 class="fw-bold">Quản lý Danh mục</h4>
                    <p class="text-muted">Sắp xếp và quản lý các danh mục sản phẩm.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right-circle"></i> Đi tới
                    </a>
                </div>
            </div>
        </div>

        <!-- Quản lý đơn hàng -->
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100 text-center">
                <div class="card-body py-5">
                    <div class="mb-3">
                        <i class="bi bi-bag-check display-4 text-success"></i>
                    </div>
                    <h4 class="fw-bold">Quản lý Đơn hàng</h4>
                    <p class="text-muted">Theo dõi và xử lý các đơn hàng của khách.</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-success">
                        <i class="bi bi-arrow-right-circle"></i> Đi tới
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
