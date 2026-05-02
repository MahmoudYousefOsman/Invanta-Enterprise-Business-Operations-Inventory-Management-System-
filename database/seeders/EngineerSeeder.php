<?php

namespace Database\Seeders;

use App\Models\Engineer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EngineerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $engineers = [
            [
                'name' => 'محمود الفني',
                'email' => 'engineer1@invanta.com',
                'phone' => '0100000001',
                'password' => Hash::make('password123'),
                'address' => 'القاهرة - مدينة نصر',
            ],
            [
                'name' => 'علاء الدين الفني',
                'email' => 'engineer2@invanta.com',
                'phone' => '0100000002',
                'password' => Hash::make('password123'),
                'address' => 'الإسكندرية - سيدي بشر',
            ],
            [
                'name' => 'خالد المتخصص',
                'email' => 'engineer3@invanta.com',
                'phone' => '0100000003',
                'password' => Hash::make('password123'),
                'address' => 'جيزة - الهرم',
            ],
            [
                'name' => 'أحمد الصيانة',
                'email' => 'engineer4@invanta.com',
                'phone' => '0100000004',
                'password' => Hash::make('password123'),
                'address' => 'القاهرة - مصر الجديدة',
            ],
        ];

        foreach ($engineers as $engineer) {
            Engineer::firstOrCreate(
                ['email' => $engineer['email']],
                $engineer
            );
        }
    }
}
