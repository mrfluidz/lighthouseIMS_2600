<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserExtension extends Model
{
    protected $fillable = ['user_id', 'role_id','branch_id']; 

    public static function createUserExtension($userId, $roleId, $branchId){
        return self::create([
            'user_id' => $userId,
            'role_id' => $roleId,
            'branch_id' => $branchId
        ]);
    }

    public static function getUserExtension(){
        return self::where('user_id', Auth::id())->get();
        
    }

    public static function getCurrentUserData(){
        $userData = UserExtension::join('branches', 'branches.id', '=', 'user_extensions.branch_id')
        ->join('users', 'users.id', '=', 'user_extensions.user_id')
        ->join('roles', 'roles.id', '=', 'user_extensions.role_id')
        ->where('user_extensions.user_id', Auth::id())
        ->where('user_extensions.is_active', 1)
        ->select(
        'users.name as user_name',
        'users.id as user_id',
        'branches.id as branch_id',
        'branches.name as branch_name',
        'branches.code as branch_code',
        'roles.id as role_id',
        'roles.role as role_name'
        )->first();

        return $userData;
    }

    

}
