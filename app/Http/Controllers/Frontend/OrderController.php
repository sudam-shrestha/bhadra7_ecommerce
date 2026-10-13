<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            'payment_method' => ['required', Rule::in(['cod', 'khalti'])],
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

        if ($order->payment_method === 'khalti') {
            return $this->startKhalti($order);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', "Order {$order->order_number} placed with {$merchant->shop_name}.");
    }

    /**
     * Retry payment for an existing unpaid Khalti order.
     */
    public function pay(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        if ($order->payment_method !== 'khalti' || $order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order);
        }

        return $this->startKhalti($order);
    }

    /**
     * Khalti redirects the customer here after payment.
     * We never trust the query string, we confirm with Khalti's lookup API.
     */
    public function khalti_callback(Request $request)
    {
        $pidx  = $request->query('pidx');
        $order = $pidx ? Order::where('khalti_pidx', $pidx)->first() : null;

        abort_unless($order, 404);

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)->with('success', 'Payment already received.');
        }

        try {
            $lookup = $this->khalti()->post('/epayment/lookup/', ['pidx' => $pidx]);
        } catch (ConnectionException $e) {
            report($e);

            return redirect()->route('orders.show', $order)
                ->with('error', 'We could not confirm your payment right now. Please check again in a moment.');
        }

        if (!$lookup->successful()) {
            Log::warning('Khalti lookup failed', ['order' => $order->id, 'body' => $lookup->body()]);

            return redirect()->route('orders.show', $order)
                ->with('error', 'We could not confirm your payment. If money was deducted, contact support.');
        }

        $status   = $lookup->json('status');
        $expected = $this->toPaisa($order->total_amount);

        if ($status === 'Completed' && (int) $lookup->json('total_amount') === $expected) {
            $order->update([
                'payment_status'        => 'paid',
                'khalti_transaction_id' => $lookup->json('transaction_id'),
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', "Payment received. Thank you! Order {$order->order_number} is confirmed.");
        }

        $message = match ($status) {
            'Pending', 'Initiated' => 'Your payment is still being processed. Please check again shortly.',
            'User canceled'        => 'You cancelled the payment. You can pay again from this page.',
            'Expired'              => 'The payment link expired. You can pay again from this page.',
            default                => 'Payment was not completed. You can try again from this page.',
        };

        return redirect()->route('orders.show', $order)->with('error', $message);
    }

    private function startKhalti(Order $order)
    {
        try {
            $response = $this->khalti()->post('/epayment/initiate/', [
                'return_url'          => route('khalti_callback'),
                'website_url'         => config('app.url'),
                'amount'              => $this->toPaisa($order->total_amount),
                'purchase_order_id'   => (string) $order->id,
                'purchase_order_name' => "Order {$order->order_number}",
                'customer_info'       => [
                    'name'  => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => preg_replace('/\D/', '', $order->contact_no),
                ],
            ]);
        } catch (ConnectionException $e) {
            report($e);
            $response = null;
        }

        if ($response && $response->successful() && $response->json('payment_url')) {
            $order->update(['khalti_pidx' => $response->json('pidx')]);

            return redirect()->away($response->json('payment_url'));
        }

        if ($response) {
            Log::warning('Khalti initiate failed', ['order' => $order->id, 'body' => $response->body()]);
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Your order was placed, but we could not start the Khalti payment. Please try paying again.');
    }

    private function khalti(): PendingRequest
    {
        return Http::baseUrl(rtrim(config('services.khalti.base_url'), '/'))
            ->withHeaders(['Authorization' => 'Key ' . config('services.khalti.secret')])
            ->acceptJson()
            ->timeout(15);
    }

    // Khalti works in paisa (Rs. 1 = 100 paisa), as an integer
    private function toPaisa($amount): int
    {
        return (int) round((float) $amount * 100);
    }

    private function cartFor(Merchant $merchant)
    {
        return Auth::user()->carts()
            ->where('merchant_id', $merchant->id)
            ->with('product_variant.product')
            ->get();
    }
}

