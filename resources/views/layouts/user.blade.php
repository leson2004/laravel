<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyShop</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    .navbar {
      position: sticky;
      top: 0;
      z-index: 1030;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    body {
      padding-top: 70px;
      background-color: #f8f9fa;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.3rem;
      color: #0d6efd !important;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .navbar-nav .nav-link {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 1rem;
    }

    .container-content {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-white">
    <div class="container">
      <a class="navbar-brand" href="{{ route('welcome') }}">
        <i class="bi bi-shop"></i> MyShop
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Bên trái -->
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('welcome') }}"><i class="bi bi-house"></i> Trang chủ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.cart.index') }}"><i class="bi bi-cart"></i> Giỏ hàng</a>
          </li>
        </ul>

        <!-- Bên phải -->
        <ul class="navbar-nav">
          @auth
            @if(Auth::user()->role === 'user')
              <li class="nav-item">
                <a class="nav-link" href="{{ route('user.orders.index') }}"><i class="bi bi-box-seam"></i> Lịch sử đơn</a>
              </li>
            @endif
            <li class="nav-item">
              <span class="nav-link"><i class="bi bi-person-circle text-primary"></i> {{ Auth::user()->name }}</span>
            </li>
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link p-0">
                  <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </button>
              </form>
            </li>
          @endauth

          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Đăng ký</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</a>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <!-- Nội dung -->
  <div class="container mt-4">
    <div class="container-content">
      @yield('content')
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
