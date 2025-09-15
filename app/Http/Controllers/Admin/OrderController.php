<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Orders::with('user')->latest()->get(); // lấy thêm thông tin user
        return view('admin.orders.index', compact('orders'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,paid,failed',
        ]);

        $order = Orders::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.index')
                        ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    // ✅ Xem chi tiết đơn hàng
    public function show($id)
    {
        $order = Orders::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // ✅ Sửa đơn hàng (ví dụ chỉ sửa địa chỉ, số điện thoại…)
    public function edit($id)
    {
        $order = Orders::with('user')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    // ✅ Xử lý cập nhật đơn hàng (sau khi submit form edit)
    public function update(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        $request->validate([
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:15',
        ]);

        $order->update([
            'address' => $request->address,
            'phone'   => $request->phone,
        ]);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Cập nhật thông tin đơn hàng thành công!');
    }

    // ✅ Xóa đơn hàng
    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Xóa đơn hàng thành công!');
    }
}
