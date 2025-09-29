<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
use App\Models\Product;
class ProductController extends Controller
{
    public function index(Request $request){

        $currentUserData = UserExtension::getCurrentUserData();

        $search = $request->input('search');

        $products = Product::search($search)->paginate(1)->withQueryString();

        return view('product', compact('products', 'search', 'currentUserData'));
    }

}
