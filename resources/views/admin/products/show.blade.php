@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Product Details</h2>
            <a class="btn btn-primary" href="{{ route('admin.products.index') }}">Back</a>
        </div>
    </div>

    <div class="card shadow-lg rounded">
        <div class="row g-0">
            <!-- Ảnh sản phẩm -->
            <div class="col-md-4 text-center p-4">
                @if ($product->image_url)
                    <img src="{{ asset($product->image_url) }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 300px; object-fit: contain;" 
                         alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/300x300?text=No+Image" 
                         class="img-fluid rounded shadow-sm" 
                         alt="No image">
                @endif
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <h5 class="text-danger fw-bold">
                        {{ number_format($product->price, 0, ',', '.') }} VNĐ
                    </h5>
                    <p class="card-text text-muted">{{ $product->description ?? 'No description available.' }}</p>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Quantity:</strong> {{ $product->quantity }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Weight:</strong> {{ $product->weight }} g
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Brand:</strong> {{ $product->brand }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Frame Material:</strong> {{ $product->frame_material }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Lens Color:</strong> {{ $product->lens_color }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Lens Material:</strong> {{ $product->lens_material }}
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                            Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                              method="POST" 
                              style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
