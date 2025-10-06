<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class ProductDetailController extends Controller
{
    public function index()
    {
        $currentUserData = UserExtension::getCurrentUserData();
        $categories = Category::dropdownOptionsCategory();

        return view('product_detail', [
            'currentUserData' => $currentUserData,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request){
        $userData = UserExtension::getCurrentUserData();

        if (!$userData) {
            return response()->json(['error' => 'User extension not found or inactive'], 403);
        }

        $branchId = $userData->branch_id;

        $request->validate([
            'product_code' => 'required|string|unique:products,code',
            'name' => 'required|string|unique:products,product_name',
            'category_id' => 'required|exists:categories,id',
            'details' => 'required|string|max:1000',
            'supplier' => 'required|string',
            'brand' => 'required|string',
            'stocks' => 'required|integer|min:0',
            'priceCode' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            //'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional validation for image
        ]);

        // Handle file upload if exists
       /* if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $request->merge(['product_image' => $imageName]);
        }*/

        // Prepare data to save matching DB columns
        $data = [
            'code' => $request->input('product_code'),
            'product_name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'details' => $request->input('details'),
            'supplier' => $request->input('supplier'),
            'brand' => $request->input('brand'),
            'stocks' => $request->input('stocks'),
            'priceCode' => $request->input('priceCode'),
            'price' => $request->input('price'),
            'created_by' => Auth::id(),
            'branch_id' => $branchId


           // 'product_image' => $request->input('product_image') ?? null,
        ];
        try {
        Product::create($data);
            Log::info('Product created successfully', $data);
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Failed to create product.']);
        }

        return redirect()->route('product')->with('success', 'Product created successfully.');
    }
}
