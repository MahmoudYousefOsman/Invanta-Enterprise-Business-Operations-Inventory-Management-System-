<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
            EngineerSeeder::class,
            SupplierSeeder::class,
            OrderSeeder::class,
            PurchaseSeeder::class,
            TaskSeeder::class,
            ReturnInvoiceSeeder::class,
        ]);
    }
}
