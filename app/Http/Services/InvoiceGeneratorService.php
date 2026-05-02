<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Purchase;
use App\Models\Task;
use App\Models\InvoiceReturn;

class InvoiceGeneratorService
{
    /**
     * إنشاء رقم فاتورة فريد
     */
    public function generateUniqueInvoiceNumber($prefix = 'INV')
    {
        $lastInvoice = Order::orderBy('id', 'DESC')->first();
        $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;

        return $prefix . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT) . '-' . date('Y');
    }

    /**
     * إنشاء بيانات الفاتورة
     */
    public function prepareOrderInvoiceData(Order $order)
    {
        return [
            'invoice_number' => $order->invoice_number ?? $this->generateUniqueInvoiceNumber(),
            'client' => $order->client,
            'items' => $order->orderDetails,
            'total_price' => $order->total_price,
            'payed' => $order->payed,
            'remaining' => $order->total_price - $order->payed,
            'created_date' => $order->created_at,
            'status' => $order->status
        ];
    }

    /**
     * إنشاء بيانات فاتورة المشتريات
     */
    public function preparePurchaseInvoiceData(Purchase $purchase)
    {
        return [
            'invoice_number' => $purchase->invoice_number ?? $this->generateUniqueInvoiceNumber('PUR'),
            'supplier' => $purchase->supplier,
            'items' => $purchase->purchaseDetails,
            'total_price' => $purchase->total_price,
            'payed' => $purchase->payed ?? 0,
            'remaining' => $purchase->total_price - ($purchase->payed ?? 0),
            'created_date' => $purchase->created_at,
        ];
    }

    /**
     * إنشاء فاتورة المرتجع
     */
    public function prepareReturnInvoiceData(InvoiceReturn $return)
    {
        return [
            'return_number' => 'RET-' . str_pad($return->id, 5, '0', STR_PAD_LEFT),
            'client' => $return->order->client ?? null,
            'order_invoice' => $return->order->invoice_number ?? null,
            'items' => $return->returnItems,
            'total_price' => $return->order->total_price ?? 0,
            'return_total' => $return->returnItems->sum('quantity'),
            'created_date' => $return->created_at,
            'reason' => $return->reason ?? ''
        ];
    }

    /**
     * حساب تفاصيل الفاتورة
     */
    public function calculateInvoiceTotals($orderDetails)
    {
        $subtotal = 0;

        foreach ($orderDetails as $detail) {
            $subtotal += $detail->price * $detail->quantity;
        }

        return [
            'subtotal' => $subtotal,
            'tax' => 0,
            'total' => $subtotal
        ];
    }
}
