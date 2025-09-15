@extends('layouts.user')
@section('content')
<h2 class="mb-4">📦 Lịch sử đơn hàng của bạn</h2>
@forelse($orders as $order)
<div class="card mb-3 shadow-sm">
<div class="card-header d-flex justify-content-between align-items-center">
<div>
<strong>🧾 Mã đơn hàng #{{ $order->id }}</strong> <br>
<small class="text-muted">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</small>
</div>
<div class="text-end">
<span class="badge
@if ($order->status == 'đang xử lý') bg-warning text-dark
@elseif ($order->status == 'đang giao') bg-primary
@elseif ($order->status == 'đã giao') bg-success
@elseif ($order->status == 'đã hủy') bg-danger
@elseif ($order->status == 'đã thanh toán (MoMo)') bg-success
@elseif ($order->status == 'thanh toán MoMo không thành công') bg-danger
@else bg-secondary
@endif">

{{ ucfirst($order->status) }}
</span><br>
<button class="btn btn-sm btn-outline-primary mt-2" type="button"

data-bs-toggle="collapse"
data-bs-target="#orderDetail{{ $order->id }}">
🔍 Xem chi tiết
</button>
{{-- ✅ Chỉ hiện khi đơn có trạng thái "thanh toán MoMo không thành công" --}}
@if($order->status === 'thanh toán MoMo không thành công')
<a href="{{ route('user.orders.momo.pay', $order) }}"
class="btn btn-sm btn-success mt-2">
💳 Thanh toán lại MoMo
</a>
@endif
</div>
</div>
<div class="card-body">
<p><strong>👤 Họ tên:</strong> {{ $order->name }}</p>
<p><strong>📞 SĐT:</strong> {{ $order->phone }}</p>
<p><strong>📍 Địa chỉ:</strong> {{ $order->address }}</p>
<p><strong>💰 Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} đ</p>
</div>
<div class="collapse" id="orderDetail{{ $order->id }}">
<div class="card-body border-top bg-light">
<h6>🛒 Danh sách sản phẩm:</h6>
<table class="table table-sm table-bordered mt-2">
<thead class="table-light">
<tr>
<th>Sản phẩm</th>

<th>Số lượng</th>
<th>Đơn giá</th>
<th>Thành tiền</th>
</tr>
</thead>
<tbody>
@foreach($order->items as $item)
<tr>
<td>{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
<td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
@empty
<div class="alert alert-info">
Bạn chưa có đơn hàng nào.
</div>
@endforelse
@endsection