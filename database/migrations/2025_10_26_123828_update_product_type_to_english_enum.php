<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            // 1️⃣ غيّر البيانات القديمة أولاً
            DB::table('products')->where('type', 'فون')->update(['type' => 'phone']);
            DB::table('products')->where('type', 'صيانة')->update(['type' => 'fix']);

            // 2️⃣ بعدين عدّل نوع العمود enum
            Schema::table('products', function (Blueprint $table) {
                $table->enum('type', ['fix', 'phone'])
                    ->default('phone')
                    ->change();
            });
        }

        public function down(): void
        {
            // في حالة rollback نرجع القيم زي ما كانت
            DB::table('products')->where('type', 'phone')->update(['type' => 'فون']);
            DB::table('products')->where('type', 'fix')->update(['type' => 'صيانة']);

            Schema::table('products', function (Blueprint $table) {
                $table->enum('type', ['صيانة', 'فون'])
                    ->default('فون')
                    ->change();
            });
        }
    };
