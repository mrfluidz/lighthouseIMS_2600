<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;

class InvoiceController extends Controller
{
    public function index()
    {
        $userExtensions = UserExtension::getUserExtension();
        $currentUserData = UserExtension::getCurrentUserData();
        return view('invoice',compact('userExtensions','currentUserData'));
    }
}
