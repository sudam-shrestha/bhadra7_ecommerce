<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderReceiptController extends Controller
{
    public function __invoke(Order $order)
    {
        // Admin guard only. Others go to the Filament admin login.
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        $order->load(['user', 'merchant', 'order_items.product_variant.product']);

        return view('admin.order_receipt', compact('order'));
    }
}
