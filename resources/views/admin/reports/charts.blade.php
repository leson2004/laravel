@extends('layouts.admin')
@section('content')
<style>
.chart-wrap { min-height: 360px; }
.chart-wrap canvas { width: 100% !important; height: 360px !important; }
</style>

{{-- Đổi container-fluid -> container để giống trang users --}}
<div class="container my-4">

    <h2 class="mb-4">📊 Report Charts</h2>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Doanh thu theo danh mục</div>
                <div class="card-body chart-wrap"><canvas id="categoryRevenueChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Doanh thu theo ngày (30 ngày)</div>
                <div class="card-body chart-wrap"><canvas id="revenueByDateChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Doanh thu theo tháng (12 tháng)</div>
                <div class="card-body chart-wrap"><canvas id="revenueByMonthChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Doanh thu theo năm</div>
                <div class="card-body chart-wrap"><canvas id="revenueByYearChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">Doanh thu theo phương thức thanh toán</div>
                <div class="card-body chart-wrap"><canvas id="revenueByPaymentMethodChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
// Lấy mảng từ Controller (fallback rỗng để không lỗi)
const catLabels = @json($catLabels ?? []);
const catRevenue = (@json($catRevenue ?? []) || []).map(Number);
const revDateLabels = @json($revDateLabels ?? []);
const revDateData = (@json($revDateData ?? []) || []).map(Number);
const revMonthLabels = @json($revMonthLabels ?? []);
const revMonthData = (@json($revMonthData ?? []) || []).map(Number);

const revYearLabels = @json($revYearLabels ?? []);
const revYearData = (@json($revYearData ?? []) || []).map(Number);
const payLabels = @json($paymentMethodLabels ?? []);
const payRevenue = (@json($paymentMethodRevenue ?? []) || []).map(Number);
const mk = (el, type, labels, data, label, opts = {}) => new Chart(el, {
type, data: { labels, datasets: [{ label, data }] },
options: Object.assign({ responsive:true, maintainAspectRatio:false, scales:
(type==='pie'?'':{y:{beginAtZero:true}}) }, opts)
});
mk(document.getElementById('categoryRevenueChart'), 'bar', catLabels, catRevenue, 'Doanh thu (VNĐ)');
mk(document.getElementById('revenueByDateChart'), 'line', revDateLabels, revDateData, 'Doanh thu (VNĐ)',
{elements:{line:{tension:0.3}}, datasets:{fill:true}});
mk(document.getElementById('revenueByMonthChart'), 'bar', revMonthLabels, revMonthData, 'Doanh thu (VNĐ)');
mk(document.getElementById('revenueByYearChart'), 'bar', revYearLabels, revYearData, 'Doanh thu (VNĐ)');
new Chart(document.getElementById('revenueByPaymentMethodChart'), {
type:'pie', data:{ labels: payLabels, datasets:[{ label:'Doanh thu (VNĐ)', data: payRevenue }] }, options:{
responsive:true, maintainAspectRatio:false }
});
});
</script>
@endsection