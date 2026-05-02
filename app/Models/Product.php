<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_details','product_id','order_id');
    }

    public function task()
    {
        return $this->belongsToMany(Task::class,'task_products','product_id','task_id');
    }
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function transactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function supplierStock()
    {
        return $this->belongsTo(SupplierStock::class);
    }

}


