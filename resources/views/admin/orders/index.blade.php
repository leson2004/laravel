@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">📦 Quản lý Đơn hàng</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>👤 Người dùng</th>
                        <th>💰 Tổng tiền</th>
                        <th>📌 Trạng thái</th>
                        <th>💳 Phương thức</th>
                        <th>⚙️ Hành động</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td class="text-danger fw-bold">
                            {{ number_format($order->total_price ?? 0, 0) }} VND
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🕒 Chờ thanh toán</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⏳ Đang xử lý</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>✅ Đã thanh toán</option>
                                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>❌ Thất bại</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            @if($order->payment_method == 'cod')
                                <span class="badge bg-info">💵 COD</span>
                            @elseif($order->payment_method == 'momo')
                                <span class="badge bg-warning text-dark">📱 MoMo</span>
                            @else
                                <span class="badge bg-secondary">Khác</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                🔍 Xem
                            </a>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" 
                               class="btn btn-sm btn-outline-warning">
                                ✏️ Sửa
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Bạn chắc chắn muốn xóa đơn hàng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    🗑 Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Nếu không có đơn hàng --}}
            @if($orders->count() == 0)
                <p class="text-muted text-center">⚠️ Chưa có đơn hàng nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection
