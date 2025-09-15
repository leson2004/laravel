@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3 text-primary">🔍 Chi tiết Đơn hàng #{{ $order->id }}</h2>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>👤 Người dùng:</strong> {{ $order->user->name }}</p>
            <p><strong>📞 SĐT:</strong> {{ $order->phone }}</p>
            <p><strong>📍 Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>💳 Phương thức:</strong> {{ strtoupper($order->payment_method) }}</p>
            <p><strong>📌 Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>🕒 Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <h4>📦 Sản phẩm trong đơn</h4>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ number_format($item->price, 0) }} VND</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 0) }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="text-end mt-3">💰 Tổng cộng: 
        <span class="text-danger fw-bold">
            {{ number_format($order->total_price, 0) }} VND
        </span>
    </h5>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">⬅ Quay lại</a>
</div>
@endsection
