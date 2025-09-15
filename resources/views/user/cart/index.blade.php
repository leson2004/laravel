@extends('layouts.user')
@section('content')

<div class="container mt-4">
<h2>🛒 Giỏ hàng của bạn</h2>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-success">{{ session('error') }}</div>
@endif
@if(count($cart) > 0)
<table class="table table-bordered mt-3">
<thead>
<tr>
<th>Sản phẩm</th>
<th>Giá</th>
<th>Số lượng</th>
<th>Tổng</th>
<th>Thao tác</th>
</tr>
</thead>
<tbody>
@php $total = 0; @endphp
@foreach($cart as $id => $item)
<tr>
<td>{{ $item['name'] }}</td>
<td>{{ number_format($item['price']) }} VNĐ</td>
<td>
{{-- Form cập nhật số lượng --}}

<form action="{{ route('cart.update', $id) }}" method="POST" class="form-
inline">

@csrf
<input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"

class="form-control form-control-sm w-50 d-inline">

<button type="submit" class="btn btn-sm btn-primary ml-1">Cập nhật</button>
</form>
</td>
<td>{{ number_format($item['price'] * $item['quantity']) }} VNĐ</td>
<td>
{{-- Xóa sản phẩm --}}
<form action="{{ route('cart.remove', $id) }}" method="POST">
@csrf
<button class="btn btn-sm btn-danger" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>

</form>
</td>
@php $total += $item['price'] * $item['quantity']; @endphp
</tr>
@endforeach
</tbody>
</table>
<h5 class="text-right">Tổng cộng: <strong>{{ number_format($total) }} VNĐ</strong></h5>
{{-- Nút xóa toàn bộ --}}
<form action="{{ route('cart.clear') }}" method="POST" class="text-right mt-3">
@csrf
<button class="btn btn-warning" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
🧹 Xóa toàn bộ giỏ hàng
</button>
</form>
{{-- Nút thanh toán --}}
<div class="text-end mt-2">
<a href="{{ route('payment.index') }}" class="btn btn-success d-block text-right mt-2">
💳 Thanh toán
</a>
</div>

@else
<p class="text-muted">Không có sản phẩm nào trong giỏ hàng.</p>
@endif
</div>
@endsection