<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['user_id', 'role_id']; 

    public static function createUserRole($userId, $roleId)
    {
        return self::create([
            'user_id' => $userId,
            'role_id' => $roleId,
        ]);
    }
}
