<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function getProfitAttribute()
    {
        return $this->orderDetails->sum(function ($item) {
            return ($item->sale_price - $item->purchase_price) * $item->quantity;
        });
    }

}
