<?php

namespace App\Http\Services;

use App\Models\Task;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Engineer;

class ReportGeneratorService
{
    /**
     * تقرير الصيانات
     */
    public function getTasksReport($fromDate, $toDate)
    {
        $tasks = Task::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->with(['client', 'engineer'])
            ->get();

        $totalCost = $tasks->sum('cost');
        $totalPayed = $tasks->sum('payed');

        return [
            'tasks' => $tasks,
            'total_cost' => $totalCost,
            'total_payed' => $totalPayed,
            'total_remaining' => $totalCost - $totalPayed,
            'count' => $tasks->count()
        ];
    }

    /**
     * تقرير الأوردرات
     */
    public function getOrdersReport($fromDate, $toDate)
    {
        $orders = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->with(['client', 'orderDetails'])
            ->get();

        $totalPrice = $orders->sum('total_price');
        $totalPayed = $orders->sum('payed');

        return [
            'orders' => $orders,
            'total_price' => $totalPrice,
            'total_payed' => $totalPayed,
            'total_remaining' => $totalPrice - $totalPayed,
            'count' => $orders->count()
        ];
    }

    /**
     * تقرير المشتريات
     */
    public function getPurchasesReport($fromDate, $toDate)
    {
        $purchases = Purchase::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->with(['supplier', 'purchaseDetails'])
            ->get();

        $totalPrice = $purchases->sum('total_price');
        $totalPayed = $purchases->sum('payed');

        return [
            'purchases' => $purchases,
            'total_price' => $totalPrice,
            'total_payed' => $totalPayed,
            'total_remaining' => $totalPrice - $totalPayed,
            'count' => $purchases->count()
        ];
    }

    /**
     * تقرير الأعمال اليومي
     */
    public function getDailyReport($date)
    {
        $tasks = Task::whereDate('created_at', $date)->get();
        $orders = Order::whereDate('created_at', $date)->get();
        $purchases = Purchase::whereDate('created_at', $date)->get();

        return [
            'date' => $date,
            'tasks_count' => $tasks->count(),
            'tasks_total' => $tasks->sum('cost'),
            'orders_count' => $orders->count(),
            'orders_total' => $orders->sum('total_price'),
            'purchases_count' => $purchases->count(),
            'purchases_total' => $purchases->sum('total_price')
        ];
    }

    /**
     * تقرير العملاء
     */
    public function getClientsReport()
    {
        $clients = Client::with('orders')->get();

        return $clients->map(function ($client) {
            $totalOrders = $client->orders->sum('total_price');
            $totalPayed = $client->orders->sum('payed');

            return [
                'client' => $client,
                'total_orders' => $totalOrders,
                'total_payed' => $totalPayed,
                'remaining' => $totalOrders - $totalPayed,
                'orders_count' => $client->orders->count()
            ];
        });
    }

    /**
     * تقرير الموردين
     */
    public function getSuppliersReport()
    {
        $suppliers = Supplier::with('purchases')->get();

        return $suppliers->map(function ($supplier) {
            $totalPurchases = $supplier->purchases->sum('total_price');
            $totalPayed = $supplier->purchases->sum('payed');

            return [
                'supplier' => $supplier,
                'total_purchases' => $totalPurchases,
                'total_payed' => $totalPayed,
                'remaining' => $totalPurchases - $totalPayed,
                'purchases_count' => $supplier->purchases->count()
            ];
        });
    }

    /**
     * تقرير المهندسين
     */
    public function getEngineersReport($fromDate = null, $toDate = null)
    {
        $engineers = Engineer::with('tasks')->get();

        return $engineers->map(function ($engineer) use ($fromDate, $toDate) {
            $tasks = $engineer->tasks;

            if ($fromDate && $toDate) {
                $tasks = $tasks->filter(function ($task) use ($fromDate, $toDate) {
                    return $task->created_at->between($fromDate, $toDate);
                });
            }

            return [
                'engineer' => $engineer,
                'tasks_count' => $tasks->count(),
                'total_cost' => $tasks->sum('cost'),
                'total_payed' => $tasks->sum('payed')
            ];
        });
    }
}
