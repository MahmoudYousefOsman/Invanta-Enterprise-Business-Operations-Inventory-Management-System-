<?php

namespace App\Http\Controllers\admin;

use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Services\InsertProductTransaction;
use App\Http\Services\UpdateProductQuantity;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $UpdateProductQuantity;
    protected $insertProductTransaction;

    public function __construct(UpdateProductQuantity $UpdateProductQuantity, InsertProductTransaction $insertProductTransaction)
    {
        $this->insertProductTransaction = $insertProductTransaction;
        $this->UpdateProductQuantity = $UpdateProductQuantity;
    }

    public function index(PurchaseDataTable $dataTable)
    {
        return $dataTable->render('admin.purchases.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $suppliers = Supplier::all();

        // ✅ لو الطلب AJAX للفلترة فقط (من الجافاسكريبت)
        if ($request->ajax() && $request->has('type')) {
            $products = Product::where('type', $request->type)->get(['id', 'name', 'quantity', 'purchase_price']);
            return response()->json($products);
        }
        $products = Product::all();
        return view('admin.purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $productModels = [];
            $total = $this->calculateTotal($request->products, $productModels);
            $discount = (float)$request->discount;
            if ($discount > $total) {
                notyf()->addError(' الخصم لا يمكن أن يتجاوز الإجمالي.');
                return back()->withInput();
            }

            $paymentData = $this->calculatePaymentDetails($request->invoice_type, $total, $discount, $request->paid_amount);
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'code' => 'PUR-' . time(),
                'date' => $request->purchase_date ?? now(),
                'discount' => $discount,
                'total_price' => $paymentData['total_price'],
                'invoice_type' => $request->invoice_type,
                'paid_amount' => $paymentData['paid_amount'],
                'remaining_amount' => $paymentData['remaining_amount'],
            ]);

                $supplier = $purchase->supplier;
                $supplier->current_balance += $paymentData['remaining_amount'];
                $supplier->save();

            foreach ($request->products as $product) {
                $item = $productModels[$product['id']];
                $purchase->purchaseDetails()->create([
                    'product_id' => $item->id,
                    'quantity' => (int)$product['quantity'],
                    'price' => $item->purchase_price,
                ]);
                $this->UpdateProductQuantity->increaseQuantity($item->id, (int)$product['quantity']);
                $this->insertProductTransaction->insertProductTransaction($item->id, (int)$product['quantity'], get_class($purchase), $purchase->id, 'in');
            }
            notyf()->addSuccess('تم إضافة عملية الشراء بنجاح ✅');
            return redirect()->route('admin.purchases.index');
        });
    }


    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('admin.purchases.show', compact('purchase'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            foreach ($purchase->purchaseDetails as $detail) {
                $productId = $detail->product_id;
                $quantity = $detail->quantity;

                $this->UpdateProductQuantity->decreaseQuantity($productId, $quantity);

                $this->insertProductTransaction->insertProductTransaction($productId, $quantity, get_class($purchase), $purchase->id, 'out');
            }
            $purchase->purchaseDetails()->delete();
            $purchase->delete();
        });
        notyf()->addSuccess('تم حذف عملية الشراء وإرجاع الكميات بنجاح ✅');
        return redirect()->route('admin.purchases.index');
    }


    private function calculateTotal(array $products, array &$productModels): float
    {
        $total = 0;

        foreach ($products as $product) {
            $item = Product::find($product['id']);
            $productModels[$product['id']] = $item;
            $quantity = (int) $product['quantity'];
            $price    = (float) $item->purchase_price;
            $total += $price * $quantity;
        }

        return $total;
    }

    public function calculatePaymentDetails($invoiceType, $totalPrice, $discount = 0, $paidAmountInput = 0)
    {
        $total = $totalPrice - $discount;

        if ($invoiceType === 'paid') {
            $paidAmount = $total;
            $remainingAmount = 0;
        } elseif ($invoiceType === 'unpaid') {
            $paidAmount = 0;
            $remainingAmount = $total;
        } else { // partial
            $paidAmount = $paidAmountInput ?? 0;
            $remainingAmount = $total - $paidAmount;
        }

        return [
            'paid_amount' => $paidAmount,
            'remaining_amount' => $remainingAmount,
            'total_price' => $total,
        ];
    }

}
