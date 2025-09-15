{{-- resources/views/admin/reports/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Báo cáo')

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-bar-chart-line"></i> Báo cáo Thống kê
        </h1>
        <p class="text-muted">Tổng quan hoạt động kinh doanh: đơn hàng, khách hàng và doanh thu.</p>
    </div>

    {{-- Thống kê nhanh --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100 text-center">
                <div class="card-body py-4">
                    <i class="bi bi-bag-check-fill text-success display-5"></i>
                    <h4 class="mt-3">Tổng số đơn hàng</h4>
                    <h2 class="fw-bold text-dark">{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100 text-center">
                <div class="card-body py-4">
                    <i class="bi bi-people-fill text-primary display-5"></i>
                    <h4 class="mt-3">Tổng số khách hàng</h4>
                    <h2 class="fw-bold text-dark">{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Doanh thu theo danh mục --}}
    <div class="mb-5">
        <h3 class="fw-bold text-secondary mb-3">📦 Doanh thu theo từng danh mục</h3>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Danh mục</th>
                            <th>Tổng doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryRevenue as $revenue)
                        <tr>
                            <td>{{ $revenue->category_id }}</td>
                            <td class="fw-bold text-success">{{ number_format($revenue->total_revenue, 0) }} VND</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Doanh thu theo ngày --}}
    <div class="mb-5">
        <h3 class="fw-bold text-secondary mb-3">📅 Doanh thu theo ngày</h3>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ngày</th>
                            <th>Tổng doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByDate as $revenue)
                        <tr>
                            <td>{{ $revenue->date }}</td>
                            <td class="fw-bold text-success">{{ number_format($revenue->total_revenue, 0) }} VND</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Doanh thu theo tháng --}}
    <div class="mb-5">
        <h3 class="fw-bold text-secondary mb-3">📊 Doanh thu theo tháng</h3>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tháng</th>
                            <th>Tổng doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByMonth as $revenue)
                        <tr>
                            <td>{{ $revenue->month }}</td>
                            <td class="fw-bold text-success">{{ number_format($revenue->total_revenue, 0) }} VND</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Doanh thu theo năm --}}
    <div class="mb-5">
        <h3 class="fw-bold text-secondary mb-3">📈 Doanh thu theo năm</h3>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Năm</th>
                            <th>Tổng doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByYear as $revenue)
                        <tr>
                            <td>{{ $revenue->year }}</td>
                            <td class="fw-bold text-success">{{ number_format($revenue->total_revenue, 0) }} VND</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
