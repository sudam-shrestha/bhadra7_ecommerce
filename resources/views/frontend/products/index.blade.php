<x-frontend-layout>

    <section class="bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto max-w-7xl px-4 py-12">
            <nav class="text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-(--primary)">Home</a>
                <i class="fa-solid fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-gray-800">Products</span>
            </nav>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">All products</h1>
            <p class="mt-2 text-gray-600">Browse items from every approved shop on CodeIT Dokan.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10">

        {{-- Filters --}}
        <form method="GET" action="{{ route('products.index') }}"
            class="grid gap-3 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-gray-200 sm:grid-cols-2 lg:grid-cols-[1fr_220px_200px_auto]">
            <div class="relative">
                <i
                    class="fa-solid fa-magnifying-glass pointer-events-none absolute top-1/2 left-4 -translate-y-1/2 text-sm text-gray-400"></i>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products"
                    class="w-full rounded-xl border border-gray-300 py-3 pr-4 pl-10 text-sm outline-none focus:border-(--primary) focus:ring-2 focus:ring-(--primary)/20">
            </div>

            <select name="merchant"
                class="rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-(--primary)">
                <option value="">All shops</option>
                @foreach ($merchants as $m)
                    <option value="{{ $m->id }}" @selected(request('merchant') == $m->id)>{{ $m->shop_name }}</option>
                @endforeach
            </select>

            <select name="sort"
                class="rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-(--primary)">
                <option value="latest" @selected(request('sort', 'latest') === 'latest')>Newest first</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: low to high</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: high to low</option>
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 rounded-xl bg-(--primary) px-6 py-3 text-sm font-semibold text-white hover:brightness-95">Apply</button>
                @if (request()->hasAny(['q', 'merchant', 'sort']))
                    <a href="{{ route('products.index') }}"
                        class="rounded-xl border border-gray-300 px-4 py-3 text-sm font-medium hover:bg-gray-50">Reset</a>
                @endif
            </div>
        </form>

        <p class="mt-6 text-sm text-gray-500">
            Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
            products
        </p>

        @if ($products->isEmpty())
            <div class="mt-6 rounded-3xl border border-dashed border-gray-300 p-14 text-center">
                <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                <h2 class="mt-4 text-lg font-semibold">No products found</h2>
                <p class="mt-1 text-sm text-gray-500">Try a different search or clear the filters.</p>
            </div>
        @else
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </section>

</x-frontend-layout>
