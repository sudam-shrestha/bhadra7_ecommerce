<x-frontend-layout>

    <section class="bg-linear-to-br from-(--secondary)/10 via-white to-(--primary)/10">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-14 lg:grid-cols-5 lg:py-20">

            {{-- Left: why sell --}}
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Open your shop on <span
                        class="text-(--primary)">CodeIT Dokan</span></h1>
                <p class="mt-4 leading-relaxed text-gray-600">
                    Tell us about your business. We review every request, then email you once your shop is approved.
                </p>

                <ul class="mt-8 space-y-5">
                    @foreach ([['fa-box-open', 'Manage your products', 'Add products with variants, prices and discounts.'], ['fa-bell', 'Get orders instantly', 'See new orders from your dashboard.'], ['fa-wallet', 'Paid through Khalti', 'Customers pay online, so you ship with confidence.']] as [$icon, $title, $text])
                        <li class="flex items-start gap-4">
                            <span
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-(--secondary)/10 text-(--secondary)">
                                <i class="fa-solid {{ $icon }}"></i>
                            </span>
                            <div>
                                <h3 class="font-semibold">{{ $title }}</h3>
                                <p class="text-sm text-gray-500">{{ $text }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 rounded-2xl bg-white p-5 text-sm shadow-sm ring-1 ring-gray-200">
                    <p class="font-semibold">Already approved?</p>
                    <p class="mt-1 text-gray-500">Log in to your merchant dashboard <a href="{{ url('/merchant') }}"
                            class="font-semibold text-(--primary) hover:underline">here</a>.</p>
                </div>
            </div>

            {{-- Right: form --}}
            <div class="lg:col-span-3">
                <div class="rounded-3xl bg-white p-6 shadow-xl ring-1 ring-gray-200 sm:p-10">
                    <h2 class="text-2xl font-bold">Merchant registration</h2>
                    <p class="mt-1 text-sm text-gray-500">All fields are required.</p>

                    <form action="{{ route('merchant.register.store') }}" method="POST"
                        class="mt-8 grid gap-5 sm:grid-cols-2">
                        @csrf

                        @php
                            $input =
                                'mt-1.5 w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-(--primary) focus:ring-2 focus:ring-(--primary)/20';
                        @endphp

                        <div>
                            <label for="name" class="text-sm font-medium">Your full name</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                                autocomplete="name" class="{{ $input }}">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shop_name" class="text-sm font-medium">Shop name</label>
                            <input id="shop_name" name="shop_name" type="text" value="{{ old('shop_name') }}"
                                required class="{{ $input }}">
                            @error('shop_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="text-sm font-medium">Email address</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                autocomplete="email" class="{{ $input }}">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact" class="text-sm font-medium">Phone number</label>
                            <input id="contact" name="contact" type="tel" value="{{ old('contact') }}" required
                                autocomplete="tel" class="{{ $input }}">
                            @error('contact')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="flex items-start gap-3 text-sm sm:col-span-2">
                            <input type="checkbox" name="terms" required
                                class="mt-0.5 h-4 w-4 rounded border-gray-300 accent-(--primary)">
                            <span class="text-gray-600">I agree to the <a href="#"
                                    class="font-medium text-(--primary) hover:underline">terms of service</a> and
                                understand my shop goes live after admin approval.</span>
                        </label>

                        <button type="submit"
                            class="rounded-full bg-(--primary) px-8 py-3.5 font-semibold text-white shadow-lg shadow-(--primary)/30 hover:brightness-95 sm:col-span-2">
                            Send registration request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-frontend-layout>
