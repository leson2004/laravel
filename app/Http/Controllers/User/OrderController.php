<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\OrderItems;
use App\Models\Orders;

class OrderController extends Controller
{
// ==========================
// Đặt cấu hình thông số MoMo test
// ==========================
private $endpoint = 'https://test-payment.momo.vn/v2/gateway/api/create';
private $partnerCode = 'MOMOBKUN20180529';
private $accessKey = 'klm05TvNBzhg7h7j';
private $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
// giới hạn thao tác: nếu có sản phẩm => truyền đến trang checkout, nếu không có => ở lại giỏ hàng
public function index()
{
$cart = session('cart', []);
if (empty($cart)) {
return redirect()->route('user.cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
}
 $user = Auth::user(); // lấy thông tin user
    return view('user.payment.index', compact('cart', 'user'));
}
// nhận thao tác thanh toán từ form rồi điều hướng kết quả momo hay COD
public function processPayment(Request $request)
{
$request->validate([
'name' => 'required|string|max:100',
'address' => 'required|string|max:255',
'phone' => 'required|string|max:20',

'total_price' => 'required|numeric|min:0',
'payment_method' => 'required|in:cod,momo',
]);
$cart = session('cart', []);
if (empty($cart)) {
return redirect()->route('user.cart.index')

->with('error', 'Không thể thanh toán vì giỏ hàng trống.');

}
// Tính tổng tiền
$total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
// Tạo đơn
$order = Orders::create([
'user_id' => Auth::id(),
'name' => $request->name,
'address' => $request->address,
'phone' => $request->phone,
'total_price' => $total,
'status' => 'pending', // mặc định chờ thanh toán
// Nếu DB có cột payment_method/payment_status thì mở 2 dòng dưới:
'payment_method' => $request->payment_method,
// 'payment_status' => 'unpaid',
]);
// Lưu chi tiết đơn
foreach ($cart as $productId => $item) {
OrderItems::create([
'order_id' => $order->id,
'product_id' => $productId,
'quantity' => $item['quantity'],
'price' => $item['price'],
'payment_method' => $request->payment_method,
]);

}
// ✅ XÓA GIỎ HÀNG NGAY KHI NHẤN THANH TOÁN (kể cả MoMo chưa thành công)
session()->forget('cart');
// Rẽ nhánh phương thức
if ($request->payment_method === 'momo') {
// (tuỳ chọn) nếu muốn phản ánh trạng thái đang thanh toán:
$order->update([ 'status' => 'pending',
        'payment_method' => 'momo']);
return $this->redirectToMoMo($order);
}
// COD
$order->update([
    'status' => 'processing',
    'payment_method' => 'cod'
// Nếu có cột payment_status:
// 'payment_status' => 'unpaid',
]);
return redirect()->route('user.orders.index')

->with('success', 'Đặt hàng thành công! Thanh toán khi nhận hàng.');

}

/**
* Tạo giao dịch MoMo và chuyển hướng người dùng
*/
protected function redirectToMoMo(Orders $order)
{
$redirectUrl = route('user.payment.momo.callback');
$ipnUrl = route('user.payment.momo.ipn');
$orderId = time() . '_' . $order->id;
$requestId = uniqid();

$orderInfo = "Thanh toán đơn hàng #{$order->id}";
$amount = (string) max(1000, (int) $order->total_price); // test nên >= 1000
$extraData = ''; // có thể base64_encode(json_encode(...))
$requestType = 'payWithATM';
$rawHash = "accessKey={$this->accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}"
. "&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$this->partnerCode}"
. "&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
$signature = hash_hmac('sha256', $rawHash, $this->secretKey);
$payload = [
'partnerCode' => $this->partnerCode,
'partnerName' => "YourStore",
'storeId' => "Store_01",
'requestId' => $requestId,
'amount' => $amount,
'orderId' => $orderId,
'orderInfo' => $orderInfo,
'redirectUrl' => $redirectUrl,
'ipnUrl' => $ipnUrl,
'lang' => 'vi',
'extraData' => $extraData,
'requestType' => $requestType,
'signature' => $signature,
];
Log::info('MoMo request payload: ', $payload);
try {
$response = Http::withHeaders(['Content-Type' => 'application/json; charset=UTF-8'])
->withoutVerifying()
->post($this->endpoint, $payload);
if (!$response->successful()) {

Log::error('MoMo create payment failed', [
'status' => $response->status(),
'body' => $response->body(),
]);
return redirect()
->route('user.orders.index')
->with('error', 'Không thể kết nối MoMo (' . $response->status() . '). Vui lòng thử lại.');

}
$json = $response->json();
Log::info('MoMo response:', $json);
if (!empty($json['payUrl'])) {
$order->update([
'momo_request_id' => $requestId,
'momo_order_id' => $orderId,
]);
return redirect()->away($json['payUrl']);
}
// Không có payUrl → báo lỗi rõ
$msg = $json['message'] ?? 'MoMo không trả về payUrl.';
Log::error('MoMo payUrl missing', ['response' => $json]);
return redirect()
->route('user.orders.index')
->with('error', 'Không tạo được link thanh toán MoMo: ' . $msg);

} catch (\Exception $e) {
Log::error('MoMo request exception', ['error' => $e->getMessage()]);
return redirect()
->route('user.orders.index')
->with('error', 'Lỗi khi tạo thanh toán MoMo: ' . $e->getMessage());

}
}

/**
* Callback: người dùng được MoMo chuyển về sau thanh toán
*/
public function callback(Request $request)
{
$resultCode = $request->input('resultCode'); // 0 = success
// Có orderId thì lấy id thực từ "time_orderId"
$order = null;
if ($request->filled('orderId')) {
$parts = explode('_', $request->orderId);
$orderId = end($parts);
$order = Orders::find($orderId);
}
if ($resultCode === '0' || $resultCode === 0) {
// ✅ Thành công: xoá giỏ + cập nhật trạng thái đơn
session()->forget('cart');
if ($order) {
$order->update([
    'status' => 'paid',
    'payment_method' => 'momo' // 👈 đảm bảo không bị mặc định cod
    //'payment_status' => 'paid',
]);
}
return redirect()->route('user.orders.index')

->with('success', 'Thanh toán MoMo thành công!');

}
// ❌ Thất bại/hủy: giữ nguyên giỏ hàng để user thử lại
if ($order) {
$order->update(['status' => 'thanh toán MoMo không thành công']); // hoặc 'chờ thanh toán' tuỳ bạn
}
// Quay lại trang checkout để người dùng thử thanh toán lại
return redirect()->route('user.payment.index')

->with('error', 'Thanh toán MoMo thất bại hoặc bị hủy. Vui lòng thử lại.');

}

/**
* IPN: MoMo gọi ngầm (server-to-server) báo trạng thái
*/
public function ipn(Request $request)
{
Log::info('MoMo IPN payload:', $request->all());
// TODO: bạn nên xác thực chữ ký ở đây
// Ví dụ cập nhật trạng thái dựa vào orderId/resultCode:
if ($request->filled('orderId')) {
$parts = explode('_', $request->orderId);
$orderId = end($parts);
if ($order = Orders::find($orderId)) {
if ((string)($request->resultCode) === '0') {
$order->update(['status' => 'paid']);
} else {
$order->update(['status' => 'failed']);
}
}
}
return response()->json(['resultCode' => 0, 'message' => 'Received']);
}
// Cho phép user kéo lại đơn chưa thanh toán đi MoMo lần nữa
public function payAgain(Orders $order)
{
if ($order->user_id !== Auth::id()) {
abort(403, 'Bạn không có quyền thanh toán lại đơn này.');

}
if ($order->status === 'paid') {
return redirect()->route('user.orders.index')->with('info', 'Đơn này đã thanh toán.');
}
// Đưa về “chờ thanh toán” trước khi tạo giao dịch mới (tuỳ bạn)
$order->update(['status' => 'pending']);
// PHẢI return
return $this->redirectToMoMo($order);
}
// gọi lịch sử các đơn hàng theo người dùng
public function orderHistory()
{
$orders = Orders::where('user_id', Auth::id())
->with('items.product')
->orderByDesc('created_at')
->get();
return view('user.payment.order', compact('orders'));
}
// gọi chi tiết sản phẩm từng đơn hàng
public function show(Orders $order)
{
if ($order->user_id !== Auth::id()) {
abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
}
$order->load('items.product');
return view('user.payment.show', compact('order'));
}
}