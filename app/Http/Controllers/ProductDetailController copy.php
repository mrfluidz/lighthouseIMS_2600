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

   public function generateQr(Request $request){
        $request->validate([
        'product_code' => 'required|string|max:255',
        ]);

        $productCode = $request->input('product_code');

        $qrHtml = (string) QrCode::size(250)->generate($productCode);

        Log::info('Generating QR code for: ' . $productCode);
        Log::info('QR HTML: ' . $qrHtml);

        return response()->json([
            'qr' => $qrHtml
        ]);
    }
}
