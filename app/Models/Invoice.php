<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_num',
        'customer',
        'invoice_datetime',
        'total_discount',
        'total_amount',
        'is_draft',
        'is_active',
        'branch_id',
        'created_by',
        'updated_by',
    ];

    // Add this relationship
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
}
