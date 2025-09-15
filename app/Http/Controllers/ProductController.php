<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Form thêm sản phẩm
    public function create()
    {
        $categories = Category::all(); 
        return view('admin.products.create', compact('categories'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'quantity'       => 'required|integer|min:0',
            'price'          => 'required|numeric|min:0',
            'frame_material' => 'nullable|string|max:255',
            'lens_color'     => 'nullable|string|max:255',
            'lens_material'  => 'nullable|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'weight'         => 'nullable|numeric|min:0',
            'category_id'    => 'required|exists:categories,id',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Nếu có ảnh upload thì lưu vào thư mục public/uploads/products
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image_url'] = 'uploads/products/'.$imageName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    // Xem chi tiết sản phẩm (admin)
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Form sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'quantity'       => 'required|integer|min:0',
            'price'          => 'required|numeric|min:0',
            'frame_material' => 'nullable|string|max:255',
            'lens_color'     => 'nullable|string|max:255',
            'lens_material'  => 'nullable|string|max:255',
            'brand'          => 'nullable|string|max:255',
            'weight'         => 'nullable|numeric|min:0',
            'category_id'    => 'required|exists:categories,id',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Nếu có ảnh mới thì cập nhật
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image_url'] = 'uploads/products/'.$imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    // Xóa sản phẩm
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    // Hiển thị chi tiết sản phẩm ngoài trang thường (cho user)
    public function show_normal(Product $product)
    {
        return view('user.products.show', compact('product'));
    }
}
