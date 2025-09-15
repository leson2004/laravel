@extends('layouts.user')
@section('content')

<div class="container mt-4">
    <h2><i class="bi bi-cart-check text-primary"></i> Giỏ hàng của bạn</h2>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    @if(count($cart) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th width="160">Số lượng</th>
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
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                           class="form-control form-control-sm me-2" style="width: 70px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ number_format($item['price'] * $item['quantity']) }} VNĐ</td>
                            <td>
                                {{-- Xóa sản phẩm --}}
                               <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa sản phẩm này?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>
                            @php $total += $item['price'] * $item['quantity']; @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tổng cộng --}}
        <div class="text-end mt-3">
            <h5>Tổng cộng: <strong class="text-danger">{{ number_format($total) }} VNĐ</strong></h5>
        </div>

        {{-- Nút xóa toàn bộ + Thanh toán --}}
        <div class="d-flex justify-content-end gap-2 mt-3">
            <form action="{{ route('cart.clear') }}" method="POST" class="text-right mt-3">
                @csrf
                @method('DELETE')
                <button class="btn btn-warning" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                    <i class="bi bi-trash3"></i>  Xóa toàn bộ giỏ hàng
                </button>
            </form>


            <a href="{{ route('payment.index') }}" class="btn btn-success">
                <i class="bi bi-credit-card"></i> Thanh toán
            </a>
        </div>

    @else
        <p class="text-muted mt-3">Không có sản phẩm nào trong giỏ hàng.</p>
    @endif
</div>
@endsection
