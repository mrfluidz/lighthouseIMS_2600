<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;

class DashboardController extends Controller
{
    public function index()
    {
        $userExtensions = UserExtension::getUserExtension();
        return view('dashboard',compact('userExtensions'));
    }
}
