<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\InvoiceReturn;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ReturnItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReturnInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::where('type', 'purchase')->get();
        $suppliers = Supplier::all();
        $products = Product::all();
        $dayCounter = 0;

        // إرجاعات من العملاء
        foreach ($clients as $client) {
            // 0-2 إرجاع لكل عميل
            for ($i = 0; $i < rand(0, 2); $i++) {
                // توزيع على مدار الشهر كله
                $dayCounter = ($dayCounter + rand(2, 5)) % 30;

                $total = 0;
                $selectedProducts = $products->random(rand(1, 2));

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $lineTotal = $quantity * $product->sale_price;
                    $total += $lineTotal;
                }

                $return = InvoiceReturn::firstOrCreate(
                    ['code' => 'RET' . date('YmdHis') . $client->id . $i],
                    [
                        'type' => 'client',
                        'type_id' => $client->id,
                        'notes' => 'ملاحظات الإرجاع',
                        'total_price' => $total,
                        'created_at' => now()->subDays($dayCounter),
                        'updated_at' => now()->subDays($dayCounter),
                    ]);

                // إضافة منتجات الإرجاع
                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $lineTotal = $quantity * $product->sale_price;

                    ReturnItem::create([
                        'invoice_return_id' => $return->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->sale_price,
                        'total_price' => $lineTotal,
                    ]);
                }
            }
        }

        // إرجاعات للموردين
        $supplierDayCounter = 0;
        foreach ($suppliers as $supplier) {
            // 0-1 إرجاع لكل موردي
            for ($i = 0; $i < rand(0, 1); $i++) {
                $supplierDayCounter = ($supplierDayCounter + rand(3, 8)) % 30;

                $total = 0;
                $selectedProducts = $products->random(rand(1, 2));

                foreach ($selectedProducts as $product) {
                    $quantity = rand(2, 5);
                    $lineTotal = $quantity * $product->purchase_price;
                    $total += $lineTotal;
                }

                $return = InvoiceReturn::firstOrCreate(
                    ['code' => 'SUP_RET' . date('YmdHis') . $supplier->id . $i],
                    [
                        'type' => 'supplier',
                        'type_id' => $supplier->id,
                        'notes' => 'إرجاع للموردي',
                        'total_price' => $total,
                        'created_at' => now()->subDays($supplierDayCounter),
                        'updated_at' => now()->subDays($supplierDayCounter),
                    ]);

                // إضافة منتجات الإرجاع
                foreach ($selectedProducts as $product) {
                    $quantity = rand(2, 5);
                    $lineTotal = $quantity * $product->purchase_price;

                    ReturnItem::create([
                        'invoice_return_id' => $return->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->purchase_price,
                        'total_price' => $lineTotal,
                    ]);
                }
            }
        }
    }
}
