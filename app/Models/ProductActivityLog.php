<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductActivityLog extends Model
{
    use HasFactory;

    protected $table = 'product_activity_logs';

    protected $fillable = [
        'product_id',
        'product_log_type_id',
        'branch_id',
        'initial_stocks',
        'restock_qty',
        'latest_stocks',
        'stock_status',
        'created_by',
    ];

    // If you want Eloquent to manage timestamps automatically
    public $timestamps = true;
    protected $dates = ['created_at'];

    /**
     * Create a new stock log
     *
     * @param array $data
     * @return ProductActivityLog
     */
    public static function logStockUpdate(array $data)
    {
        // Determine stock status
        $stockStatus = ($data['restock_qty'] > $data['initial_stocks']) ? 'increase' : 'decrease';

        return self::create([
            'product_id' => $data['product_id'],
            'product_log_type_id' => $data['product_log_type_id'],
            'branch_id' => $data['branch_id'],
            'initial_stocks' => $data['initial_stocks'],
            'restock_qty' => $data['restock_qty'],
            'latest_stocks' => $data['latest_stocks'],
            'stock_status' => $stockStatus,
            'created_by' => $data['created_by'],
        ]);
    }

    // Relationships (optional)
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function productLogType() {
        //return $this->belongsTo(ProductLogType::class, 'product_log_type_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
