<!-- views/products/show.blade.php -->
@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Chi tiết sản phẩm</h2>
            <a class="btn btn-secondary" href="{{ route('welcome') }}">← Quay lại</a>
        </div>
    </div>

    <div class="card shadow-lg rounded">
        <div class="row g-0">
            <!-- Ảnh sản phẩm -->
            <div class="col-md-5 text-center p-4">
                @if ($product->image_url)
                    <img src="{{ asset($product->image_url) }}"
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 350px; object-fit: contain;" 
                         alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/350x350?text=No+Image" 
                         class="img-fluid rounded shadow-sm" 
                         alt="No image">
                @endif
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-7">
                <div class="card-body">
                    <h3 class="card-title fw-bold">{{ $product->name }}</h3>
                    <h4 class="text-danger fw-bold">
                        {{ number_format($product->price, 0, ',', '.') }} VNĐ
                    </h4>
                    <p class="card-text text-muted">
                        {{ $product->description ?? 'Không có mô tả.' }}
                    </p>

                    <div class="row mt-3">
                        <div class="col-md-6 mb-2"><strong>Số lượng:</strong> {{ $product->quantity }}</div>
                        <div class="col-md-6 mb-2"><strong>Trọng lượng:</strong> {{ $product->weight }} g</div>
                        <div class="col-md-6 mb-2"><strong>Thương hiệu:</strong> {{ $product->brand }}</div>
                        <div class="col-md-6 mb-2"><strong>Loại:</strong> {{ $product->category->name ?? 'N/A' }}</div>
                        <div class="col-md-6 mb-2"><strong>Chất liệu gọng:</strong> {{ $product->frame_material }}</div>
                        <div class="col-md-6 mb-2"><strong>Màu tròng:</strong> {{ $product->lens_color }}</div>
                        <div class="col-md-6 mb-2"><strong>Chất liệu tròng:</strong> {{ $product->lens_material }}</div>
                    </div>

                    <div class="mt-4">
                        @auth
                            <!-- Form để thêm sản phẩm vào giỏ hàng -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-lg btn-success shadow">
                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                Vui lòng <a href="{{ route('login') }}" class="fw-bold">đăng nhập</a> 
                                để thêm sản phẩm vào giỏ hàng.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
