<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('merchant')
            ->withCount('order_items')
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load(['merchant', 'order_items.product_variant.product']);

        return view('frontend.orders.show', compact('order'));
    }

    public function checkout(Merchant $merchant)
    {
        abort_unless($merchant->status === 'approve', 404);

        $carts = $this->cartFor($merchant);

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'No items to order from this shop.');
        }

        $subtotal = $carts->sum(fn($c) => $c->product_variant->final_price * $c->qty);

        return view('frontend.checkout.show', compact('merchant', 'carts', 'subtotal'));
    }

    public function store(Request $request, Merchant $merchant)
    {
        abort_unless($merchant->status === 'approve', 404);

        $data = $request->validate([
            'contact_no'     => ['required', 'string', 'max:20'],
            'address'        => ['required', 'string', 'max:500'],
            // Only COD for now. Add 'khalti' here when the integration is ready.
            'payment_method' => ['required', Rule::in(['cod'])],
        ]);

        $carts = $this->cartFor($merchant);

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'No items to order from this shop.');
        }

        $order = DB::transaction(function () use ($carts, $merchant, $data) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'merchant_id'    => $merchant->id,
                'contact_no'     => $data['contact_no'],
                'address'        => $data['address'],
                'payment_method' => $data['payment_method'],
                'payment_status' => 'unpaid',
                'total_amount'   => $carts->sum(fn($c) => $c->product_variant->final_price * $c->qty),
            ]);

            $order->order_items()->createMany(
                $carts->map(fn($c) => [
                    'product_variant_id' => $c->product_variant_id,
                    'qty'                => $c->qty,
                    'price'              => $c->product_variant->final_price,
                ])->all()
            );

            // Only this merchant's items leave the cart
            Auth::user()->carts()->where('merchant_id', $merchant->id)->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', "Order {$order->order_number} placed with {$merchant->shop_name}.");
    }

    private function cartFor(Merchant $merchant)
    {
        return Auth::user()->carts()
            ->where('merchant_id', $merchant->id)
            ->with('product_variant.product')
            ->get();
    }
}
