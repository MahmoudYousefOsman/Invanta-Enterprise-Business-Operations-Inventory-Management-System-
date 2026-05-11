<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Services\InsertProductTransaction;
use App\Http\Services\BarcodeGenerate;
use App\Http\Services\UpdateProductQuantity;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $UpdateProductQuantity;
    protected $BarCode;
    protected $insertProductTransaction;

    public function __construct(UpdateProductQuantity $UpdateProductQuantity, InsertProductTransaction $insertProductTransaction, BarcodeGenerate $BarCode)
    {
        $this->insertProductTransaction = $insertProductTransaction;
        $this->BarCode = $BarCode;
        $this->UpdateProductQuantity = $UpdateProductQuantity;
    }

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }

    public function create()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function createProductMaintenance(Product $product)
    {
        $categories = Category::where('parent_id', null)->get();
        return view('admin.products.createProductMaintenance', compact('categories', 'product'));
    }


    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['code'] = 'PRD-' . strtoupper(uniqid());
        $data['photo'] = $this->uploadPhoto($request);
        $product = Product::create($data);

        $this->insertProductTransaction->insertProductTransaction($product->id, $request->quantity, get_class($product), $product->id, 'in');

        notyf()->addSuccess('تم اضافه المنتج بنجاح');
        if ($product->type == 'fix') {
            return redirect()->route('admin.products.maintenance.index');

        } else {
            return redirect()->route('admin.products.iphone.index');
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::where('parent_id', null)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['photo'] = $this->uploadPhoto($request, $product->photo);
        $product->update($data);

        notyf()->addSuccess('تم تحديث المنتج بنجاح');
if ($product->type == 'fix') {
            return redirect()->route('admin.products.maintenance.index');

        } else {
            return redirect()->route('admin.products.iphone.index');
        }
            }

    public function destroy(Product $product)
    {
        if ($product->photo && Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }

        $this->insertProductTransaction->insertProductTransaction($product->id, $product->quantity, get_class($product), $product->id, 'out');

        $product->delete();

        notyf()->addSuccess('تم حذف المنتج بنجاح');
if ($product->type == 'fix') {
            return redirect()->route('admin.products.maintenance.index');

        } else {
            return redirect()->route('admin.products.iphone.index');
        }
            }

    public function lowStock()
    {
        // قراءة نوع المنتج من الـ URL
        $type = request()->segment(3); // = iphone أو maintenance أو lowstock

        // تحويل iphone → phone   (لو الاسم مختلف في DB)
        if ($type === 'iphone') {
            $type = 'phone';
        }
        if ($type === 'maintenance') {
            $type = 'fix';
        }

        // بناء الاستعلام
        $query = Product::with('category')->where('quantity', '<=', 4);

        // لو النوع موجود في الـ URL اعمل فلترة
        if (in_array($type, ['phone', 'fix'])) {
            $query->where('type', $type);
        }

        $lowProducts = $query->paginate(10);

        return view('admin.products.lowStock', compact('lowProducts'));
    }


    public function movements(Request $request)
    {

        $products = Product::all();
        $transactions = ProductTransaction::with('product')
            ->when($request->product_id, fn($q) => $q->where('product_id', $request->product_id))
            ->when($request->from, fn($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('created_at', '<=', $request->to))
            ->orderByRaw("CASE WHEN model = ? THEN 0 ELSE 1 END", [Product::class])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalQuantity = null;
        if ($request->product_id) {
            $totalQuantity = ProductTransaction::where('product_id', $request->product_id)
                ->selectRaw("SUM(CASE WHEN type = 'in' THEN quantity ELSE -quantity END) as balance")
                ->value('balance');
        }

        return view('admin.products.movements', compact('products', 'transactions', 'totalQuantity'));
    }

    private function uploadPhoto($request, $oldPhoto = null): ?string
    {
        if ($request->hasFile('photo')) {
            if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }

            return $request->file('photo')->store('products', 'public');
        }

        return $oldPhoto;
    }

    public function generateBarrCode(Request $request)
    {
        $ids = $request->ids;
        $numOfPrint = $request->qty;
        $item = Product::where('id', $ids)->first();
        $item->qr = $this->BarCode->generateBase64($item->code);

        return view('admin.products.qr', compact('item', 'numOfPrint'));
    }
    public function generateItemsBarrCode(Request $request)
    {
       $products = Product::all();
        return view('admin.products.generate_items_barcode', compact('products'));
    }
    public function printItemsBarcode(Request $request)
    {
        $items = $request->items;

        $barcodes = [];

        foreach ($items as $item) {

            $product = Product::find($item['id']);

            if (!$product) {
                continue;
            }

            // generate barcode image once
            $qr = $this->BarCode->generateBase64($product->code);
            for ($i = 0; $i < $item['qty']; $i++) {
                $barcodes[] = [
                    'name' => $product->name,
                    'code' => $product->code,
                    'qr'   => $qr,
                    'price' => $product->sale_price,
                ];
            }
        }

        return view('admin.products.print_barcodes', compact('barcodes'));
    }
}

