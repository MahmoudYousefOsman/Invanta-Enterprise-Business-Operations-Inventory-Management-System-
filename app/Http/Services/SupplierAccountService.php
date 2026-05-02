<?php

namespace App\Http\Services;

use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\SupplierPayment;

class SupplierAccountService
{
    /**
     * حساب رصيد المورد
     */
    public function calculateSupplierBalance(Supplier $supplier)
    {
        $totalPurchases = Purchase::where('supplier_id', $supplier->id)->sum('total_price');
        $totalPayments = SupplierPayment::where('supplier_id', $supplier->id)->sum('amount_paid');

        return [
            'total_purchases' => $totalPurchases,
            'total_payments' => $totalPayments,
            'remaining_balance' => $totalPurchases - $totalPayments
        ];
    }

    /**
     * الرصيد المتبقي للمورد
     */
    public function getRemainingBalance(Supplier $supplier)
    {
        $balance = $this->calculateSupplierBalance($supplier);
        return $balance['remaining_balance'];
    }

    /**
     * هل للمورد رصيد متبقي؟
     */
    public function hasRemainingBalance(Supplier $supplier)
    {
        return $this->getRemainingBalance($supplier) > 0;
    }

    /**
     * قائمة بجميع مشتريات المورد
     */
    public function getSupplierPurchases(Supplier $supplier)
    {
        return Purchase::where('supplier_id', $supplier->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * قائمة بجميع تسويات المورد
     */
    public function getSupplierPayments(Supplier $supplier)
    {
        return SupplierPayment::where('supplier_id', $supplier->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * إجمالي ما دفعه للمورد
     */
    public function getTotalSupplierPayments(Supplier $supplier)
    {
        return SupplierPayment::where('supplier_id', $supplier->id)->sum('amount_paid');
    }

    /**
     * عدد المشتريات
     */
    public function getPurchaseCount(Supplier $supplier)
    {
        return Purchase::where('supplier_id', $supplier->id)->count();
    }
}
