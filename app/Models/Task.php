<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,'task_products')->withPivot('quantity');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class,'created_by','id');
    }
}
