<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        $products = Product::where('type', 'phone')->get(); // منتجات البيع فقط

        if ($products->isEmpty()) {
            return;
        }

        $dayCounter = 0;

        foreach ($suppliers as $supplier) {
            // كل موردي 2-3 مشتريات
            for ($i = 0; $i < rand(2, 3); $i++) {
                // توزيع على مدار الشهر كله (0-29)
                $dayCounter = ($dayCounter + rand(2, 4)) % 30;
                $purchaseDate = now()->subDays($dayCounter);

                $invoiceType = ['paid', 'unpaid', 'partial'][array_rand(['paid', 'unpaid', 'partial'])];

                $purchase = Purchase::firstOrCreate(
                    ['code' => 'PUR' . date('YmdHis') . $supplier->id . $i],
                    [
                        'supplier_id' => $supplier->id,
                        'date' => $purchaseDate,
                        'total_price' => 0,
                        'invoice_type' => $invoiceType,
                        'paid_amount' => 0,
                        'remaining_amount' => 0,
                        'created_at' => $purchaseDate,
                        'updated_at' => $purchaseDate,
                    ]);

                // إضافة 1-2 منتجات فقط لكل مشترى (جدول decimal(8,2) محدود)
                $selectedProducts = $products->random(rand(1, 2));
                $total = 0;

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 5); // تقليل الكمية
                    $price = $product->purchase_price;
                    $lineTotal = $quantity * $price;
                    $total += $lineTotal;

                    // تأكد من أن المجموع لا يتجاوز 999999.99
                    if ($total > 999999.99) {
                        $total = 999999.99;
                    }

                    PurchaseDetail::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);
                }

                if ($total > 0) {
                    $totalPrice = min($total, 999999.99);
                    $paidAmount = 0;
                    $remainingAmount = $totalPrice;

                    if ($invoiceType === 'paid') {
                        $paidAmount = $totalPrice;
                        $remainingAmount = 0;
                    } elseif ($invoiceType === 'partial') {
                        $paidAmount = $totalPrice * (rand(20, 80) / 100);
                        $remainingAmount = $totalPrice - $paidAmount;
                    }

                    $purchase->update([
                        'total_price' => $totalPrice,
                        'paid_amount' => $paidAmount,
                        'remaining_amount' => $remainingAmount,
                    ]);
                }
            }
        }
    }
}
