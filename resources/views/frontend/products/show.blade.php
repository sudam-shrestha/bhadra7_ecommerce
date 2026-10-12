@php
    $variants = $product->product_variants->sortBy('final_price')->values();
    $first = $variants->first();

    $variantData = $variants
        ->map(
            fn($v) => [
                'id' => $v->id,
                'name' => $v->name,
                'price' => (float) $v->price,
                'final' => $v->final_price,
                'discount' => (float) $v->discount,
                'percent' => $v->discount_percent,
                'img' => $v->image_url ?? $product->image_url,
            ],
        )
        ->all();

    // Thumbnails: product image + any distinct variant images
    $gallery = collect([$product->image_url])
        ->merge($variants->map->image_url)
        ->filter()
        ->unique()
        ->values();

    // Merchant-written HTML: keep basic formatting only, no links/scripts
    $description = strip_tags(
        $product->description,
        '<p><br><strong><em><b><i><u><s><ul><ol><li><h2><h3><h4><blockquote>',
    );
@endphp

<x-frontend-layout>

    <div class="mx-auto max-w-7xl px-4 pt-8">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-(--primary)">Home</a>
            <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
            <a href="{{ route('products.index') }}" class="hover:text-(--primary)">Products</a>
            <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
            <span class="text-gray-800">{{ $product->name }}</span>
        </nav>
    </div>

    <section class="mx-auto grid max-w-7xl gap-10 px-4 py-8 lg:grid-cols-2 lg:gap-14">

        {{-- Gallery --}}
        <div>
            <div
                class="flex aspect-square items-center justify-center overflow-hidden rounded-3xl bg-gray-100 ring-1 ring-gray-200">
                @if ($gallery->isNotEmpty())
                    <img id="main-image" src="{{ $gallery->first() }}" alt="{{ $product->name }}"
                        class="h-full w-full object-cover">
                @else
                    <i class="fa-solid fa-image text-8xl text-gray-300"></i>
                @endif
            </div>

            @if ($gallery->count() > 1)
                <div class="mt-4 grid grid-cols-5 gap-3">
                    @foreach ($gallery as $url)
                        <button type="button" data-thumb="{{ $url }}"
                            class="aspect-square overflow-hidden rounded-2xl ring-1 ring-gray-200 hover:ring-2 hover:ring-(--primary)">
                            <img src="{{ $url }}" alt="" class="h-full w-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Details --}}
        <div>
            <p class="text-sm text-gray-500">
                <i class="fa-solid fa-store mr-1.5 text-(--secondary)"></i>Sold by
                <a href="{{ route('products.index', ['merchant' => $product->merchant_id]) }}"
                    class="font-semibold text-(--secondary) hover:underline">{{ $product->merchant->shop_name }}</a>
            </p>

            <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="mt-5 flex flex-wrap items-baseline gap-3">
                <span id="price-final" class="text-3xl font-extrabold text-(--primary)">Rs.
                    {{ number_format($first->final_price) }}</span>
                <span id="price-old"
                    class="{{ $first->discount > 0 ? '' : 'hidden' }} text-lg text-gray-400 line-through">Rs.
                    {{ number_format($first->price) }}</span>
                <span id="price-badge"
                    class="{{ $first->discount > 0 ? '' : 'hidden' }} rounded-full bg-(--primary)/10 px-3 py-1 text-sm font-semibold text-(--primary)">{{ $first->discount_percent }}%
                    off</span>
            </div>

            {{-- Variants --}}
            <div class="mt-8">
                <p class="text-sm font-semibold">Choose an option: <span id="variant-name"
                        class="font-normal text-gray-500">{{ $first->name }}</span></p>
                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach ($variants as $i => $v)
                        <button type="button" data-variant="{{ $i }}"
                            class="variant-btn rounded-xl border px-4 py-2.5 text-sm font-medium transition {{ $i === 0 ? 'border-(--primary) bg-(--primary)/10 ring-2 ring-(--primary)/20' : 'border-gray-300 hover:border-(--primary)' }}">
                            {{ $v->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Quantity + cart --}}
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <div class="flex items-center rounded-full border border-gray-300">
                    <button type="button" id="qty-minus" aria-label="Decrease quantity"
                        class="flex h-12 w-12 items-center justify-center rounded-full hover:bg-gray-100"><i
                            class="fa-solid fa-minus text-sm"></i></button>
                    <input id="qty" type="number" min="1" max="99" value="1" readonly
                        class="w-10 border-0 bg-transparent text-center font-semibold outline-none">
                    <button type="button" id="qty-plus" aria-label="Increase quantity"
                        class="flex h-12 w-12 items-center justify-center rounded-full hover:bg-gray-100"><i
                            class="fa-solid fa-plus text-sm"></i></button>
                </div>

                <form method="POST" action="{{ route('cart.store') }}" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="product_variant_id" id="cart-variant" value="{{ $first->id }}">
                    <input type="hidden" name="qty" id="cart-qty" value="1">
                    <button type="submit"
                        class="w-full rounded-full bg-(--primary) px-8 py-3.5 font-semibold text-white shadow-lg shadow-(--primary)/30 hover:brightness-95">
                        <i class="fa-solid fa-cart-plus mr-2"></i>Add to cart
                    </button>
                </form>
            </div>

            <p class="mt-3 text-sm text-gray-500">Total: <span id="total" class="font-semibold text-gray-800">Rs.
                    {{ number_format($first->final_price) }}</span></p>

            {{-- Perks --}}
            <ul class="mt-8 grid gap-3 rounded-3xl bg-gray-50 p-5 text-sm sm:grid-cols-2">
                <li class="flex items-center gap-3"><i class="fa-solid fa-circle-check text-(--secondary)"></i> Verified
                    merchant</li>
                <li class="flex items-center gap-3"><i class="fa-solid fa-credit-card text-(--secondary)"></i> Pay
                    securely with Khalti</li>
                <li class="flex items-center gap-3"><i class="fa-solid fa-truck-fast text-(--secondary)"></i> Delivery
                    across Nepal</li>
                <li class="flex items-center gap-3"><i class="fa-solid fa-headset text-(--secondary)"></i> Friendly
                    support</li>
            </ul>
        </div>
    </section>

    {{-- Description --}}
    <section class="mx-auto max-w-7xl px-4 pb-6">
        <div class="rounded-3xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
            <h2 class="text-xl font-bold">About this product</h2>
            <div
                class="mt-4 leading-relaxed text-gray-600 [&_blockquote]:border-l-4 [&_blockquote]:border-gray-300 [&_blockquote]:pl-4 [&_h2]:mt-4 [&_h2]:text-lg [&_h2]:font-bold [&_h3]:mt-4 [&_h3]:font-semibold [&_li]:mb-1 [&_ol]:mb-3 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:mb-3 [&_ul]:mb-3 [&_ul]:list-disc [&_ul]:pl-6">
                {!! $description !!}
            </div>
        </div>
    </section>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-12">
            <div class="flex items-end justify-between">
                <h2 class="text-2xl font-bold tracking-tight">You may also like</h2>
                <a href="{{ route('products.index') }}"
                    class="text-sm font-semibold text-(--primary) hover:underline">View all</a>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </section>
    @endif

    <script>
        (function() {
            const variants = @json($variantData);
            const fmt = n => 'Rs. ' + Math.round(n).toLocaleString('en-US');
            const on = 'border-(--primary) bg-(--primary)/10 ring-2 ring-(--primary)/20'.split(' ');
            const off = 'border-gray-300 hover:border-(--primary)'.split(' ');

            let current = 0;
            const qty = document.getElementById('qty');
            const mainImage = document.getElementById('main-image');

            function render() {
                const v = variants[current];
                document.getElementById('price-final').textContent = fmt(v.final);
                document.getElementById('price-old').textContent = fmt(v.price);
                document.getElementById('price-old').classList.toggle('hidden', v.discount <= 0);
                document.getElementById('price-badge').textContent = v.percent + '% off';
                document.getElementById('price-badge').classList.toggle('hidden', v.discount <= 0);
                document.getElementById('variant-name').textContent = v.name;
                document.getElementById('total').textContent = fmt(v.final * Number(qty.value));
                document.getElementById('cart-variant').value = v.id;
                document.getElementById('cart-qty').value = qty.value;
                if (mainImage && v.img) mainImage.src = v.img;

                document.querySelectorAll('.variant-btn').forEach((btn, i) => {
                    btn.classList.remove(...on, ...off);
                    btn.classList.add(...(i === current ? on : off));
                });
            }

            document.querySelectorAll('.variant-btn').forEach(btn =>
                btn.addEventListener('click', () => {
                    current = Number(btn.dataset.variant);
                    render();
                }));

            document.querySelectorAll('[data-thumb]').forEach(btn =>
                btn.addEventListener('click', () => {
                    if (mainImage) mainImage.src = btn.dataset.thumb;
                }));

            document.getElementById('qty-minus').addEventListener('click', () => {
                qty.value = Math.max(1, Number(qty.value) - 1);
                render();
            });
            document.getElementById('qty-plus').addEventListener('click', () => {
                qty.value = Math.min(99, Number(qty.value) + 1);
                render();
            });
        })();
    </script>

</x-frontend-layout>
