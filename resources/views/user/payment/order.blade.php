@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-primary">Danh sách đơn hàng của bạn</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    @if($orders->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table align-middle table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên người nhận</th>
                            <th>Địa chỉ</th>
                            <th>Điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="fw-bold">{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->phone }}</td>
                                <td class="fw-semibold text-success">
                                    {{ number_format($order->total_price) }} VNĐ
                                </td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Hoàn tất</span>
                                    @elseif($order->status == 'failed')
                                        <span class="badge bg-danger">Thất bại</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('user.orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-outline-primary me-1">
                                        Xem
                                    </a>

                                    {{-- Nếu MoMo thất bại → cho thanh toán lại --}}
                                    @if($order->status == 'failed')
                                        <a href="{{ route('orders.momo.pay', $order->id) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            Thanh toán lại
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center p-4">
            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                Mua ngay
            </a>
        </div>
    @endif
</div>
@endsection
