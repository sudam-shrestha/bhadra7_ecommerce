<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $groups = Auth::user()
            ->carts()
            ->with(['product_variant.product', 'merchant'])
            ->get()
            ->groupBy('merchant_id');

        return view('frontend.cart.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'qty'                => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $variant = ProductVariant::with('product.merchant')->findOrFail($data['product_variant_id']);

        abort_unless($variant->product->merchant->status === 'approve', 404);

        // Same variant added twice = increase quantity, not a duplicate row
        $cart = Cart::firstOrNew([
            'user_id'            => Auth::id(),
            'product_variant_id' => $variant->id,
        ]);

        $cart->merchant_id = $variant->product->merchant_id;
        $cart->qty = min(99, ($cart->qty ?? 0) + $data['qty']);
        $cart->save();

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);

        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart->update(['qty' => $data['qty']]);

        return back();
    }

    public function destroy(Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);

        $cart->delete();

        return back()->with('success', 'Item removed.');
    }
}
