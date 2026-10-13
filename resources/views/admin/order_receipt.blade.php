<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #f3f4f6; font-family: 'Segoe UI', Helvetica, Arial, sans-serif; color: #363636; font-size: 14px; }
        .toolbar { max-width: 800px; margin: 24px auto 0; display: flex; justify-content: space-between; gap: 12px; padding: 0 12px; }
        .btn { display: inline-block; border: 0; border-radius: 999px; padding: 10px 22px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; }
        .btn-primary { background: #f85f11; color: #fff; }
        .btn-light { background: #fff; color: #363636; border: 1px solid #d1d5db; }
        .sheet { position: relative; max-width: 800px; margin: 16px auto 40px; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 40px; overflow: hidden; }
        .head { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; border-bottom: 2px solid #f85f11; padding-bottom: 20px; }
        .head img { height: 44px; width: auto; }
        .head h1 { margin: 0; font-size: 26px; text-align: right; }
        .head p { margin: 4px 0 0; color: #6b7280; text-align: right; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px; }
        .box h3 { margin: 0 0 8px; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; }
        .box p { margin: 3px 0; }
        .badge { display: inline-block; border-radius: 999px; padding: 3px 12px; font-size: 12px; font-weight: 700; background: #fff1e8; color: #f85f11; }
        .badge.green { background: #e6f6ec; color: #04a53f; }
        table { width: 100%; border-collapse: collapse; margin-top: 28px; }
        th { text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; border-bottom: 1px solid #e5e7eb; padding: 10px 8px; }
        td { padding: 12px 8px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .r { text-align: right; }
        .muted { color: #6b7280; font-size: 12px; }
        .total { display: flex; justify-content: flex-end; margin-top: 16px; }
        .total div { min-width: 260px; }
        .total .row { display: flex; justify-content: space-between; padding: 6px 0; }
        .total .grand { border-top: 2px solid #363636; margin-top: 6px; padding-top: 10px; font-size: 18px; font-weight: 800; }
        .foot { margin-top: 36px; text-align: center; color: #6b7280; font-size: 12px; }
        .stamp { position: absolute; top: 120px; right: 40px; transform: rotate(-12deg); border: 3px solid #04a53f; color: #04a53f; font-size: 28px; font-weight: 800; letter-spacing: .1em; padding: 4px 18px; border-radius: 8px; opacity: .25; }

        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
            .sheet { padding: 20px; }
        }

        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .sheet { margin: 0; border: 0; border-radius: 0; max-width: none; padding: 0; }
            .stamp { opacity: .35; }
            @page { margin: 14mm; }
        }
    </style>
</head>

<body>

    <div class="toolbar">
        <button type="button" class="btn btn-light" onclick="window.close()">Close</button>
        <button type="button" class="btn btn-primary" onclick="window.print()">Print receipt</button>
    </div>

    <div class="sheet">
        @if ($order->payment_status === 'paid')
            <div class="stamp">PAID</div>
        @endif

        <div class="head">
            <img src="{{ asset('frontend/images/logo.png') }}" alt="CodeIT Dokan">
            <div>
                <h1>Receipt</h1>
                <p>{{ $order->order_number }}</p>
                <p>{{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        <div class="grid">
            <div class="box">
                <h3>Customer</h3>
                <p><strong>{{ $order->user->name }}</strong></p>
                <p>{{ $order->user->email }}</p>
                <p>{{ $order->contact_no }}</p>
                <p style="white-space: pre-line;">{{ $order->address ?? '—' }}</p>
            </div>

            <div class="box">
                <h3>Order</h3>
                <p>Shop: <strong>{{ $order->merchant->shop_name }}</strong></p>
                <p>Status: <span class="badge">{{ ucfirst($order->status) }}</span></p>
                <p>Payment method: <strong>{{ $order->payment_method_label }}</strong></p>
                <p>Payment status:
                    <span class="badge {{ $order->payment_status === 'paid' ? 'green' : '' }}">{{ ucfirst($order->payment_status) }}</span>
                </p>
                @if ($order->khalti_transaction_id)
                    <p class="muted">Khalti txn: {{ $order->khalti_transaction_id }}</p>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="r">Price</th>
                    <th class="r">Qty</th>
                    <th class="r">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->order_items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $item->product_variant->product->name }}</strong>
                            <div class="muted">{{ $item->product_variant->name }}</div>
                        </td>
                        <td class="r">Rs. {{ number_format($item->price, 2) }}</td>
                        <td class="r">{{ $item->qty }}</td>
                        <td class="r">Rs. {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <div>
                <div class="row"><span>Subtotal</span><span>Rs. {{ number_format($order->total_amount, 2) }}</span></div>
                <div class="row"><span>Delivery</span><span>Arranged by seller</span></div>
                <div class="row grand"><span>Total</span><span>Rs. {{ number_format($order->total_amount, 2) }}</span></div>
            </div>
        </div>

        <div class="foot">
            <p>Thank you for shopping on CodeIT Dokan.</p>
            <p>Dharan, Koshi Province, Nepal &middot; support@codeitdokan.com</p>
        </div>
    </div>

    @if (request()->boolean('print'))
        <script>window.addEventListener('load', () => window.print());</script>
    @endif

</body>

</html>
