<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public static function dropdownOptions(){
        return self::pluck('name', 'id');

    }
}
