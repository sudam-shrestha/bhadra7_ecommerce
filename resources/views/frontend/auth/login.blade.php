<x-frontend-layout>

    <section class="bg-linear-to-br from-(--primary)/10 via-white to-(--secondary)/10">
        <div class="mx-auto flex max-w-7xl items-center justify-center px-4 py-14 lg:py-24">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl bg-white shadow-xl ring-1 ring-gray-200 lg:grid-cols-2">

                {{-- Left: login card --}}
                <div class="p-6 sm:p-12">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-(--primary)/10 text-(--primary)">
                        <i class="fa-solid fa-user text-xl"></i>
                    </span>

                    <h1 class="mt-6 text-3xl font-extrabold tracking-tight">Welcome to CodeIT Dokan</h1>
                    <p class="mt-2 text-gray-500">
                        Log in to track orders, save your cart and check out faster. New here? Your account is created automatically on your first login.
                    </p>

                    {{-- Errors / status --}}
                    @if (session('error') || $errors->any())
                        <div class="mt-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                            <p>{{ session('error') ?? $errors->first() }}</p>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mt-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                            <i class="fa-solid fa-circle-check mt-0.5"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Google button: change the href to your own route --}}
                    <a href="{{ route('google.redirect') }}"
                        class="mt-8 flex w-full items-center justify-center gap-3 rounded-full border border-gray-300 bg-white px-6 py-3.5 font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow-md focus:ring-2 focus:ring-(--primary)/30 focus:outline-none">
                        <svg class="h-5 w-5" viewBox="0 0 48 48" aria-hidden="true">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>
                        Continue with Google
                    </a>

                    <p class="mt-6 text-center text-xs leading-relaxed text-gray-500">
                        By continuing, you agree to our
                        <a href="#" class="font-medium text-(--primary) hover:underline">Terms of service</a>
                        and
                        <a href="#" class="font-medium text-(--primary) hover:underline">Privacy policy</a>.
                    </p>

                    <div class="mt-8 border-t border-gray-200 pt-6 text-sm text-gray-500">
                        Own a shop?
                        <a href="{{ url('/merchant') }}" class="font-semibold text-(--secondary) hover:underline">Merchant login</a>
                        or
                        <a href="{{ route('merchant.register') }}" class="font-semibold text-(--secondary) hover:underline">open your shop</a>.
                    </div>
                </div>

                {{-- Right: benefits panel --}}
                <div class="relative hidden overflow-hidden bg-(--text) p-12 text-white lg:block">
                    <div class="pointer-events-none absolute -top-16 -right-16 h-64 w-64 rounded-full bg-(--primary)/30"></div>
                    <div class="pointer-events-none absolute -bottom-20 -left-10 h-56 w-56 rounded-full bg-(--secondary)/30"></div>

                    <div class="relative">
                        <h2 class="text-2xl font-bold">Shop smarter with one account</h2>
                        <p class="mt-2 text-white/70">Everything you need, from many local shops in one place.</p>

                        <ul class="mt-10 space-y-6">
                            @foreach ([
                                ['fa-cart-shopping', 'One cart, many shops', 'Add items from different merchants and check out once.'],
                                ['fa-clock-rotate-left', 'Order history', 'See what you bought and track every order.'],
                                ['fa-shield-halved', 'Secure and simple', 'No passwords to remember. Pay safely with Khalti.'],
                            ] as [$icon, $title, $text])
                                <li class="flex items-start gap-4">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-(--secondary)">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </span>
                                    <div>
                                        <h3 class="font-semibold">{{ $title }}</h3>
                                        <p class="text-sm text-white/70">{{ $text }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-frontend-layout>
