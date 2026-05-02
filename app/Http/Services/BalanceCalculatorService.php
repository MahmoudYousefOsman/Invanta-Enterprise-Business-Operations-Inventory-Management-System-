<?php

namespace App\Http\Services;

use App\Models\Client;
use App\Models\Supplier;
use App\Models\Task;
use App\Models\Order;
use App\Models\Purchase;

class BalanceCalculatorService
{
    /**
     * حساب المتبقي من الصيانة
     */
    public function getTaskRemaining(Task $task)
    {
        return $task->cost - $task->payed;
    }

    /**
     * حساب المتبقي من الأوردر
     */
    public function getOrderRemaining($order)
    {
        return $order->total_price - $order->payed;
    }

    /**
     * حساب المتبقي من المشتريات
     */
    public function getPurchaseRemaining($purchase)
    {
        return $purchase->total_price - $purchase->payed;
    }

    /**
     * إجمالي المتبقي على العملاء
     */
    public function getTotalClientDebt()
    {
        $orders = Order::all();
        $totalDebt = 0;

        foreach ($orders as $order) {
            $totalDebt += $this->getOrderRemaining($order);
        }

        return $totalDebt;
    }

    /**
     * إجمالي المتبقي على الموردين
     */
    public function getTotalSupplierDebt()
    {
        $purchases = Purchase::all();
        $totalDebt = 0;

        foreach ($purchases as $purchase) {
            $totalDebt += $this->getPurchaseRemaining($purchase);
        }

        return $totalDebt;
    }

    /**
     * حساب نسبة السداد للأوردر
     */
    public function getOrderPaymentPercentage($order)
    {
        if ($order->total_price == 0) {
            return 0;
        }

        return ($order->payed / $order->total_price) * 100;
    }

    /**
     * حساب النسبة المتبقية للأوردر
     */
    public function getOrderRemainingPercentage($order)
    {
        return 100 - $this->getOrderPaymentPercentage($order);
    }

    /**
     * هل الأوردر مدفوع بالكامل؟
     */
    public function isOrderFullyPayed($order)
    {
        return $this->getOrderRemaining($order) <= 0;
    }
}
