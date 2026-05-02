<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::where('type', 'purchase')->get();
        $products = Product::all();
        $dayCounter = 0;

        foreach ($clients as $client) {
            // كل عميل 2-3 أوردات
            for ($i = 0; $i < rand(2, 3); $i++) {
                // توزيع على مدار الشهر كله (0-29)
                $dayCounter = ($dayCounter + rand(2, 4)) % 30;
                $orderDate = now()->subDays($dayCounter);

                $order = Order::firstOrCreate(
                    ['code' => 'ORD' . date('YmdHis') . $client->id . $i],
                    [
                        'client_id' => $client->id,
                        'total_price' => 0,
                        'notes' => 'ملاحظات الأمر رقم ' . ($i + 1),
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);

                // إضافة 1-3 منتجات لكل أمر
                $selectedProducts = $products->random(rand(1, 3));
                $total = 0;

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 5);
                    $price = $product->sale_price;
                    $lineTotal = $quantity * $price;
                    $total += $lineTotal;

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'total_price' => $lineTotal,
                        'sale_price' => $price,
                        'purchase_price' => $product->purchase_price,
                    ]);
                }

                $order->update(['total_price' => $total]);
            }
        }
    }
}
