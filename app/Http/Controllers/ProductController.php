<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
use App\Models\Product;
use App\Models\ProductActivityLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of products with optional search.
     */
    public function index(Request $request)
    {
        $currentUserData = UserExtension::getCurrentUserData();
        $search = $request->input('search');

        // Use search scope if defined in Product model
        $products = Product::search($search)->paginate(10)->withQueryString();

        return view('product', compact('products', 'search', 'currentUserData'));
    }

    public function updateStock(Request $request, Product $product)
    {
            $request->validate([
                'stocks' => 'required|integer|min:0',
            ]);

            try {
                // Save initial stock for logging
                $initialStock = $product->stocks;
                $newStock = $request->stocks;

                // Update product stock
                $product->stocks = $newStock;
                $product->save();

                // Create stock activity log
                ProductActivityLog::logStockUpdate([
                    'product_id' => $product->id,
                    'product_log_type_id' => 1, // e.g., 1 = stock update
                    'branch_id' => $product->branch_id ?? null,
                    'initial_stocks' => $initialStock,
                    'restock_qty' => $newStock,
                    'latest_stocks' => $newStock,
                    'created_by' => Auth::id(),
                ]);

                return redirect()->back()->with('success', 'Stock updated successfully!');

            } catch (\Exception $e) {
                // Log the error
                Log::error('Stock update failed: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Failed to update stock. Please try again.');
            }
    }
}
