<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'محمد علي',
                'phone' => '0123456789',
                'address' => 'القاهرة - مدينة نصر',
                'type' => 'repair',
                'new_client' => true,
            ],
            [
                'name' => 'فاطمة سالم',
                'phone' => '0109876543',
                'address' => 'الإسكندرية - سيدي بشر',
                'type' => 'purchase',
                'new_client' => true,
            ],
            [
                'name' => 'أحمد حسن',
                'phone' => '0198765432',
                'address' => 'جيزة - الهرم',
                'type' => 'repair',
                'new_client' => false,
            ],
            [
                'name' => 'سارة ابراهيم',
                'phone' => '0156789012',
                'address' => 'القاهرة - الزمالك',
                'type' => 'purchase',
                'new_client' => false,
            ],
            [
                'name' => 'علي محمود',
                'phone' => '0145678901',
                'address' => 'القاهرة - مصر الجديدة',
                'type' => 'repair',
                'new_client' => true,
            ],
            [
                'name' => 'نور حسن',
                'phone' => '0134567890',
                'address' => 'الإسكندرية - محطة الرمل',
                'type' => 'purchase',
                'new_client' => true,
            ],
        ];

        foreach ($clients as $client) {
            Client::firstOrCreate(
                ['phone' => $client['phone']],
                $client
            );
        }
    }
}
