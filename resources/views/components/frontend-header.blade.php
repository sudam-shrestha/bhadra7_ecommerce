<header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">
    {{-- Top info strip --}}
    <div class="hidden bg-(--text) text-xs text-white/80 md:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2">
            <p><i class="fa-solid fa-truck-fast mr-1.5 text-(--primary)"></i> Delivery across Nepal from verified local
                shops</p>
            <p><i class="fa-solid fa-shield-halved mr-1.5 text-(--secondary)"></i> Secure payment with Khalti</p>
        </div>
    </div>

    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="shrink-0">
            <img src="{{ asset('frontend/images/logo.png') }}" alt="CodeIT Dokan" class="h-10 w-auto sm:h-12">
        </a>

        {{-- Desktop navigation --}}
        <nav class="ml-6 hidden items-center gap-1 text-sm font-medium lg:flex">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 hover:bg-gray-100 hover:text-(--primary)">Home</a>
            <a href="{{ route('products.index') }}"
                class="rounded-lg px-3 py-2 hover:bg-gray-100 hover:text-(--primary)">Products</a>
            <a href="{{ route('home') }}#about"
                class="rounded-lg px-3 py-2 hover:bg-gray-100 hover:text-(--primary)">About us</a>
            <a href="{{ route('merchant.register') }}"
                class="rounded-lg px-3 py-2 text-(--secondary) hover:bg-(--secondary)/10">Sell on Dokan</a>
            @auth
                <a href="{{ route('orders.index') }}"
                    class="rounded-lg px-3 py-2 hover:bg-gray-100 hover:text-(--primary)">My orders</a>
            @endauth
        </nav>

        {{-- Search --}}
        <form action="{{ route('products.index') }}" method="GET" class="ml-auto hidden max-w-sm flex-1 md:block">
            <div class="relative">
                <i
                    class="fa-solid fa-magnifying-glass pointer-events-none absolute top-1/2 left-4 -translate-y-1/2 text-sm text-gray-400"></i>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products"
                    class="w-full rounded-full border border-gray-200 bg-gray-50 py-2.5 pr-4 pl-10 text-sm outline-none focus:border-(--primary) focus:bg-white focus:ring-2 focus:ring-(--primary)/20">
            </div>
        </form>

        {{-- Actions --}}
        <div class="ml-auto flex items-center gap-2 md:ml-0">
            @php
                $cartCount = Auth::check() ? Auth::user()->carts()->sum('qty') : 0;
            @endphp
            <a href="{{ route('cart.index') }}" aria-label="Cart"
                class="relative flex h-10 w-10 items-center justify-center rounded-full hover:bg-gray-100">
                <i class="fa-solid fa-cart-shopping text-lg"></i>
                @if ($cartCount > 0)
                    <span
                        class="absolute -top-0.5 -right-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-(--primary) px-1 text-[11px] font-semibold text-white">{{ $cartCount }}</span>
                @endif
            </a>
            @if (!Auth::guard('web')->user())
                <a href="{{ route('login') }}"
                    class="hidden rounded-full px-4 py-2 text-sm font-medium hover:bg-gray-100 sm:block">Log in</a>
            @endif
            <a href="{{ url('/merchant') }}"
                class="hidden rounded-full bg-(--primary) px-5 py-2 text-sm font-semibold text-white shadow-sm hover:brightness-95 sm:block">Merchant
                Login</a>

            {{-- Mobile menu button --}}
            <button id="menu-toggle" type="button" aria-label="Open menu" aria-expanded="false"
                aria-controls="mobile-menu"
                class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-gray-100 lg:hidden">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden border-t border-gray-200 bg-white lg:hidden">
        <div class="mx-auto max-w-7xl space-y-1 px-4 py-4 text-sm font-medium">
            <form action="{{ route('products.index') }}" method="GET" class="mb-3 md:hidden">
                <input type="search" name="q" placeholder="Search products"
                    class="w-full rounded-full border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm outline-none focus:border-(--primary)">
            </form>
            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2.5 hover:bg-gray-100">Home</a>
            <a href="{{ route('products.index') }}" class="block rounded-lg px-3 py-2.5 hover:bg-gray-100">Products</a>
            <a href="{{ route('home') }}#about" class="block rounded-lg px-3 py-2.5 hover:bg-gray-100">About us</a>
            <a href="{{ route('merchant.register') }}"
                class="block rounded-lg px-3 py-2.5 text-(--secondary) hover:bg-(--secondary)/10">Sell on Dokan</a>
            @auth
                <a href="{{ route('orders.index') }}" class="block rounded-lg px-3 py-2.5 hover:bg-gray-100">My orders</a>
            @endauth
            <div class="grid grid-cols-2 gap-3 pt-3 sm:hidden">
                <a href="{{ route('login') }}" class="rounded-full border border-gray-300 py-2.5 text-center">Log
                    in</a>
                <a href="{{ url('/merchant') }}"
                    class="rounded-full bg-(--primary) py-2.5 text-center text-white">Merchant Login</a>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const btn = document.getElementById('menu-toggle');
            const menu = document.getElementById('mobile-menu');
            btn.addEventListener('click', function() {
                const open = menu.classList.toggle('hidden') === false;
                btn.setAttribute('aria-expanded', open);
            });
        })();
    </script>
</header>
