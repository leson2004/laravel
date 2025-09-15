<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('user.cart.index', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "id"       => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "category" => $product->category->name
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('user.cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }
    public function update(Request $request, $id)
    {
        if ($request->has('quantity') && $request->quantity > 0) {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity; // Cập nhật số lượng
            session()->put('cart', $cart);

            return redirect()->route('user.cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
        }
    }
        return redirect()->route('user.cart.index')->with('error', 'Cập nhật thất bại!');
    }
    // Xóa sản phẩm khỏi giỏ hàng
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('user.cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
}

