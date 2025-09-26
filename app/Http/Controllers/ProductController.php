<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
class ProductController extends Controller
{
    public function index()
    {
        $currentUserData = UserExtension::getCurrentUserData();
        return view('product',['currentUserData' => $currentUserData]);
    }
}
