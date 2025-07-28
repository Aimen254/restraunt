@extends('layouts.app')

@section('title', 'Your Cart')
@section('header', 'Your Shopping Cart')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>

        <div class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
            <section class="lg:col-span-7">
                <ul id="cart-items" class="divide-y divide-gray-200 border-t border-b border-gray-200">
                    @forelse($cartItems as $item)
                    <li class="flex py-6 sm:py-10" id="cart-item-{{ $item->id }}">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $item->menuItem->image) }}" alt="{{ $item->menuItem->name }}" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48">
                        </div>

                        <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                            <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                <div>
                                    <h3 class="text-sm">
                                        <a href="{{ route('menu.show', $item->menuItem) }}" class="font-medium text-gray-700 hover:text-gray-800">{{ $item->menuItem->name }}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $item->menuItem->description }}</p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                    <label for="quantity-{{ $item->id }}" class="sr-only">Quantity</label>
                                    <select id="quantity-{{ $item->id }}" name="quantity-{{ $item->id }}" 
                                            class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                            onchange="updateQuantity({{ $item->id }}, this.value)">
                                        @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>

                                    <div class="absolute top-0 right-0">
                                        <button type="button" class="remove-from-cart -m-2 inline-flex p-2 text-gray-400 hover:text-gray-500" 
                                                onclick="removeItem({{ $item->id }})">
                                            <span class="sr-only">Remove</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-4 flex text-sm text-gray-700">
                                <span>${{ number_format($item->price, 2) }} each</span>
                                <span class="ml-4 border-l border-gray-200 pl-4 text-gray-500">${{ number_format($item->price * $item->quantity, 2) }} total</span>
                            </p>
                        </div>
                    </li>
                    @empty
                    <li class="py-6 text-center">
                        <p class="text-gray-500">Your cart is empty</p>
                        <a href="{{ route('menu.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Continue Shopping
                        </a>
                    </li>
                    @endforelse
                </ul>
            </section>

            <!-- Order summary -->
            @if($cartItems->count() > 0)
            <section class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <dt class="flex items-center text-sm text-gray-600">
                            <span>Tax estimate (10%)</span>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900">${{ number_format($tax, 2) }}</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <dt class="text-base font-medium text-gray-900">Order total</dt>
                        <dd class="text-base font-medium text-gray-900">${{ number_format($total, 2) }}</dd>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('cart.checkout') }}" class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Checkout
                    </a>
                </div>
            </section>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateQuantity(itemId, quantity) {
        fetch(`/cart/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }

    function removeItem(itemId) {
        if (confirm('Are you sure you want to remove this item from your cart?')) {
            fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
</script>
@endpush
@endsection