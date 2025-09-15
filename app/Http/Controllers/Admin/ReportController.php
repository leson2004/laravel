<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Thống kê tổng doanh thu theo từng danh mục
        $categoryRevenue = DB::table('order_items')
            ->select('products.category_id', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->groupBy('products.category_id')
            ->get();

        // Tổng số đơn hàng
        $totalOrders = Orders::count();

        // Tổng số khách hàng
        $totalCustomers = DB::table('users')->where('role', 'customer')->count();

        // Doanh thu theo ngày
        $revenueByDate = Orders::select(DB::raw('DATE(created_at) as date, SUM(total_price) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('date')
            ->get();

        // Doanh thu theo tháng
        $revenueByMonth = Orders::select(DB::raw('MONTH(created_at) as month, SUM(total_price) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('month')
            ->get();

        // Doanh thu theo năm
        $revenueByYear = Orders::select(DB::raw('YEAR(created_at) as year, SUM(total_price) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('year')
            ->get();

        return view('admin.reports.index', compact(
            'categoryRevenue',
            'totalOrders',
            'totalCustomers',
            'revenueByDate',
            'revenueByMonth',
            'revenueByYear'
        ));
    }
    public function charts()
{
    // Các trạng thái đơn hàng được tính vào doanh thu
    $paid = ['paid', 'đã đặt (COD)'];

    /* 1) Doanh thu theo danh mục */
    $byCat = DB::table('order_items')
        ->join('orders','order_items.order_id','=','orders.id')
        ->join('products','order_items.product_id','=','products.id')
        ->leftJoin('categories','products.category_id','=','categories.id')
        ->whereIn('orders.status',$paid)
        ->selectRaw('COALESCE(categories.name, CONCAT("Category #", products.category_id)) AS name')
        ->selectRaw('SUM(order_items.price * order_items.quantity) AS revenue')
        ->groupBy('name')
        ->orderByDesc('revenue')
        ->get();

    $catLabels = $byCat->pluck('name')->toArray();
    $catRevenue = $byCat->pluck('revenue')->map(fn($v)=>(float)$v)->toArray();

    /* 2) Doanh thu theo ngày (30 ngày gần nhất) */
    $startDay = Carbon::now()->subDays(29)->startOfDay();
    $endDay = Carbon::now()->endOfDay();

    $byDate = Orders::whereIn('status',$paid)
        ->whereBetween('created_at',[$startDay,$endDay])
        ->selectRaw('DATE(created_at) d, SUM(total_price) revenue')
        ->groupBy('d')->orderBy('d')->get()->keyBy('d');

    $revDateLabels = [];
    $revDateData = [];
    for ($i=0; $i<30; $i++) {
        $d = $startDay->copy()->addDays($i)->toDateString();
        $revDateLabels[] = $d;
        $revDateData[] = (float) ($byDate[$d]->revenue ?? 0);
    }

    /* 3) Doanh thu theo tháng (12 tháng gần nhất) */
    $startMonth = Carbon::now()->subMonths(11)->startOfMonth();
    $byMonth = Orders::whereIn('status',$paid)
        ->where('created_at','>=',$startMonth)
        ->selectRaw("DATE_FORMAT(created_at,'%Y-%m') ym, SUM(total_price) revenue")
        ->groupBy('ym')->orderBy('ym')->get()->keyBy('ym');

    $revMonthLabels = [];
    $revMonthData = [];
    for ($i=0; $i<12; $i++) {
        $m = $startMonth->copy()->addMonths($i);
        $key = $m->format('Y-m');
        $revMonthLabels[] = $m->format('m/Y');
        $revMonthData[] = (float) ($byMonth[$key]->revenue ?? 0);
    }

    /* 4) Doanh thu theo năm */
    $byYear = Orders::whereIn('status',$paid)
        ->selectRaw('YEAR(created_at) y, SUM(total_price) revenue')
        ->groupBy('y')->orderBy('y')->get();

    $revYearLabels = $byYear->pluck('y')->toArray();
    $revYearData = $byYear->pluck('revenue')->map(fn($v)=>(float)$v)->toArray();

    /* 5) Doanh thu theo phương thức thanh toán */
    $paymentMethodLabels = ['Paid (Online)', 'COD'];
    $paymentMethodRevenue = [
        (float) Orders::where('status','paid')->sum('total_price'),
        (float) Orders::where('status','đã đặt (COD)')->sum('total_price'),
    ];

    return view('admin.reports.charts', compact(
        'catLabels','catRevenue',
        'revDateLabels','revDateData',
        'revMonthLabels','revMonthData',
        'revYearLabels','revYearData',
        'paymentMethodLabels','paymentMethodRevenue'
    ));
}

}
