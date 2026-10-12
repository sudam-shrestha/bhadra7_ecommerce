<footer class="mt-16 bg-(--text) text-gray-300">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <a href="{{ route('home') }}" class="inline-block rounded-lg bg-white px-3 py-2">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="CodeIT Dokan" class="h-9 w-auto">
            </a>
            <p class="mt-4 text-sm leading-relaxed text-gray-400">
                One marketplace for many local shops. Browse, order and pay online, and get it delivered to your door.
            </p>
            <div class="mt-5 flex gap-3">
                <a href="#" aria-label="Facebook"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-(--primary)"><i
                        class="fa-brands fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-(--primary)"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="WhatsApp"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 hover:bg-(--primary)"><i
                        class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-white">Shop</h3>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('home') }}#products" class="hover:text-(--primary)">All products</a></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-(--primary)">My cart</a></li>
                <li><a href="{{ route('orders.index') }}" class="hover:text-(--primary)">Order history</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-(--primary)">Log in</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold text-white">Sell with us</h3>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('merchant.register') }}" class="hover:text-(--primary)">Open your shop</a></li>
                <li><a href="{{ url('/merchant') }}" class="hover:text-(--primary)">Merchant login</a></li>
                <li><a href="{{ route('home') }}#about" class="hover:text-(--primary)">About us</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold text-white">Contact</h3>
            <ul class="mt-4 space-y-3 text-sm">
                <li class="flex gap-3"><i class="fa-solid fa-location-dot mt-1 text-(--primary)"></i> Dharan, Koshi
                    Province, Nepal</li>
                <li class="flex gap-3"><i class="fa-solid fa-phone mt-1 text-(--primary)"></i> +977 98XXXXXXXX</li>
                <li class="flex gap-3"><i class="fa-solid fa-envelope mt-1 text-(--primary)"></i>
                    support@codeitdokan.com</li>
            </ul>
            <div class="mt-5 inline-flex items-center gap-2 rounded-lg bg-white/10 px-3 py-2 text-xs">
                <i class="fa-solid fa-lock text-(--secondary)"></i> Payments secured by Khalti
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div
            class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-5 text-xs text-gray-400 sm:flex-row">
            <p>&copy; {{ date('Y') }} CodeIT Dokan. All rights reserved.</p>
            <div class="flex gap-5">
                <a href="#" class="hover:text-white">Privacy policy</a>
                <a href="#" class="hover:text-white">Terms of service</a>
            </div>
        </div>
    </div>
</footer>
