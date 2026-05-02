<?php

namespace App\Http\Services;

use App\Models\Task;
use App\Models\Order;
use App\Models\Product;

class CalculateProfitService
{
    /**
     * حساب الربح للصيانة
     */
    public function calculateTaskProfit(Task $task)
    {
        $totalProductCost = 0;

        foreach ($task->products as $product) {
            $productPurchasePrice = $product->purchase_price;
            $quantity = $product->pivot->quantity;
            $totalProductCost += $productPurchasePrice * $quantity;
        }

        $commission = ($task->cost - $totalProductCost) * ($task->commission / 100);
        $profit = $task->cost - $totalProductCost - $commission;

        return [
            'total_cost' => $task->cost,
            'product_cost' => $totalProductCost,
            'commission' => $commission,
            'profit' => $profit,
            'commission_percentage' => $task->commission
        ];
    }

    /**
     * حساب الربح للأوردر
     */
    public function calculateOrderProfit(Order $order)
    {
        $totalProductCost = 0;
        $totalSellingPrice = 0;

        foreach ($order->orderDetails as $detail) {
            $product = $detail->product;
            $totalProductCost += $product->purchase_price * $detail->quantity;
            $totalSellingPrice += $detail->price * $detail->quantity;
        }

        $profit = $totalSellingPrice - $totalProductCost;

        return [
            'total_selling_price' => $totalSellingPrice,
            'total_product_cost' => $totalProductCost,
            'profit' => $profit,
            'profit_percentage' => $totalProductCost > 0 ? ($profit / $totalProductCost * 100) : 0
        ];
    }

    /**
     * حساب إجمالي الربح للفترة الزمنية
     */
    public function calculatePeriodProfit($fromDate, $toDate)
    {
        $tasks = Task::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->get();

        $orders = Order::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->get();

        $tasksProfit = 0;
        $ordersProfit = 0;

        foreach ($tasks as $task) {
            $profit = $this->calculateTaskProfit($task);
            $tasksProfit += $profit['profit'];
        }

        foreach ($orders as $order) {
            $profit = $this->calculateOrderProfit($order);
            $ordersProfit += $profit['profit'];
        }

        return [
            'tasks_profit' => $tasksProfit,
            'orders_profit' => $ordersProfit,
            'total_profit' => $tasksProfit + $ordersProfit
        ];
    }
}
