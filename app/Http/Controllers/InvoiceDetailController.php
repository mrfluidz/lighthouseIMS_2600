<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExtension;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class InvoiceDetailController extends Controller
{
    public function index(Request $request)
    {
        $currentUserData = UserExtension::getCurrentUserData();

        $products = Product::where('branch_id', $currentUserData->branch_id)
            ->select('id', 'code', 'product_name', 'price')
            ->get();

        $invoice = null;
        if ($request->has('invoice_id')) {
            $invoice = Invoice::with('items')->find($request->invoice_id);
        }

        $lastInvoice = Invoice::latest()->first();
        $generatedInvoiceNumber = 'LH_INVC-' . str_pad(($lastInvoice->id ?? 0) + 1, 5, '0', STR_PAD_LEFT);

        return view('invoice_detail', [
            'currentUserData' => $currentUserData,
            'products' => $products,
            'invoice' => $invoice,
            'generatedInvoiceNumber' => $generatedInvoiceNumber,
        ]);
    }

    public function saveDraft(Request $request)
    {
        try {
            $currentUserData = UserExtension::getCurrentUserData();

            $validated = $request->validate([
                'invoice_num' => 'required|string',
                'invoice_datetime' => 'required|date',
                'customer' => 'required|string|max:255',
            ]);

            DB::beginTransaction();

            $invoice = Invoice::create([
                'invoice_num' => $validated['invoice_num'],
                'customer' => $validated['customer'],
                'invoice_datetime' => $validated['invoice_datetime'] . ' 00:00:00',
                'total_discount' => 0,
                'total_amount' => 0,
                'is_draft' => true,
                'is_active' => true,
                'branch_id' => $currentUserData->branch_id,
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice saved as draft successfully.',
                'invoice_id' => $invoice->id
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Draft saving error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving draft.'
            ], 500);
        }
    }

   public function addItem(Request $request, $invoiceId)
{
    try {
        $invoice = Invoice::findOrFail($invoiceId);

        // Validate input
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'discount_type' => 'nullable|string|in:amount,percent',
            'discount_value' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        $product = Product::findOrFail($validated['product_id']);
        $price = $product->price;
        $quantity = $validated['quantity'];

        // Compute discount_price correctly
        $discountPrice = 0;
        $discountPercent = null;

        if (!empty($validated['discount_value'])) {
            if ($validated['discount_type'] === 'percent') {
                $discountPercent = $validated['discount_value'];
                $discountPrice = ($discountPercent / 100) * ($price * $quantity);
            } else {
                $discountPrice = $validated['discount_value'];
            }
        }

        // Compute subtotal
        $subTotal = ($price * $quantity) - $discountPrice;

        // Save the item
        $item = InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'discount_price' => round($discountPrice, 2), // store as decimal
            'sub_total' => round($subTotal, 2),
            'created_by' => Auth::id(),
            'created_on' => now(),
        ]);

        // Update invoice totals
        $invoice->total_discount = $invoice->items()->sum('discount_price');
        $invoice->total_amount = $invoice->items()->sum('sub_total');
        $invoice->save();

        DB::commit();

        // Return item with all necessary info for UI
        return response()->json([
            'success' => true,
            'message' => 'Item added successfully',
            'item' => [
                'id' => $item->id,
                'discount_price' => $item->discount_price,
                'sub_total' => $item->sub_total,
                'discount_percent' => $discountPercent
            ]
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Add invoice item error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}




    public function deleteItem($itemId)
    {
        try {
            $item = InvoiceItem::findOrFail($itemId);
            $invoice = $item->invoice;

            DB::beginTransaction();
            $item->delete();

            // Recompute totals
            $invoice->total_discount = $invoice->items()->sum('discount_price');
            $invoice->total_amount = $invoice->items()->sum('sub_total');
            $invoice->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
        } catch(Exception $e) {
            DB::rollBack();
            Log::error('Delete invoice item error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
