<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SupplierDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Engineer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\SupplierStock;
use App\Models\Task;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index(SupplierDataTable $dataTable)
    {
        return $dataTable->render('admin.suppliers.index');
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }


    public function store(SupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());

        notyf()->addSuccess('تم إضافة المورد "' . $supplier->name . '" بنجاح ✅');

        return redirect()->route('admin.suppliers.index');
    }


//        public function show(Supplier $supplier)
//        {
//            return view('admin.suppliers.show', compact('supplier'));
//        }


    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }


    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        notyf()->addSuccess('تم تحديث بيانات المورد "' . $supplier->name . '" بنجاح ✨');

        return redirect()->route('admin.suppliers.index');
    }


    public function destroy(Supplier $supplier)
    {
        $name = $supplier->name;
        $supplier->delete();

        notyf()->addSuccess('تم حذف المورد "' . $name . '" بنجاح ');

        return redirect()->route('admin.suppliers.index');
    }


    public function supplier_transactions(Request $request)
    {
        $suppliers = Supplier::all();

        $query = Purchase::with('supplier')
            ->when($request->supplier_id, function ($query) use ($request) {
                $query->where('supplier_id', $request->supplier_id);
            })
            ->when($request->date_from, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->date_to);
            })
            ->orderBy('created_at', 'desc');

        $purchase = $query->paginate(10);

        // حساب الرصيد الإجمالي للموردين المحددين
        $totalBalance = 0;
        $payments = [];
        if ($request->supplier_id) {
            $supplier = Supplier::find($request->supplier_id);
            $totalBalance = $supplier->current_balance ?? 0;
            $payments = $supplier->payments()->orderBy('payment_date', 'desc')->get();
        }

        return view('admin.suppliers.supplier_transactions', compact('suppliers', 'purchase', 'totalBalance', 'payments'));
    }


    public function settle(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,check,transfer,other',
            'notes' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::findOrFail($request->supplier_id);

        // التحقق من أن المبلغ لا يتجاوز الرصيد
        if ($request->amount_paid > $supplier->current_balance) {
            notyf()->addError('المبلغ المدفوع لا يمكن أن يتجاوز الرصيد الحالي (' . $supplier->current_balance . ')');
            return redirect()->back();
        }

        // إنشاء سجل المدفوعة
        SupplierPayment::create([
            'supplier_id' => $supplier->id,
            'amount_paid' => $request->amount_paid,
            'payment_date' => now()->toDateString(),
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // تحديث الرصيد الحالي بخصم المبلغ المدفوع
        $supplier->current_balance = max(0, $supplier->current_balance - $request->amount_paid);
        $supplier->save();

        notyf()->addSuccess('تمت تصفية الحساب بنجاح. تم تسجيل دفعة بقيمة ' . number_format($request->amount_paid, 2));

        return redirect()->back();
    }

    public function createProductSupplier()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('admin.suppliers.create_supplier_product', compact('suppliers', 'products'));
    }

    public function storeSupplierProducts(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
        ]);

        $supplierId = $request->supplier_id;
        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);

        foreach ($products as $productId) {
            $quantity = $quantities[$productId] ?? 1;

            $existing = SupplierStock::where('supplier_id', $supplierId)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                $existing->update([
                    'quantity' => $quantity,
                ]);
            } else {
                SupplierStock::create([
                    'supplier_id' => $supplierId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }
        \Flasher\Notyf\Prime\notyf()->addSuccess('تم اضافه مخزون للمورد بنجاح');
        return redirect()
            ->route('admin.index.supplier.products');
    }

    public function supplier_product_index()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $supplierStocks = SupplierStock::paginate(25);
        return view('admin.suppliers.supplier_stock_index', compact('suppliers', 'products', 'supplierStocks'));
    }

    public function searchStock(Request $request)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $supplierStocks = SupplierStock::query();
        if ($request->has('supplier_id')) {
            $supplierStocks->orWhere('supplier_id', $request->supplier_id);
        }
        if ($request->has('product_id')) {
            $supplierStocks->orWhere('product_id', $request->product_id);
        }
        $supplierStocks = $supplierStocks->paginate(25)
        ->withQueryString();
        return view('admin.suppliers.supplier_stock_index', compact('supplierStocks','products','suppliers'));
    }


}
