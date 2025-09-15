<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WelcomeController extends Controller
{
    // Hàm hiển thị trang welcome
    public function index()
    {
          $products = Product::with('category')->paginate(6);
        // Truyền biến $products xuống view
        return view('welcome', compact('products'));
    }
}
