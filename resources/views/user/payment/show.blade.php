@extends('layouts.user')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-primary">Chi tiết đơn hàng #{{ $order->id }}</h2>

    {{-- Thông tin người nhận --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white">
            Thông tin người nhận
        </div>
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ $order->name }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p>
                <strong>Trạng thái:</strong> 
                @if($order->status == 'pending')
                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                @elseif($order->status == 'completed')
                    <span class="badge bg-success">Hoàn tất</span>
                @elseif($order->status == 'failed')
                    <span class="badge bg-danger">Thất bại</span>
                @else
                    <span class="badge bg-secondary">{{ $order->status }}</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            Danh sách sản phẩm
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="fw-semibold text-success">
                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Tổng đơn hàng:</th>
                        <th class="fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }} đ</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Quay lại --}}
    <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary mt-3">
        Quay lại lịch sử đơn hàng
    </a>
</div>
@endsection
