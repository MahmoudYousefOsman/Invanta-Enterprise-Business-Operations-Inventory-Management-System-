<?php

namespace App\Http\Services;

use App\Models\Client;
use App\Models\Order;

class ClientAccountService
{
    /**
     * حساب رصيد العميل
     */
    public function calculateClientBalance(Client $client)
    {
        $totalOrders = Order::where('client_id', $client->id)->sum('total_price');
        $totalPayed = Order::where('client_id', $client->id)->sum('payed');

        return [
            'total_orders' => $totalOrders,
            'total_payed' => $totalPayed,
            'remaining_balance' => $totalOrders - $totalPayed
        ];
    }

    /**
     * حساب الرصيد المتبقي للعميل
     */
    public function getRemainingBalance(Client $client)
    {
        $balance = $this->calculateClientBalance($client);
        return $balance['remaining_balance'];
    }

    /**
     * هل العميل له ديون؟
     */
    public function hasDebt(Client $client)
    {
        return $this->getRemainingBalance($client) > 0;
    }

    /**
     * قائمة بجميع أوردرات العميل
     */
    public function getClientOrders(Client $client)
    {
        return Order::where('client_id', $client->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * إجمالي ما دفعه العميل
     */
    public function getTotalClientPayments(Client $client)
    {
        return Order::where('client_id', $client->id)->sum('payed');
    }

    /**
     * عدد الأوردرات المكتملة
     */
    public function getCompletedOrderCount(Client $client)
    {
        return Order::where('client_id', $client->id)
            ->where('status', 'completed')
            ->count();
    }
}
