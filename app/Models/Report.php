<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'product_activity_logs';

    protected $fillable = [
        'product_id',
        'branch_id',
        'product_log_type_id',
        'initial_stocks',
        'restock_qty',
        'latest_stocks',
        'stock_status',
        'created_by',
        'created_at',
    ];

    // Relations
    public function product() { return $this->belongsTo(Product::class, 'product_id'); }
    public function branch()  { return $this->belongsTo(Branch::class, 'branch_id'); }
    public function activity(){ return $this->belongsTo(ProductActivity::class, 'product_log_type_id'); }
    public function user()    { return $this->belongsTo(User::class, 'created_by'); }

    // Scopes
    public function scopeSearch($query, $searchText)
    {
        if ($searchText) {
            $query->whereHas('product', function ($q) use ($searchText) {
                $q->where('code', 'like', "%$searchText%")
                  ->orWhere('product_name', 'like', "%$searchText%");
            });
        }
        return $query;
    }

    public function scopeFilterBranch($query, $branchId)
    {
        if ($branchId) $query->where('branch_id', $branchId);
        return $query;
    }

    public function scopeFilterActivity($query, $activityType)
    {
        if ($activityType) $query->where('product_log_type_id', $activityType);
        return $query;
    }

    public function scopeFilterMonthYear($query, $month, $year)
    {
        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);
        return $query;
    }

    public function scopeFilterDateRange($query, $fromDate, $toDate)
    {
        if ($fromDate && $toDate) {
            $query->whereBetween('created_at', [$fromDate.' 00:00:00', $toDate.' 23:59:59']);
        }
        return $query;
    }

    // Activity log message
    public function getActivityLogMessageAttribute()
    {
        // Check if activity is "Out of Stock" or stock status is "Out of Stock"
        $activityName = strtolower($this->activity->activity ?? '');
        if (str_contains($activityName, 'out of stock') || strtolower($this->stock_status ?? '') === 'out of stock') {
            return "This product is currently, OUT of STOCK.";
        }

        // Regular stock update logic
        if (is_null($this->initial_stocks) && is_null($this->latest_stocks)) {
            return $this->activity->activity ?? '-';
        }

        $change = $this->latest_stocks - $this->initial_stocks;
        $action = $change > 0 ? 'increased' : 'decreased';
        $changeValue = abs($change);

        return "Stock updated: quantity {$action} from {$this->initial_stocks} to {$this->latest_stocks} ({$changeValue}).";
    }

}
