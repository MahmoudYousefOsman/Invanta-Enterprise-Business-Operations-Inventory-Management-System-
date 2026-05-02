<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | الفئات الرئيسية
        |--------------------------------------------------------------------------
        */

        $machines = Category::firstOrCreate([
            'name' => 'ماكينات CNC'
        ], [
            'parent_id' => null
        ]);

        $maintenance = Category::firstOrCreate([
            'name' => 'قطع صيانة'
        ], [
            'parent_id' => null
        ]);

        /*
        |--------------------------------------------------------------------------
        | الفئات الفرعية - قطع الصيانة
        |--------------------------------------------------------------------------
        */

        // قطع غيار (دمجها مع الصيانة)
        Category::firstOrCreate([
            'name' => 'Spindle'
        ], [
            'parent_id' => $maintenance->id
        ]);

        Category::firstOrCreate([
            'name' => 'Motors'
        ], [
            'parent_id' => $maintenance->id
        ]);

        Category::firstOrCreate([
            'name' => 'Controllers'
        ], [
            'parent_id' => $maintenance->id
        ]);

        Category::firstOrCreate([
            'name' => 'Bearings'
        ], [
            'parent_id' => $maintenance->id
        ]);

        Category::firstOrCreate([
            'name' => 'Board'
        ], [
            'parent_id' => $maintenance->id
        ]);
    }
}
