<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role'];

    public static function dropdownOptions(){
        $roles = Role::where('role', '!=', 'Developer')->pluck('role', 'id');
        return $roles;

    }
}
