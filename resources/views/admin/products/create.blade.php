@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Create New Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <!-- Tên sản phẩm -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Product Name:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Enter product name">
                </div>
            </div>

            <!-- Mô tả -->
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                </div>
            </div>

            <!-- Số lượng -->
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Quantity:</strong>
                    <input type="number" name="quantity" class="form-control" placeholder="Enter quantity">
                </div>
            </div>

            <!-- Giá -->
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Price (VNĐ):</strong>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter price">
                </div>
            </div>

            <!-- Trọng lượng -->
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Weight (g):</strong>
                    <input type="number" step="0.1" name="weight" class="form-control" placeholder="Enter weight">
                </div>
            </div>

            <!-- Chất liệu gọng -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Frame Material:</strong>
                    <input type="text" name="frame_material" class="form-control" placeholder="Enter frame material">
                </div>
            </div>

            <!-- Màu tròng -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Lens Color:</strong>
                    <input type="text" name="lens_color" class="form-control" placeholder="Enter lens color">
                </div>
            </div>

            <!-- Chất liệu tròng -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Lens Material:</strong>
                    <input type="text" name="lens_material" class="form-control" placeholder="Enter lens material">
                </div>
            </div>

            <!-- Thương hiệu -->
            <div class="col-md-6">
                <div class="form-group">
                    <strong>Brand:</strong>
                    <input type="text" name="brand" class="form-control" placeholder="Enter brand">
                </div>
            </div>

            <!-- Chọn Category -->
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Upload ảnh -->
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Product Image:</strong>
                    <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                    <img id="preview" src="#" alt="Preview" style="max-width:150px; margin-top:10px; display:none;">
                </div>
            </div>

            <!-- Submit -->
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const output = document.getElementById('preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.style.display = "block";
    }
</script>
@endsection
