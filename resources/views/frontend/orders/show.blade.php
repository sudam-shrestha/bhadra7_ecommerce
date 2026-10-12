<x-frontend-layout>

    @php
        $steps = ['pending' => 'Order placed', 'processing' => 'Processing', 'completed' => 'Completed'];
        $currentIndex = array_search($order->status, array_keys($steps));
    @endphp

    <section class="bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto max-w-5xl px-4 py-12">
            <nav class="text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-(--primary)">Home</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <a href="{{ route('orders.index') }}" class="hover:text-(--primary)">My orders</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-gray-800">{{ $order->order_number }}</span>
            </nav>
            <div class="mt-3 flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $order->order_number }}</h1>
                <x-order-status :status="$order->status" class="text-sm" />
            </div>
            <p class="mt-2 text-gray-600">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-10">

        {{-- Progress --}}
        <ol class="grid grid-cols-3 gap-2 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
            @foreach ($steps as $key => $label)
                @php $done = $loop->index <= $currentIndex; @endphp
                <li class="text-center">
                    <span
                        class="mx-auto flex h-10 w-10 items-center justify-center rounded-full {{ $done ? 'bg-(--secondary) text-white' : 'bg-gray-100 text-gray-400' }}">
                        <i class="fa-solid {{ $done ? 'fa-check' : 'fa-circle' }} text-sm"></i>
                    </span>
                    <p class="mt-2 text-xs font-medium sm:text-sm {{ $done ? 'text-gray-900' : 'text-gray-400' }}">
                        {{ $label }}</p>
                </li>
            @endforeach
        </ol>

        <div class="mt-8 grid gap-8 lg:grid-cols-3">

            {{-- Items --}}
            <div class="lg:col-span-2">
                <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div
                        class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-5 py-4 sm:px-6">
                        <p class="font-semibold"><i
                                class="fa-solid fa-store mr-2 text-(--secondary)"></i>{{ $order->merchant->shop_name }}
                        </p>
                        <span class="text-sm text-gray-500">{{ $order->order_items->count() }} item(s)</span>
                    </div>

                    <ul class="divide-y divide-gray-100">
                        @foreach ($order->order_items as $item)
                            @php
                                $variant = $item->product_variant;
                                $product = $variant->product;
                                $image = $variant->image_url ?? $product->image_url;
                            @endphp
                            <li class="flex items-center gap-4 px-5 py-5 sm:px-6">
                                <a href="{{ route('products.show', $product) }}"
                                    class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gray-100">
                                    @if ($image)
                                        <img src="{{ $image }}" alt="{{ $product->name }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <i class="fa-solid fa-image text-2xl text-gray-300"></i>
                                    @endif
                                </a>
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="line-clamp-1 font-semibold hover:text-(--primary)">{{ $product->name }}</a>
                                    <p class="text-sm text-gray-500">{{ $variant->name }}</p>
                                    <p class="mt-1 text-sm text-gray-500">Rs. {{ number_format($item->price) }} &times;
                                        {{ $item->qty }}</p>
                                </div>
                                <p class="font-semibold">Rs. {{ number_format($item->subtotal) }}</p>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </div>

            {{-- Side info --}}
            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h2 class="font-bold">Payment</h2>
                    <dl class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Method</dt>
                            <dd class="font-medium">{{ $order->payment_method_label }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Status</dt>
                            <dd
                                class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-amber-600' }}">
                                {{ ucfirst($order->payment_status) }}</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-3 text-base">
                            <dt class="font-semibold">Total</dt>
                            <dd class="text-xl font-extrabold text-(--primary)">Rs.
                                {{ number_format($order->total_amount) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h2 class="font-bold">Delivery</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div>
                            <dt class="text-gray-500">Contact number</dt>
                            <dd class="font-medium">{{ $order->contact_no }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Address</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $order->address ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <a href="{{ route('orders.index') }}"
                    class="block rounded-full border border-gray-300 py-3 text-center text-sm font-semibold hover:bg-gray-50">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Back to orders
                </a>
            </aside>
        </div>
    </section>

</x-frontend-layout>
