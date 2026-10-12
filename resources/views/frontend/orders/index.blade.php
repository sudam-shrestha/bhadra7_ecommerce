<x-frontend-layout>

    <section class="bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto max-w-5xl px-4 py-12">
            <nav class="text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-(--primary)">Home</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-gray-800">My orders</span>
            </nav>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Order history</h1>
            <p class="mt-2 text-gray-600">Track everything you have ordered from our shops.</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-10">
        @if ($orders->isEmpty())
            <div class="rounded-3xl border border-dashed border-gray-300 p-14 text-center">
                <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                <h2 class="mt-4 text-lg font-semibold">No orders yet</h2>
                <p class="mt-1 text-sm text-gray-500">When you place an order, it will show up here.</p>
                <a href="{{ route('products.index') }}"
                    class="mt-6 inline-block rounded-full bg-(--primary) px-7 py-3 font-semibold text-white hover:brightness-95">Browse
                    products</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', $order) }}"
                        class="block rounded-3xl bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:shadow-lg sm:p-6">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="font-bold">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <x-order-status :status="$order->status" />
                        </div>

                        <div class="mt-4 flex flex-wrap items-end justify-between gap-4">
                            <div class="text-sm text-gray-600">
                                <p><i
                                        class="fa-solid fa-store mr-1.5 text-(--secondary)"></i>{{ $order->merchant->shop_name }}
                                </p>
                                <p class="mt-1">{{ $order->order_items_count }} item(s) &middot;
                                    {{ $order->payment_method_label }}
                                    &middot;
                                    <span
                                        class="{{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-amber-600' }}">{{ ucfirst($order->payment_status) }}</span>
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <p class="text-xl font-extrabold text-(--primary)">Rs.
                                    {{ number_format($order->total_amount) }}</p>
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-(--text) text-white">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $orders->links() }}
            </div>
        @endif
    </section>

</x-frontend-layout>
