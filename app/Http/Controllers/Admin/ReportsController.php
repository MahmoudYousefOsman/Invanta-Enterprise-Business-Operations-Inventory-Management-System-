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
        $taskQuery = Task::query();
        $orderQuery = Order::query();
        $returnQuery = InvoiceReturn::query();
        $purchaseQuery = Purchase::query();

        if ($request->filled('from_date')) {
            $taskQuery->whereDate('created_at', '>=', $request->from_date);
            $orderQuery->whereDate('created_at', '>=', $request->from_date);
            $returnQuery->whereDate('created_at', '>=', $request->from_date);
            $purchaseQuery->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $taskQuery->whereDate('created_at', '<=', $request->to_date);
            $orderQuery->whereDate('created_at', '<=', $request->to_date);
            $returnQuery->whereDate('created_at', '<=', $request->to_date);
            $purchaseQuery->whereDate('created_at', '<=', $request->to_date);
        }

        // Totals
        $tasksTotal = $taskQuery->where('status', 'completed')->sum('cost');
        $ordersTotal = $orderQuery->sum('total_price');
        $purchasesTotal = $purchaseQuery->sum('total_price');
        $returnsTotal = $returnQuery->sum('total_price');

        $totalSales = $tasksTotal + $ordersTotal;
        $profit = $totalSales - ($purchasesTotal + $returnsTotal);

        return view('admin.reports.general_report', compact(
            'tasksTotal',
            'ordersTotal',
            'purchasesTotal',
            'returnsTotal',
            'totalSales',
            'profit'
        ));
    }


}



