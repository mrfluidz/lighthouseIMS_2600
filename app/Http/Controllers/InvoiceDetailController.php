<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
class InvoiceDetailController extends Controller
{
    public function index()
    {
        $currentUserData = UserExtension::getCurrentUserData();
        

        return view('invoice_detail', [
            'currentUserData' => $currentUserData
            
        ]);
    }
}
