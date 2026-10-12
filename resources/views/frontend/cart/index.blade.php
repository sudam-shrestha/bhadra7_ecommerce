<x-frontend-layout>

    <section class="bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto max-w-5xl px-4 py-12">
            <nav class="text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-(--primary)">Home</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-gray-800">Cart</span>
            </nav>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Your cart</h1>
            <p class="mt-2 text-gray-600">Items are grouped by shop. Each shop is ordered separately.</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-10">

        @if ($groups->isEmpty())
            <div class="rounded-3xl border border-dashed border-gray-300 p-14 text-center">
                <i class="fa-solid fa-cart-shopping text-4xl text-gray-300"></i>
                <h2 class="mt-4 text-lg font-semibold">Your cart is empty</h2>
                <p class="mt-1 text-sm text-gray-500">Find something you like and add it here.</p>
                <a href="{{ route('products.index') }}"
                    class="mt-6 inline-block rounded-full bg-(--primary) px-7 py-3 font-semibold text-white hover:brightness-95">Browse
                    products</a>
            </div>
        @else
            <div class="space-y-8">
                @foreach ($groups as $merchantId => $items)
                    @php
                        $merchant = $items->first()->merchant;
                        $subtotal = $items->sum(fn($i) => $i->product_variant->final_price * $i->qty);
                    @endphp

                    <article class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200">

                        {{-- Shop header --}}
                        <div
                            class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-5 py-4 sm:px-6">
                            <p class="font-semibold">
                                <i class="fa-solid fa-store mr-2 text-(--secondary)"></i>{{ $merchant->shop_name }}
                            </p>
                            <span class="text-sm text-gray-500">{{ $items->count() }} item(s)</span>
                        </div>

                        {{-- Items --}}
                        <ul class="divide-y divide-gray-100">
                            @foreach ($items as $item)
                                @php
                                    $variant = $item->product_variant;
                                    $product = $variant->product;
                                    $image = $variant->image_url ?? $product->image_url;
                                @endphp
                                <li class="flex flex-wrap items-center gap-4 px-5 py-5 sm:px-6">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gray-100">
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
                                        <p class="mt-1 text-sm">
                                            <span class="font-semibold text-(--primary)">Rs.
                                                {{ number_format($variant->final_price) }}</span>
                                            @if ($variant->discount > 0)
                                                <span class="ml-1 text-xs text-gray-400 line-through">Rs.
                                                    {{ number_format($variant->price) }}</span>
                                            @endif
                                        </p>
                                    </div>

                                    {{-- Quantity --}}
                                    <form method="POST" action="{{ route('cart.update', $item) }}"
                                        class="flex items-center rounded-full border border-gray-300">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="qty" value="{{ $item->qty - 1 }}"
                                            @disabled($item->qty <= 1) aria-label="Decrease quantity"
                                            class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-gray-100 disabled:opacity-30">
                                            <i class="fa-solid fa-minus text-xs"></i>
                                        </button>
                                        <span class="w-8 text-center text-sm font-semibold">{{ $item->qty }}</span>
                                        <button type="submit" name="qty" value="{{ $item->qty + 1 }}"
                                            @disabled($item->qty >= 99) aria-label="Increase quantity"
                                            class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-gray-100 disabled:opacity-30">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </form>

                                    <p class="w-28 text-right font-semibold">Rs.
                                        {{ number_format($variant->final_price * $item->qty) }}</p>

                                    <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Remove item"
                                            class="flex h-10 w-10 items-center justify-center rounded-full text-gray-400 hover:bg-red-50 hover:text-red-600">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Checkout this shop --}}
                        <div
                            class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-200 bg-gray-50 px-5 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">Subtotal
                                <span class="block text-xl font-extrabold text-gray-900">Rs.
                                    {{ number_format($subtotal) }}</span>
                            </p>
                            <a href="{{ route('checkout.show', $merchant) }}"
                                class="rounded-full bg-(--primary) px-7 py-3 font-semibold text-white shadow-lg shadow-(--primary)/30 hover:brightness-95">
                                Checkout from {{ $merchant->shop_name }}
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

</x-frontend-layout>
