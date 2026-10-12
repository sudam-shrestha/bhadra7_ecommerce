<x-frontend-layout>
    {{--
    <button
        class="bg-linear-to-br from-blue-600 via-purple-500 to-red-500 text-white font-semibold px-7 py-3 rounded-lg hover:opacity-90 active:scale-95 transition-all duration-200">
        Click Me
    </button> --}}

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 lg:grid-cols-2 lg:py-24">
            <div>
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-1.5 text-sm font-medium shadow-sm ring-1 ring-gray-200">
                    <span class="h-2 w-2 rounded-full bg-(--secondary)"></span> New shops join every week
                </span>
                <h1 class="mt-5 text-4xl leading-tight font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    Buy from many local shops, <span class="text-(--primary)">in one cart.</span>
                </h1>
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-gray-600">
                    CodeIT Dokan brings trusted merchants together. Compare products, order in minutes and pay safely
                    with Khalti.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#products"
                        class="rounded-full bg-(--primary) px-7 py-3.5 font-semibold text-white shadow-lg shadow-(--primary)/30 hover:brightness-95">Shop
                        products</a>
                    <a href="{{ route('merchant.register') }}"
                        class="rounded-full border border-(--secondary) px-7 py-3.5 font-semibold text-(--secondary) hover:bg-(--secondary) hover:text-white">Open
                        your shop</a>
                </div>
                <dl class="mt-10 grid max-w-md grid-cols-3 gap-6 text-sm">
                    <dl class="mt-10 grid max-w-md grid-cols-2 gap-6 text-sm">
                        <div>
                            <dt class="text-gray-500">Merchants</dt>
                            <dd class="text-2xl font-bold">{{ number_format($stats['merchants']) }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Products</dt>
                            <dd class="text-2xl font-bold">{{ number_format($stats['products']) }}</dd>
                        </div>
                    </dl>
                    <div>
                        <dt class="text-gray-500">Happy buyers</dt>
                        <dd class="text-2xl font-bold">8,000+</dd>
                    </div>
                </dl>
            </div>

            {{-- Hero visual built with simple tiles --}}
            <div class="grid grid-cols-2 gap-4 sm:gap-5">
                <div class="flex aspect-square flex-col justify-end rounded-3xl bg-(--primary) p-6 text-white">
                    <i class="fa-solid fa-shirt text-4xl"></i>
                    <p class="mt-3 text-lg font-semibold">Fashion</p>
                </div>
                <div class="mt-8 flex aspect-square flex-col justify-end rounded-3xl bg-(--secondary) p-6 text-white">
                    <i class="fa-solid fa-leaf text-4xl"></i>
                    <p class="mt-3 text-lg font-semibold">Fresh and organic</p>
                </div>
                <div class="-mt-8 flex aspect-square flex-col justify-end rounded-3xl bg-(--text) p-6 text-white">
                    <i class="fa-solid fa-headphones text-4xl"></i>
                    <p class="mt-3 text-lg font-semibold">Electronics</p>
                </div>
                <div
                    class="flex aspect-square flex-col justify-end rounded-3xl bg-white p-6 shadow-xl ring-1 ring-gray-200">
                    <i class="fa-solid fa-gift text-4xl text-(--primary)"></i>
                    <p class="mt-3 text-lg font-semibold">Gifts and crafts</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Trust strip --}}
    <section class="border-y border-gray-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([['fa-store', 'Verified merchants', 'Every shop is approved by our team'], ['fa-credit-card', 'Pay with Khalti', 'Fast and secure online payment'], ['fa-truck-fast', 'Quick delivery', 'Shipped straight from the seller'], ['fa-headset', 'Friendly support', 'We help before and after your order']] as [$icon, $title, $text])
                <div class="flex items-start gap-4">
                    <span
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-(--primary)/10 text-(--primary)">
                        <i class="fa-solid {{ $icon }} text-lg"></i>
                    </span>
                    <div>
                        <h3 class="font-semibold">{{ $title }}</h3>
                        <p class="text-sm text-gray-500">{{ $text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Products --}}
    <section id="products" class="mx-auto max-w-7xl scroll-mt-28 px-4 py-16 lg:py-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight">Latest products</h2>
                <p class="mt-2 text-gray-500">Freshly added by our verified shops.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-(--primary) hover:underline">View
                all products</a>
        </div>

        @if (count($products) == 0)
            <div class="mt-10 rounded-3xl border border-dashed border-gray-300 p-12 text-center text-gray-500">
                No products yet. Please check back soon.
            </div>
        @else
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>
    {{-- About / company details --}}
    <section id="about" class="scroll-mt-28 bg-gray-50">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 lg:grid-cols-2 lg:py-20">
            <div>
                <h2 class="text-3xl font-bold tracking-tight">A marketplace built for local sellers and everyday buyers
                </h2>
                <p class="mt-5 leading-relaxed text-gray-600">
                    CodeIT Dokan started with a simple idea: small shops deserve the same online reach as big brands.
                    We give merchants a place to list products and manage orders, and we give shoppers one trusted place
                    to find them.
                </p>
                <ul class="mt-6 space-y-3">
                    @foreach (['Every merchant is reviewed before their shop goes live', 'One checkout for products from different shops', 'Clear order history so you can track what you bought'] as $point)
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-circle-check mt-1 text-(--secondary)"></i>
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach ([['2024', 'Year we started', 'fa-flag'], ['120+', 'Active merchants', 'fa-store'], ['8,000+', 'Orders delivered', 'fa-box'], ['4.8/5', 'Average rating', 'fa-star']] as [$num, $label, $icon])
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <i class="fa-solid {{ $icon }} text-(--primary)"></i>
                        <p class="mt-4 text-3xl font-extrabold">{{ $num }}</p>
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Merchant CTA --}}
    <section id="sell" class="mx-auto max-w-7xl px-4 py-16 lg:py-20">
        <div class="relative overflow-hidden rounded-[2rem] bg-(--secondary) px-6 py-14 text-white sm:px-12 lg:px-16">
            <div class="pointer-events-none absolute -top-20 -right-20 h-72 w-72 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -bottom-24 right-40 h-56 w-56 rounded-full bg-white/10"></div>

            <div class="relative grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Own a shop? Start selling on Dokan.</h2>
                    <p class="mt-4 max-w-lg text-white/90">
                        Send us your shop details. Once our team approves your request, you will get an email with your
                        merchant login.
                    </p>
                    <a href="{{ route('merchant.register') }}"
                        class="mt-8 inline-block rounded-full bg-white px-8 py-3.5 font-semibold text-(--secondary) shadow-lg hover:bg-gray-100">
                        Register your shop
                    </a>
                </div>
                <ol class="space-y-4">
                    @foreach ([['Send your request', 'Fill in a short form with your shop details'], ['We review it', 'Our admin checks and approves your shop'], ['Start selling', 'Log in, add products and manage orders']] as $i => [$title, $text])
                        <li class="flex items-start gap-4 rounded-2xl bg-white/10 p-4">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white font-bold text-(--secondary)">{{ $i + 1 }}</span>
                            <div>
                                <p class="font-semibold">{{ $title }}</p>
                                <p class="text-sm text-white/80">{{ $text }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

</x-frontend-layout>
