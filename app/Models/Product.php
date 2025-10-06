<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Fillable fields must match form field names or DB columns used below
    protected $fillable = [
        'code',          // for 'product_code' input
        'product_name',  // for 'name' input
        'category_id',
        'details',
        'supplier',
        'brand',
        'stocks',
        'priceCode',
        'price',
        'branch_id',
        'created_by'
       // 'product_image',  // if you want to store image filename/path
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $searchTerm = null){
        if ($searchTerm) {
            return $query->where('code', 'like', "%{$searchTerm}%")
                         ->orWhere('product_name', 'like', "%{$searchTerm}%");
        }

        return $query;
    }
}
