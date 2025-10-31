<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductActivity extends Model
{
    use HasFactory;

    // Allow mass assignment for the 'activity' field
    protected $fillable = ['activity'];
}
