<x-frontend-layout>

    <section class="bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto max-w-6xl px-4 py-12">
            <nav class="text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-(--primary)">Home</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <a href="{{ route('cart.index') }}" class="hover:text-(--primary)">Cart</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-gray-800">Checkout</span>
            </nav>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Checkout</h1>
            <p class="mt-2 text-gray-600">
                Ordering from <span class="font-semibold">{{ $merchant->shop_name }}</span>
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-10">
        @php
            $input =
                'mt-1.5 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-(--primary) focus:ring-2 focus:ring-(--primary)/20';
        @endphp

        <form method="POST" action="{{ route('checkout.store', $merchant) }}" class="grid gap-8 lg:grid-cols-3">
            @csrf

            <div class="space-y-8 lg:col-span-2">

                {{-- Delivery details --}}
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:p-8">
                    <h2 class="text-xl font-bold"><i class="fa-solid fa-location-dot mr-2 text-(--primary)"></i>Delivery
                        details</h2>

                    <div class="mt-6 grid gap-5">
                        <div>
                            <label for="contact_no" class="text-sm font-medium">Contact number</label>
                            <input id="contact_no" name="contact_no" type="tel" required
                                value="{{ old('contact_no') }}" autocomplete="tel"
                                class="{{ $input }} sm:max-w-xs">
                            @error('contact_no')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="text-sm font-medium">Delivery address</label>
                            <textarea id="address" name="address" rows="3" required placeholder="Municipality, ward, street, landmark"
                                class="{{ $input }}">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200 sm:p-8">
                    <h2 class="text-xl font-bold"><i class="fa-solid fa-credit-card mr-2 text-(--primary)"></i>Payment
                        method</h2>

                    <div class="mt-6 space-y-3">
                        {{-- Cash on delivery --}}
                        <label
                            class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-300 p-4 transition has-checked:border-(--primary) has-checked:bg-(--primary)/5 has-checked:ring-2 has-checked:ring-(--primary)/20">
                            <input type="radio" name="payment_method" value="cod" checked
                                class="mt-1 h-4 w-4 accent-(--primary)">
                            <div class="flex-1">
                                <p class="font-semibold">Cash on delivery</p>
                                <p class="text-sm text-gray-500">Pay in cash when your order arrives.</p>
                            </div>
                            <i class="fa-solid fa-money-bill-wave text-2xl text-(--secondary)"></i>
                        </label>
                        <label
                            class="flex cursor-pointer items-start gap-4 rounded-2xl border border-gray-300 p-4 transition has-checked:border-(--primary) has-checked:bg-(--primary)/5 has-checked:ring-2 has-checked:ring-(--primary)/20">
                            <input type="radio" name="payment_method" value="khalti" class="mt-1 h-4 w-4 accent-(--primary)">
                            <div class="flex-1">
                                <p class="font-semibold">
                                    Pay with Khalti
                                </p>
                                <p class="text-sm text-gray-500">Fast and secure online payment.</p>
                            </div>
                            <i class="fa-solid fa-wallet text-2xl text-gray-400"></i>
                        </label>

                        @error('payment_method')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-32 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <h2 class="text-xl font-bold">Order summary</h2>

                    <ul class="mt-5 divide-y divide-gray-100">
                        @foreach ($carts as $item)
                            @php
                                $variant = $item->product_variant;
                                $product = $variant->product;
                                $image = $variant->image_url ?? $product->image_url;
                            @endphp
                            <li class="flex items-center gap-3 py-3">
                                <div
                                    class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-gray-100">
                                    @if ($image)
                                        <img src="{{ $image }}" alt="{{ $product->name }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <i class="fa-solid fa-image text-gray-300"></i>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="line-clamp-1 text-sm font-semibold">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $variant->name }} &times; {{ $item->qty }}
                                    </p>
                                </div>
                                <p class="text-sm font-semibold">Rs.
                                    {{ number_format($variant->final_price * $item->qty) }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="mt-4 space-y-2 border-t border-gray-200 pt-4 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Subtotal</dt>
                            <dd class="font-medium">Rs. {{ number_format($subtotal) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Delivery</dt>
                            <dd class="font-medium">Arranged by seller</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-3 text-base">
                            <dt class="font-semibold">Total</dt>
                            <dd class="text-xl font-extrabold text-(--primary)">Rs. {{ number_format($subtotal) }}</dd>
                        </div>
                    </dl>

                    <button type="submit"
                        class="mt-6 w-full rounded-full bg-(--primary) px-8 py-3.5 font-semibold text-white shadow-lg shadow-(--primary)/30 hover:brightness-95">
                        Place order
                    </button>
                    <a href="{{ route('cart.index') }}"
                        class="mt-3 block text-center text-sm text-gray-500 hover:text-(--primary)">Back to cart</a>
                </div>
            </aside>
        </form>
    </section>

</x-frontend-layout>
