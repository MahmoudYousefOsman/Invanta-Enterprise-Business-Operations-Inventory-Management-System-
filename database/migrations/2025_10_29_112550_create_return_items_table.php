<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('return_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_return_id')
                ->constrained('invoice_returns')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('product_id')->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('total_price', 8, 2);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */


    public function down(): void
    {
        Schema::dropIfExists('return_items');
    }
};
