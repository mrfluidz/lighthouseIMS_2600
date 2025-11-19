<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'discount_price',
        'sub_total',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
