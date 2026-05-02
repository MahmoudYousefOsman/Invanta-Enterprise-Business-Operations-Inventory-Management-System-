<?php

namespace App\Http\Services;

use App\Models\ProductTransaction;

class InsertProductTransaction
{
    public function insertProductTransaction($productId, $quantity, $model, $model_id, $type)
    {
        ProductTransaction::create([
            'product_id' => $productId,
            'quantity' => $quantity,
            'model' => $model,
            'model_id' => $model_id,
            'type' => $type,
        ]);
    }
}
