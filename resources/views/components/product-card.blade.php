@props(['product'])

@php
    $variant = $product->starting_variant;
@endphp

<article class="group overflow-hidden rounded-3xl border border-gray-200 bg-white transition hover:shadow-xl">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="relative flex h-56 items-center justify-center overflow-hidden bg-gray-100">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
            @else
                <i class="fa-solid fa-image text-6xl text-gray-300"></i>
            @endif

            @if ($variant && $variant->discount > 0)
                <span
                    class="absolute top-4 left-4 rounded-full bg-(--primary) px-3 py-1 text-xs font-semibold text-white">
                    {{ $variant->discount_percent }}% off
                </span>
            @endif
        </div>

        <div class="p-5">
            <p class="text-sm text-gray-500">
                <i class="fa-solid fa-store mr-1.5 text-(--secondary)"></i>{{ $product->merchant->shop_name }}
            </p>
            <h3 class="mt-1 line-clamp-1 text-lg font-semibold">{{ $product->name }}</h3>

            <div class="mt-4 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400">From</p>
                    <span class="text-xl font-bold text-(--primary)">Rs.
                        {{ number_format($variant->final_price) }}</span>
                    @if ($variant->discount > 0)
                        <span class="ml-1 text-sm text-gray-400 line-through">Rs.
                            {{ number_format($variant->price) }}</span>
                    @endif
                </div>
                <span
                    class="flex h-11 w-11 items-center justify-center rounded-full bg-(--text) text-white transition group-hover:bg-(--primary)">
                    <i class="fa-solid fa-arrow-right"></i>
                </span>
            </div>

            <p class="mt-3 text-xs text-gray-500">{{ $product->product_variants->count() }} variant(s) available</p>
        </div>
    </a>
</article>
