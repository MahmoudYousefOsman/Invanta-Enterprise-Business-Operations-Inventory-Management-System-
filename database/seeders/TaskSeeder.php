<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Engineer;
use App\Models\Task;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::where('type', 'repair')->get();
        $engineers = Engineer::all();
        $admin = Admin::first() ?? Admin::firstOrCreate(
            ['email' => 'admin@invanta.com'],
            [
                'name' => 'مدير النظام',
                'password' => bcrypt('admin123'),
            ]
        );
        $products = Product::where('type', 'fix')->get();

        // إذا لم تكن هناك منتجات من نوع fix، استخدم جميع المنتجات
        if ($products->isEmpty()) {
            $products = Product::all();
        }

        $dayCounter = 0;

        foreach ($clients as $client) {
            // كل عميل 2-4 طلبات صيانة
            for ($i = 0; $i < rand(2, 4); $i++) {
                // توزيع على مدار الشهر كله (0-29)
                $dayCounter = ($dayCounter + rand(1, 3)) % 30;
                $taskDate = now()->subDays($dayCounter);

                $task = Task::firstOrCreate(
                    ['serial_number' => 'SN' . strtoupper(substr(md5(rand() . time()), 0, 8))],
                    [
                        'client_id' => $client->id,
                        'engineer_id' => $engineers->random()->id,
                        'created_by' => $admin->id,
                        'device_type' => collect(['iPhone', 'Samsung', 'Huawei', 'iPad', 'Laptop'])->random(),
                        'description' => 'وصف المشكلة: شاشة مكسورة أو عطل في البطارية أو مشاكل في البرنامج',
                        'notes' => 'ملاحظات إضافية حول الجهاز',
                        'commission' => rand(50, 500),
                        'status' => collect(['new', 'completed', 'cancelled'])->random(),
                        'cost' => rand(200, 2000),
                        'payed' => rand(0, 1) ? rand(200, 2000) : null,
                        'receipt_date' => $taskDate->toDateString(),
                        'due_date' => $taskDate->addDays(rand(1, 14))->toDateString(),
                        'created_at' => $taskDate,
                        'updated_at' => $taskDate,
                    ]);

                // إضافة 1-3 منتجات (خدمات) للمهمة
                if ($products->count() > 0) {
                    $take = min(rand(1, 3), $products->count());
                    $selectedProducts = $products->random($take);
                    foreach ($selectedProducts as $product) {
                        $task->products()->attach($product->id, ['quantity' => rand(1, 3)]);
                    }
                }
            }
        }
    }
}
