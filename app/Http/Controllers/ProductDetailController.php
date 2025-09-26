<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class ProductDetailController extends Controller
{
    public function index() {
        $currentUserData = UserExtension::getCurrentUserData();
        return view('product_detail', ['currentUserData' => $currentUserData]);
    }

   
}
