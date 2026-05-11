<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReturnInvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReturnRequest;
use App\Http\Services\InsertProductTransaction;
use App\Http\Services\UpdateProductQuantity;
use App\Models\Client;
use App\Models\InvoiceReturn;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReturnItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InvoiceReturnController extends Controller
{

    protected $UpdateProductQuantity;
    protected $insertProductTransaction;

    public function __construct(UpdateProductQuantity $UpdateProductQuantity, InsertProductTransaction $insertProductTransaction)
    {
        $this->insertProductTransaction = $insertProductTransaction;
        $this->UpdateProductQuantity = $UpdateProductQuantity;
    }

    public function index(ReturnInvoiceDataTable $dataTable)
    {
        return $dataTable->render('admin.invoice_return.index');
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        if ($request->ajax() && $request->has('type')) {
            $type = $request->get('type');
            $query = Product::query();
            if ($type) {
                $query->where('type', $type);
            }
            $products = $query->select('id', 'name', 'quantity', 'purchase_price','sale_price')->get();
            return response()->json($products);
        }

        return view('admin.invoice_return.create', compact('clients', 'suppliers'));
    }

    public function products(Request $request)
    {
        $type = $request->get('type');
        $query = Product::query();
        if ($type) $query->where('type', $type);
        $products = $query->select('id', 'name', 'quantity', 'purchase_price')->get();
        return response()->json($products);
    }

    public function store(StoreReturnRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {

            $invoiceReturn = InvoiceReturn::create([
                'code' => 'PUR-' . time(),
                'type' => $data['type'],
                'type_id' => $data['type_id'],
                'notes' => $data['notes'] ?? null,
                'total_price' => $data['total_price'],
            ]);

            foreach ($data['products'] as $p) {
                $product = Product::lockForUpdate()->find($p['id']);
                if (!$product) {
                    throw new \Exception("منتج غير موجود: ID {$p['id']}");
                }

                $qty = intval($p['quantity']);
                $product_total_price = floatval($p['price']) * $qty;

                ReturnItem::create([
                    'invoice_return_id' => $invoiceReturn->id,
                    'product_id' => $product->id,
                    'price' => $data['type'] == 'client' ? $product->sale_price : $product->purchase_price,
                    'quantity' => $qty,
                    'total_price' => $product_total_price,
                ]);

                $this->insertProductTransaction->insertProductTransaction($product->id, $qty, get_class($invoiceReturn), $invoiceReturn->id, 'in');

                if ($data['type'] === 'client') {
                    $this->UpdateProductQuantity->increaseQuantity($product->id, $qty);
                } else {
                    $this->UpdateProductQuantity->decreaseQuantity($product->id, $qty);
                }
            }

        });

        notyf()->addSuccess('تم حفظ المرتجع بنجاح.');
        return redirect()->route('admin.invoice_return.create');
    }
    public function show(InvoiceReturn $invoiceReturn)
    {
        return view('admin.invoice_return.show', compact('invoiceReturn'));
    }

}
