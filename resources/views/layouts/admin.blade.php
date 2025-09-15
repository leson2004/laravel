<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background: #212529;
            color: #fff;
            padding: 20px 15px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }
        .sidebar h4 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            color: #ffc107;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .sidebar a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .sidebar a:hover {
            background: #343a40;
            color: #fff;
        }
        .content {
            margin-left: 250px; /* chừa chỗ sidebar */
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto; /* nội dung cuộn được */
            height: 100vh;
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4><i class="fas fa-cogs"></i> Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Products</a>
        <a href="{{ route('admin.categories.index') }}"><i class="fas fa-tags"></i> Categories</a>
        <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Orders</a>
        <a href="{{ route('admin.reports.index') }}"><i class="fas fa-file-alt"></i> Reports</a>
        <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Users</a>
        <a href="{{ route('admin.reports.charts') }}"><i class="fas fa-chart-line"></i> Analytics</a>
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
