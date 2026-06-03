<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Engineer;
use App\Models\InvoiceReturn;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Task;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function orderReportIndex()
    {
        $orders = Order::all();
        $clients = Client::all();
        // TOTALS
        $totalSales = $orders->sum('total_price');

        // PROFIT (example)
        $totalProfit = $orders->sum(function ($order) {
            return $order->profit; // accessor OR calculated value
        });
        return view('admin.reports.order_report', compact('orders', 'clients', 'totalSales', 'totalProfit'));
    }

    public function orderReport(Request $request)
    {
        $query = Order::with(['client', 'products']);

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->latest()->get();

        $totalSales = $orders->sum('total_price');

        $totalProfit = $orders->sum(function ($order) {
            return $order->profit;
        });

        $clients = Client::all();

        return view('admin.reports.order_report', compact(
            'orders',
            'clients',
            'totalSales',
            'totalProfit'
        ));
    }

    public function PurchasesReport(Request $request)
    {
        $query = Purchase::with(['supplier', 'purchaseDetails']);
        $suppliers = Supplier::all();

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $purchases = $query->latest()->get();

        $totalPurchasesPrice = $purchases->sum('total_price');

        return view('admin.reports.purchase_report', compact(
            'purchases',
            'suppliers',
            'totalPurchasesPrice',
        ));
    }

    public function returnReportIndex(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        $query = InvoiceReturn::query();

        // فلترة بالنوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فلترة بالعميل / المورد
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        // فلترة بالتاريخ
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $returns = $query->latest()->get();

        // تقسيم حسب النوع
        $clientReturns = $returns->where('type', 'client');
        $supplierReturns = $returns->where('type', 'supplier');

        $totalSales = $returns->sum('total_price');
        $returnsCount = $returns->count();

        return view('admin.reports.return_report', compact(
            'clients',
            'suppliers',
            'returns',
            'clientReturns',
            'supplierReturns',
            'totalSales',
            'returnsCount'
        ));
    }

    public function TaskReport(Request $request)
    {
        $engineers = Engineer::all();

        $query = Task::query();

        if ($request->filled('engineer_id')) {
            $query->where('engineer_id', $request->engineer_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $tasks = $query->latest()->get();

        $totalSales = $tasks->sum('cost');
        $profit = $tasks->where('status', 'completed')->sum('profit');

        return view('admin.reports.task_report', compact(
            'tasks',
            'engineers',
            'totalSales',
            'profit'
        ));
    }

    public function generalReport(Request $request)
    {
        $taskQuery   = Task::query();
        $orderQuery  = Order::query();
        $returnQuery = InvoiceReturn::query();
        $purchaseQuery = Purchase::query();

        $fromDate = $request->from_date;
        $toDate   = $request->to_date;

        if ($request->filled('from_date')) {
            $taskQuery->whereDate('created_at', '>=', $fromDate);
            $orderQuery->whereDate('created_at', '>=', $fromDate);
            $returnQuery->whereDate('created_at', '>=', $fromDate);
            $purchaseQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($request->filled('to_date')) {
            $taskQuery->whereDate('created_at', '<=', $toDate);
            $orderQuery->whereDate('created_at', '<=', $toDate);
            $returnQuery->whereDate('created_at', '<=', $toDate);
            $purchaseQuery->whereDate('created_at', '<=', $toDate);
        }

        // ── Totals ──────────────────────────────────────────────────
        $tasksTotal     = (clone $taskQuery)->where('status', 'completed')->sum('cost');
        $ordersTotal    = (clone $orderQuery)->sum('total_price');
        $purchasesTotal = (clone $purchaseQuery)->sum('total_price');
        $returnsTotal   = (clone $returnQuery)->sum('total_price');
        $totalSales     = $tasksTotal + $ordersTotal;
        $profit         = $totalSales - ($purchasesTotal + $returnsTotal);

        // ── Orders count & tasks count (for donut) ──────────────────
        $ordersCount = (clone $orderQuery)->count();
        $tasksCount  = (clone $taskQuery)->count();

        // Tasks status distribution
        $tasksPending    = Task::when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
                               ->when($toDate,   fn($q) => $q->whereDate('created_at', '<=', $toDate))
                               ->where('status', 'new')->count(); // 'new' represents pending/new tasks in this app
        $tasksInProgress = 0; // 'in_progress' is not a database state for tasks
        $tasksCompleted  = Task::when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
                               ->when($toDate,   fn($q) => $q->whereDate('created_at', '<=', $toDate))
                               ->where('status', 'completed')->count();
        $tasksCancelled  = Task::when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
                               ->when($toDate,   fn($q) => $q->whereDate('created_at', '<=', $toDate))
                               ->where('status', 'cancelled')->count();

        // Orders payment status distribution
        $ordersPaid   = Order::when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
                             ->when($toDate,   fn($q) => $q->whereDate('created_at', '<=', $toDate))
                             ->count(); // all orders are considered completed/paid sales
        $ordersUnpaid = 0;

        // ── Monthly trend (last 7 months) ───────────────────────────
        $months       = [];
        $monthLabels  = [];
        $monthOrders  = [];
        $monthTasks   = [];
        $monthPurchases = [];

        $arabicMonths = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس',    4 => 'أبريل',
            5 => 'مايو',  6 => 'يونيو',  7 => 'يوليو',   8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر',
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $y = $date->year;
            $m = $date->month;
            $monthLabels[]    = $arabicMonths[$m];
            $monthOrders[]    = Order::whereYear('created_at', $y)->whereMonth('created_at', $m)->sum('total_price');
            $monthTasks[]     = Task::whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'completed')->sum('cost');
            $monthPurchases[] = Purchase::whereYear('created_at', $y)->whereMonth('created_at', $m)->sum('total_price');
        }

        return view('admin.reports.general_report', compact(
            'tasksTotal', 'ordersTotal', 'purchasesTotal', 'returnsTotal',
            'totalSales', 'profit',
            'ordersCount', 'tasksCount',
            'tasksPending', 'tasksInProgress', 'tasksCompleted', 'tasksCancelled',
            'ordersPaid', 'ordersUnpaid',
            'monthLabels', 'monthOrders', 'monthTasks', 'monthPurchases'
        ));
    }


}



