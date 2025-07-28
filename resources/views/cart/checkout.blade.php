@extends('layouts.app')

@section('title', 'Checkout')
@section('header', 'Complete Your Order')

@section('content')
<div class="bg-white">
    <div class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Checkout</h1>
                
                <form action="{{ route('cart.process-checkout') }}" method="POST" class="mt-8">
                    @csrf
                    
                    <input type="hidden" name="total_amount" value="{{ $total }}">
                    <input type="hidden" name="tax_amount" value="{{ $tax }}">
                    
                    <div class="space-y-6">
                        <!-- Delivery Options -->
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Delivery information</h2>
                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <div class="sm:col-span-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="is_delivery" value="0" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked>
                                        <span class="ml-3 block text-sm font-medium text-gray-700">Pickup</span>
                                    </label>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="is_delivery" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-3 block text-sm font-medium text-gray-700">Delivery (+$5.00)</span>
                                    </label>
                                </div>
                                <div class="sm:col-span-2" id="delivery-address-container" style="display: none;">
                                    <label for="delivery-address" class="block text-sm font-medium text-gray-700">Delivery address</label>
                                    <input type="text" name="delivery_address" id="delivery-address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment -->
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Payment</h2>
                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="payment_method" value="cash" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked>
                                        <span class="ml-3 block text-sm font-medium text-gray-700">Cash</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="payment_method" value="card" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <span class="ml-3 block text-sm font-medium text-gray-700">Credit Card</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">Order summary</h2>
                            <div class="mt-4 bg-gray-50 rounded-lg px-6 py-6">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($cartItems as $item)
                                    <li class="flex py-4">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . $item->menuItem->image) }}" alt="{{ $item->menuItem->name }}" class="w-20 h-20 rounded-md object-cover object-center">
                                        </div>
                                        <div class="ml-6 flex-1 flex flex-col">
                                            <div class="flex">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->menuItem->name }}</h4>
                                                    <p class="mt-1 text-sm text-gray-500">{{ $item->menuItem->description }}</p>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <p class="text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                                    <p class="mt-1 text-sm text-gray-500">${{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                
                                <dl class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">Subtotal</dt>
                                        <dd class="text-sm font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">Tax</dt>
                                        <dd class="text-sm font-medium text-gray-900">${{ number_format($tax, 2) }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                        <dt class="text-base font-medium text-gray-900">Order total</dt>
                                        <dd class="text-base font-medium text-gray-900">${{ number_format($total, 2) }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        <!-- Special Instructions -->
                        <div>
                            <label for="special_instructions" class="block text-sm font-medium text-gray-700">Special instructions</label>
                            <textarea id="special_instructions" name="special_instructions" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="w-full md:w-auto bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-6 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Place Order
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide delivery address based on selection
    document.querySelectorAll('input[name="is_delivery"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('delivery-address-container').style.display = 
                this.value === '1' ? 'block' : 'none';
        });
    });
</script>
@endpush
@endsection