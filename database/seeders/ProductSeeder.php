<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // الفئات
        $machinesCategory = Category::where('name', 'ماكينات CNC')->first();
        $maintenanceCategory = Category::where('name', 'قطع صيانة')->first();

        // فئات فرعية
        $spindleCategory = Category::where('name', 'Spindle')->first();
        $motorsCategory = Category::where('name', 'Motors')->first();
        $controllersCategory = Category::where('name', 'Controllers')->first();
        $bearingsCategory = Category::where('name', 'Bearings')->first();
        $filtersCategory = Category::where('name', 'فلاتر')->first();

        $products = [

            // 🏭 ماكينات CNC
            [
                'name' => 'ماكينة CNC راوتر 3 محور',
                'code' => 'CNC001',
                'description' => 'ماكينة CNC احترافية بثلاثة محاور للحفر للأخشاب والمعادن الخفيفة.',
                'purchase_price' => 80000,
                'sale_price' => 95000,
                'quantity' => 3,
                'type' => 'phone',
                'category_id' => $machinesCategory?->id,
            ],
            [
                'name' => 'CNC Drilling Machine',
                'code' => 'CNC002',
                'description' => 'حفر ثقوب دقيقة بسرعة وكفاءة عالية',
                'purchase_price' => 60000,
                'sale_price' => 72000,
                'quantity' => 4,
                'type' => 'phone',
                'category_id' => $machinesCategory?->id,
            ],

            // 🔧 قطع غيار (الآن تحت قطع الصيانة)
            [
                'name' => 'CNC Waterjet Machine',
                'code' => 'SP001',
                'description' => 'قطع المواد بالماء عالي الضغط بدون حرارة',
                'purchase_price' => 5000,
                'sale_price' => 7500,
                'quantity' => 10,
                'type' => 'phone',
                'category_id' => $machinesCategory?->id,
            ],
            [
                'name' => 'CNC Laser Cutter',
                'code' => 'SM001',
                'description' => 'مقطع ونقش المواد باستخدام شعاع ليزر.',
                'purchase_price' => 1200,
                'sale_price' => 2000,
                'quantity' => 20,
                'type' => 'phone',
                'category_id' => $machinesCategory?->id,
            ],
            [
                'name' => 'CNC Router',
                'code' => 'CTRL001',
                'description' => 'حفر وتقطيع الأخشاب والبلاستيك بدقة عالية.',
                'purchase_price' => 3000,
                'sale_price' => 5000,
                'quantity' => 8,
                'type' => 'phone',
                'category_id' => $machinesCategory?->id,
            ],


            // 🔧 قطع صيانة
            [
                'name' => 'CNC Controller Board',
                'code' => 'FLT001',
                'description' => 'لوحة تحكم لإدارة حركة الماكينة بدقة وسهولة.',
                'purchase_price' => 150,
                'sale_price' => 300,
                'quantity' => 30,
                'type' => 'fix',
                'category_id' => $filtersCategory?->id ?? $maintenanceCategory?->id,
            ],
            [
                'name' => 'CNC Bearings Set',
                'code' => 'BRG001',
                'description' => 'مجموعة محامل عالية الدقة للماكينات CNC',
                'purchase_price' => 500,
                'sale_price' => 800,
                'quantity' => 25,
                'type' => 'fix',
                'category_id' => $bearingsCategory?->id ?? $maintenanceCategory?->id,
            ],
            [
                'name' => 'Spindle CNC tool',
                'code' => 'MT001',
                'description' => 'تدوير الأداة بسرعة عالية لعمليات القطع',
                'purchase_price' => 800,
                'sale_price' => 1500,
                'quantity' => 15,
                'type' => 'fix',
                'category_id' => $spindleCategory?->id ?? $maintenanceCategory?->id,
            ],
            [
                'name' => 'Servo CNC Motor',
                'code' => 'CLN001',
                'description' => 'تحريك المحاور بدقة عالية واستجابة سريعة.',
                'purchase_price' => 100,
                'sale_price' => 250,
                'quantity' => 40,
                'type' => 'fix',
                'category_id' => $motorsCategory?->id ?? $maintenanceCategory?->id,
            ],

        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['code' => $product['code']],
                $product
            );
        }

        // تحديث المنتجات الموجودة التي لا لها فئات
        $productsWithoutCategory = Product::whereNull('category_id')->get();
        foreach ($productsWithoutCategory as $product) {
            // تعيين فئة افتراضية حسب نوع المنتج
            if ($product->type === 'phone') {
                $product->update(['category_id' => $machinesCategory?->id]);
            } elseif ($product->type === 'fix') {
                $product->update(['category_id' => $maintenanceCategory?->id]);
            } else {
                $product->update(['category_id' => $maintenanceCategory?->id]);
            }
        }
    }
}
