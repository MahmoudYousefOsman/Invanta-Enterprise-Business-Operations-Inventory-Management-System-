<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class InvoiceReturn extends Model
    {
        protected $guarded = [];

        public function client()
        {
            return $this->belongsTo(Client::class);
        }

        public function supplier()
        {
            return $this->belongsTo(Supplier::class);
        }

        public function products()
        {
            return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id')
                ->withPivot('quantity', 'price', 'total');
        }

        public function returns_items()
        {
            return $this->hasMany(ReturnItem::class);
        }
        public function getClientAttribute()
        {
            return $this->type === 'client'
                ? Client::find($this->type_id)
                : null;
        }

        public function getSupplierAttribute()
        {
            return $this->type === 'supplier'
                ? Supplier::find($this->type_id)
                : null;
        }
    }
