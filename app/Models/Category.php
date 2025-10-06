<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static function dropdownOptionsCategory(){
        return self::pluck('category', 'id');

    }
}
