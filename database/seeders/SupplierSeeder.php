<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'شركة التكنولوجيا الحديثة',
                'phone' => '0201000000',
                'address' => 'القاهرة - النيل سيتي',
            ],
            [
                'name' => 'موردو الإلكترونيات',
                'phone' => '0202000000',
                'address' => 'الإسكندرية - الفنار',
            ],
            [
                'name' => 'مركز قطع الغيار الدولي',
                'phone' => '0203000000',
                'address' => 'جيزة - 6 أكتوبر',
            ],
            [
                'name' => 'شركة الملحقات المتقدمة',
                'phone' => '0204000000',
                'address' => 'القاهرة - التجمع الخامس',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['phone' => $supplier['phone']],
                $supplier
            );
        }
    }
}
