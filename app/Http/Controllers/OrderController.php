<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của user
   public function processPayment(Request $request)
{
    $cart = session()->get('cart', []);
    if (count($cart) == 0) {
        return redirect()->route('cart.index')
            ->with('error', 'Giỏ hàng của bạn trống.');
    }

    // ✅ Tính tổng tiền lại để tránh gian lận
    $totalPrice = 0;
    foreach ($cart as $id => $details) {
        $product = Product::find($id);
        if (!$product || $product->quantity < $details['quantity']) {
            return redirect()->route('cart.index')
                ->with('error', 'Sản phẩm '.$details['name'].' không đủ hàng.');
        }
        $totalPrice += $details['quantity'] * $details['price'];
    }

    try {
        DB::beginTransaction();

        // ✅ Tạo đơn hàng
        $order = Orders::create([
            'user_id'        => Auth::id(),
            'total'          => $totalPrice,
            'status'         => 'processing',
            'payment_method' => $request->payment_method,
            'name'           => $request->name,
            'phone'          => $request->phone,
            'address'        => $request->address,
        ]);

        // ✅ Lưu item + trừ tồn kho
        foreach ($cart as $id => $details) {
            OrderItems::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $details['quantity'],
                'price'      => $details['price'],
            ]);

            $product = Product::find($id);
            $product->decrement('quantity', $details['quantity']);
        }

        DB::commit();

        // Xóa giỏ hàng sau khi đặt hàng
        session()->forget('cart');

        return redirect()->route('order.index')
            ->with('success', 'Đặt hàng thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Lỗi đặt hàng: ".$e->getMessage());
        return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra khi đặt hàng.');
    }
}
}