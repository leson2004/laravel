@extends('layouts.user')

@section('content')
<div class="container mt-4">

    <!-- Banner -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary"> MyShop - Mua sắm thả ga</h1>
        <p class="text-muted">Tìm sản phẩm bạn yêu thích với giá tốt nhất!</p>
    </div>

    <div class="row">
        <!-- Sidebar bộ lọc -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    Bộ lọc sản phẩm
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('welcome') }}">
                        <!-- Tìm kiếm -->
                        <div class="mb-3">
                            <label class="form-label">Từ khóa</label>
                            <input type="text" name="keyword" class="form-control"
                                   value="{{ request('keyword') }}" placeholder="Nhập tên sản phẩm...">
                        </div>

                        <!-- Danh mục -->
                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select name="category" class="form-select">
                                <option value="">Tất cả</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Giá -->
                        <div class="mb-3">
                            <label class="form-label">Khoảng giá</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="price_min" class="form-control" placeholder="Từ"
                                       value="{{ request('price_min') }}">
                                <input type="number" name="price_max" class="form-control" placeholder="Đến"
                                       value="{{ request('price_max') }}">
                            </div>
                        </div>

                        <!-- Sắp xếp -->
                        <div class="mb-3">
                            <label class="form-label">Sắp xếp</label>
                            <select name="sort" class="form-select">
                                <option value="">Mặc định</option>
                                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Lọc sản phẩm
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <!-- Ảnh -->
                            <img src="{{ $product->image_url ? asset($product->image_url) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                 class="card-img-top" alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">

                            <!-- Nội dung -->
                            <div class="card-body text-center">
                                <h6 class="fw-bold text-dark">{{ $product->name }}</h6>
                                <p class="text-muted small mb-1">{{ optional($product->category)->name }}</p>
                                <p class="fw-bold text-danger mb-2">
                                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                </p>
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Không tìm thấy sản phẩm phù hợp.</p>
                @endforelse
            </div>

            <!-- ✅ Phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        border-radius: 12px;
        transition: all 0.25s ease-in-out;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection
