<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierStock extends Model
{
    protected $guarded = [];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
