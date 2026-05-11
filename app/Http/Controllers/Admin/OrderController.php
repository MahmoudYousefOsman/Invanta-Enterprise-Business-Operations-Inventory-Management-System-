<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\StoreOrderRequest;
    use App\Http\Services\InsertProductTransaction;
    use App\Http\Services\UpdateProductQuantity;
    use App\Models\Client;
    use App\Models\Order;
    use App\Models\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class OrderController extends Controller
    {
        protected $UpdateProductQuantity;
        protected $insertProductTransaction;

        public function __construct(UpdateProductQuantity $UpdateProductQuantity, InsertProductTransaction $insertProductTransaction)
        {
            $this->insertProductTransaction = $insertProductTransaction;
            $this->UpdateProductQuantity = $UpdateProductQuantity;
        }

        public function index(\App\DataTables\OrderDataTable $dataTable)
        {
            return $dataTable->render('admin.orders.index');
        }

        public function create(Request $request)
        {
            if ($request->ajax()) {
                $type = $request->get('type');

                if ($type === 'phone') {
                    $products = Product::where('type', 'phone')->select('id', 'name', 'purchase_price', 'code','quantity')->get();
                } elseif ($type === 'fix') {
                    $products = Product::where('type', 'fix')->select('id', 'name', 'purchase_price', 'code','quantity')->get();
                } else {
                    $products = [];
                }

                return response()->json($products);
            }
            $clients = Client::all();
            $products = Product::all();

            return view('admin.orders.create', compact('clients', 'products'));
        }


        public function store(StoreOrderRequest $request)
        {
            return DB::transaction(function () use ($request) {
                $productModels = [];
                $total = $this->calculateTotal($request->products, $productModels);

                $discount = (float) $request->discount;
                if ($discount > $total) {
                    notyf()->addError('الخصم لا يمكن أن يتجاوز الإجمالي.');
                    return back()->withInput();
                }

                $order = Order::create([
                    'client_id'   => $request->client_id ?? null,
                    'notes'       => $request->notes,
                    'code'        => 'ORD-' . time(),
                    'created_at'  => $request->order_date ?? now(),
                    'discount'    => $discount,
                    'total_price' => $total - $discount,
                ]);

                foreach ($request->products as $product) {
                    $item = $productModels[$product['id']];
                    if (!$item) {
                        notyf()->addError("المنتج غير موجود."); return back();
                    }

                    $quantity = (int) $product['quantity'];
                    if ($item->quantity < $quantity) {
                        notyf()->addError("لا يوجد كمية كافية من المنتج: {$item->name}"); return back();
                    }

                    $order->orderDetails()->create([
                        'product_id' => $item->id,
                        'quantity'   => $quantity,
                        'sale_price' => $item->sale_price,
                        'purchase_price' => $item->purchase_price,
                        'total_price'      => $item->sale_price * $quantity,
                    ]);

                    $this->UpdateProductQuantity->decreaseQuantity($item->id, $quantity);
                    $this->insertProductTransaction->insertProductTransaction($item->id, $quantity, get_class($order), $order->id, 'out');
                }
                $print_url  = route('admin.order.print', $order->id);
                notyf()->addSuccess('تم إضافة الأوردر بنجاح ✅');
                return redirect()->route('admin.orders.index')->with('print_url',$print_url);
            });
        }

        public function show(Order $order)
        {
            return view('admin.orders.show', compact('order'));
        }

        public function destroy(Order $order)
        {
            DB::transaction(function () use ($order) {
                foreach ($order->orderDetails as $detail) {
                    $productId = $detail->product_id;
                    $quantity  = $detail->quantity;

                    $this->UpdateProductQuantity->increaseQuantity($productId, $quantity);

                    $this->insertProductTransaction->insertProductTransaction($productId, $quantity, get_class($order), $order->id, 'in');
                }
                $order->orderDetails()->delete();
                $order->delete();
            });

            notyf()->addSuccess('تم حذف الطلب وإرجاع الكميات بنجاح ✅');
            return redirect()->route('admin.orders.index');
        }
        private function calculateTotal(array $products, array &$productModels): float
        {
            $total = 0;
            foreach ($products as $product) {
                $item = Product::find($product['id']);
                if (!$item) {
                    notyf()->addError("المنتج رقم {$product['id']} غير موجود ");return back()->withInput();
                }
                $productModels[$product['id']] = $item;
                $quantity = (int) $product['quantity'];
                $total += $item->sale_price * $quantity;
            }

            return $total;
        }

    }
