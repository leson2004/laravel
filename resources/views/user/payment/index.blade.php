@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">💳 Thanh toán đơn hàng</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Nếu giỏ hàng có sản phẩm --}}
    @if(count($cart) > 0)
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🛒 Giỏ hàng của bạn</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price']) }} VNĐ</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price'] * $item['quantity']) }} VNĐ</td>
                            </tr>
                            @php $total += $item['price'] * $item['quantity']; @endphp
                        @endforeach
                    </tbody>
                </table>

                <h4 class="text-end mt-3">
                    Tổng cộng: <span class="text-danger fw-bold">{{ number_format($total) }} VNĐ</span>
                </h4>
            </div>
        </div>

        {{-- Form nhập thông tin --}}
        <div class="card mt-4 shadow-lg">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">📦 Thông tin giao hàng</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.payment.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total_price" value="{{ $total }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Họ tên người nhận</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ giao hàng</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input type="radio" id="cod" name="payment_method" value="cod" class="form-check-input" checked>
                                <label class="form-check-label" for="cod">💵 COD (Thanh toán khi nhận hàng)</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="momo" name="payment_method" value="momo" class="form-check-input">
                                <label class="form-check-label" for="momo">📱 Ví MoMo</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-success w-100">
                        ✅ Xác nhận đặt hàng
                    </button>
                </form>
            </div>
        </div>
    @else
        <p class="text-muted text-center mt-4">Không có sản phẩm nào trong giỏ hàng.</p>
        <div class="text-center">
            <a href="{{ route('products.index') }}" class="btn btn-primary">🛒 Mua ngay</a>
        </div>
    @endif
</div>
@endsection
