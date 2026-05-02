<?php

namespace App\Http\Services;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Client;

class PaymentSettlementService
{
    /**
     * تسجيل دفعة مورد
     */
    public function recordSupplierPayment(Supplier $supplier, $amount, $method = 'cash', $notes = null)
    {
        return SupplierPayment::create([
            'supplier_id' => $supplier->id,
            'amount_paid' => $amount,
            'payment_method' => $method,
            'notes' => $notes,
            'payment_date' => now()
        ]);
    }

    /**
     * تسجيل دفعة عميل
     */
    public function recordClientPayment(Client $client, Order $order, $amount, $method = 'cash', $notes = null)
    {
        $remaining = $order->total_price - $order->payed;

        if ($amount > $remaining) {
            return [
                'success' => false,
                'message' => 'المبلغ المدفوع أكبر من المتبقي'
            ];
        }

        $newPayed = $order->payed + $amount;
        $order->update(['payed' => $newPayed]);

        return [
            'success' => true,
            'message' => 'تم تسجيل الدفعة بنجاح',
            'payment_data' => [
                'order_id' => $order->id,
                'amount_paid' => $amount,
                'payment_method' => $method,
                'total_payed' => $newPayed,
                'remaining' => $order->total_price - $newPayed,
                'notes' => $notes
            ]
        ];
    }

    /**
     * الحصول على سجل الدفعات
     */
    public function getPaymentHistory($supplier)
    {
        return SupplierPayment::where('supplier_id', $supplier->id)
            ->orderBy('payment_date', 'DESC')
            ->get();
    }

    /**
     * حساب إجمالي دفعات المورد
     */
    public function getTotalSupplierPayments(Supplier $supplier)
    {
        return SupplierPayment::where('supplier_id', $supplier->id)->sum('amount_paid');
    }

    /**
     * التحقق من إمكانية الدفع
     */
    public function canMakePayment(Supplier $supplier, $amount)
    {
        $balance = $supplier->current_balance ?? 0;
        return $amount > 0 && $amount <= $balance;
    }

    /**
     * إرجاع الدفعة
     */
    public function reversePayment(SupplierPayment $payment)
    {
        $supplier = $payment->supplier;
        $supplier->increment('current_balance', $payment->amount_paid);
        $payment->delete();

        return true;
    }

    /**
     * دفعات معلقة (لم تكتمل)
     */
    public function getPendingPayments(Supplier $supplier)
    {
        $purchases = $supplier->purchases;
        $pending = [];

        foreach ($purchases as $purchase) {
            $remaining = $purchase->total_price - ($purchase->payed ?? 0);
            if ($remaining > 0) {
                $pending[] = [
                    'purchase_id' => $purchase->id,
                    'amount_due' => $remaining,
                    'purchase_date' => $purchase->created_at
                ];
            }
        }

        return $pending;
    }
}
