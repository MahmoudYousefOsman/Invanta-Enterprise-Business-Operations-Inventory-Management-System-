<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = [];
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,'supplier_stocks','supplier_id','product_id')
            ->withPivot(['quantity']);
    }
    public function stocks()
    {
        return $this->hasMany(SupplierStock::class);
    }
    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }
}
