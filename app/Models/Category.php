<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function allChildrenIds()
    {
        $ids = collect();
        foreach ($this->children as $child) {
            $ids->push($child->id);
            $ids = $ids->merge($child->allChildrenIds());
        }

        return $ids;
    }
    public function getRootParent()
    {
        $category = $this;
        while ($category->parent) {
            $category = $category->parent;
        }
        return $category;
    }
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }


}
