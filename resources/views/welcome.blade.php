<!-- views/welcome.blade.php -->
@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <!-- Tiêu đề -->
    <h1 class="mb-5 text-center fw-bold text-primary">
        🌟 Chào mừng đến với MyShop 🌟
    </h1>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    
                    <!-- Ảnh sản phẩm -->
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}"
                             class="card-img-top" 
                             alt="{{ $product->name }}" 
                             style="height: 220px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image" 
                             class="card-img-top" 
                             alt="No image"
                             style="height: 220px; object-fit: cover;">
                    @endif

                    <!-- Nội dung -->
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold text-dark">{{ $product->name }}</h5>
                        <p class="card-text text-muted text-truncate" style="max-width: 260px; margin: auto;">
                            {{ $product->description }}
                        </p>
                        <p class="mb-1">
                            <span class="badge bg-success">Còn: {{ $product->quantity }}</span>
                        </p>
                        <p class="fw-bold text-danger fs-5 mb-1">
                            {{ number_format($product->price, 0, ',', '.') }} VNĐ
                        </p>
                        <p class="text-muted mb-3">
                            <i class="bi bi-tags"></i> {{ optional($product->category)->name ?? 'Chưa phân loại' }}
                        </p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm px-3">
                            <i class="bi bi-eye"></i> Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Custom style -->
<style>
    .product-card {
        border-radius: 12px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .page-link {
        border-radius: 6px !important;
        margin: 0 3px;
        color: #0d6efd;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endsection
