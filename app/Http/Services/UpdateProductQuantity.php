<?php

namespace App\Http\Services;

use App\Models\Admin;
use App\Models\Product;
use App\Notifications\SendNotification;

class UpdateProductQuantity
{
    public function increaseQuantity($productId, $quantity)
    {
        $product = Product::find($productId);
        if ($product) {
            $product->increment('quantity', $quantity);
        }
    }

    public function decreaseQuantity($productId, $quantity)
    {
        // جلب المنتج
        $product = Product::find($productId);

        if ($product) {
            $product->decrement('quantity', $quantity);
            $product->refresh();
            if ($product->quantity <= 3) {
                foreach (Admin::all() as $admin) {
                    $admin->notify(new SendNotification('product', $product));
                }
            }
        }
    }
}
