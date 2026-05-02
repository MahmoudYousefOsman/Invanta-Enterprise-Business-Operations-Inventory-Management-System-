<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'model',
        'model_id',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
