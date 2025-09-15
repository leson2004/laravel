<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController ;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
//use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ReportController ;
use App\Http\Controllers\User\OrderController as OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;


use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
// Xác thực và phân quyền

// Route đăng ký người dùng
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Route đăng nhập người dùng
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Route đăng xuất
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Trang chủ welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Đăng ký và đăng nhập người dùng
// Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [AuthController::class, 'register']);

// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// ADMIN (chỉ admin mới truy cập được)
// ============================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);

        // Quản lý đơn hàng (CRUD + cập nhật trạng thái)
        Route::resource('orders', AdminOrderController::class);
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
              ->name('orders.updateStatus');

        // Báo cáo
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        //qly user 
        Route::resource('users', AdminUserController::class);
        // chart 
        Route::get('/reports/charts', [ReportController::class, 'charts'])->name('reports.charts');
    });

// ============================
// Route cho người dùng bình thường
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
});
// Route để thêm sản phẩm vào giỏ hàng
Route::middleware(['auth'])->post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

// Route để hiển thị giỏ hàng
Route::middleware(['auth'])->get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

// Route để xoá sản phẩm khỏi giỏ hàng
Route::middleware(['auth'])->delete('/cart/remove/{product}', [CartController::class, 'remove'])
    ->name('cart.remove');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
//
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
// Hiện thị thông báo xác thực email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Xử lý link xác nhận (từ email)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('welcome'); // Redirect về trang chủ
})->middleware(['auth', 'signed'])->name('verification.verify');

// Gửi lại email xác nhận
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {//bỏ verifi
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/orders', [CartController::class, 'index'])->name('orders.index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
});
// Thanh toán (OrderController xử lý cả COD & MoMo)
Route::get('/payment', [OrderController::class, 'index'])->name('payment.index');
Route::post('/payment/process', [OrderController::class, 'processPayment'])->name('payment.process');
// Thanh toán lại MoMo cho một đơn đã tạo
Route::get('/orders/{order}/pay/momo', [OrderController::class, 'payAgain'])->name('orders.momo.pay');
// Tạo request thanh toán MoMo (chưa chắc bạn có dùng trực tiếp)
Route::post('/payment/momo', [OrderController::class, 'momo_payment'])->name('payment.momo');
// Callback: user được MoMo redirect về sau khi thanh toán
Route::get('/payment/momo/callback', [OrderController::class, 'callback'])->name('payment.momo.callback');
// IPN: MoMo gọi server-to-server → cập nhật trạng thái đơn
Route::post('/payment/momo/ipn', [OrderController::class, 'ipn'])->name('payment.momo.ipn');
// Lịch sử đơn hàng và xem chi tiết
Route::get('/orders', [OrderController::class, 'orderHistory'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
//
Route::prefix('payment')->name('user.payment.')->middleware('auth')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index'); // GET /payment
    Route::post('/process', [OrderController::class, 'processPayment'])->name('process'); // POST /payment/process
    Route::get('/momo/callback', [OrderController::class, 'callback'])->name('momo.callback'); 
    Route::post('/momo/ipn', [OrderController::class, 'ipn'])->name('momo.ipn'); 
});
//
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');   // hiển thị form thanh toán
    Route::post('/process', [OrderController::class, 'processPayment'])->name('process'); // xử lý thanh toán
});
//
Route::prefix('user')->name('user.')->group(function () {
    // Route::get('/payment', [OrderController::class, 'paymentIndex'])->name('payment.index'); 
    // Route::post('/payment/process', [OrderController::class, 'processPayment'])->name('payment.process');
     // Thanh toán
    Route::get('/payment', [OrderController::class, 'index'])->name('payment.index');
    Route::post('/payment/process', [OrderController::class, 'processPayment'])->name('payment.process');

    // Lịch sử đơn hàng
    Route::get('/orders', [OrderController::class, 'orderHistory'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});