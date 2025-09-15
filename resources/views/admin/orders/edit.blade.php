@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3 text-warning">✏️ Chỉnh sửa Đơn hàng #{{ $order->id }}</h2>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="card p-4 shadow">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên người nhận</label>
            <input type="text" name="name" class="form-control" value="{{ $order->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ $order->address }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ $order->phone }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⏳ Đang xử lý</option>
                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>✅ Đã thanh toán</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Đã hủy</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Phương thức thanh toán</label>
            <select name="payment_method" class="form-select">
                <option value="cod" {{ $order->payment_method == 'cod' ? 'selected' : '' }}>💵 COD</option>
                <option value="momo" {{ $order->payment_method == 'momo' ? 'selected' : '' }}>📱 MoMo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">💾 Lưu thay đổi</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">⬅ Hủy</a>
    </form>
</div>
@endsection
