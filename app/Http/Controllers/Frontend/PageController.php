<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\MerchantRegistered;
use App\Models\Admin;
use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home()
    {
        $products = Product::visible()
            ->with(['product_variants', 'merchant'])
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'merchants' => Merchant::where('status', 'approve')->count(),
            'products'  => Product::visible()->count(),
        ];

        return view('frontend.home', compact('products', 'stats'));
    }

    public function products(Request $request)
    {
        $products = Product::visible()
            ->with(['product_variants', 'merchant'])
            ->withMin('product_variants', 'price')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->string('q')->trim();
                $query->where(fn($q) => $q
                    ->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%"));
            })
            ->when($request->filled('merchant'), fn($q) => $q->where('merchant_id', $request->integer('merchant')))
            ->when(
                $request->input('sort'),
                fn($q, $sort) => match ($sort) {
                    'price_asc'  => $q->orderBy('product_variants_min_price'),
                    'price_desc' => $q->orderByDesc('product_variants_min_price'),
                    default      => $q->latest(),
                },
                fn($q) => $q->latest()
            )
            ->paginate(12)
            ->withQueryString();

        $merchants = Merchant::where('status', 'approve')->orderBy('shop_name')->get(['id', 'shop_name']);

        return view('frontend.products.index', compact('products', 'merchants'));
    }

    public function product_show(Product $product)
    {
        $product->load(['product_variants', 'merchant']);

        abort_unless($product->merchant?->status === 'approve' && $product->product_variants->isNotEmpty(), 404);

        $related = Product::visible()
            ->with(['product_variants', 'merchant'])
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'related'));
    }

    public function merchant_register()
    {
        return view('frontend.merchant.register');
    }

    public function merchant_register_store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'shop_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:merchants,email'],
            'contact'   => ['required', 'string', 'max:20'],
            'terms'     => ['accepted'],
        ]);

        $merchant = Merchant::create([
            'name'      => $data['name'],
            'shop_name' => $data['shop_name'],
            'email'     => $data['email'],
            'contact'   => $data['contact']
        ]);

        // Notify every admin. A mail failure must not lose the registration.
        // [{}, {}, {}]
        // ['sudam@gmail.com', 'admin@gmail.com']
        try {
            $adminEmails = Admin::pluck('email')->all();

            if ($adminEmails) {
                Mail::to($adminEmails)->send(new MerchantRegistered($merchant));
            }
        } catch (\Throwable $e) {
            report($e);
            Log::error($e);
        }

        return redirect()
            ->route('merchant.register')
            ->with('success', 'Thank you! Your request has been sent. We will email you once your shop is approved.');
    }
}
