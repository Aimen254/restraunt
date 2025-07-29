@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)
@section('header', 'Order Details')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-50 rounded-lg shadow overflow-hidden">
            <!-- Order Header -->
            <div class="px-6 py-5 border-b border-gray-200 bg-indigo-700 text-white">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h2 class="text-2xl font-bold">Order #{{ $order->order_number }}</h2>
                        <p class="mt-1 text-indigo-100">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Delivery Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Delivery Information</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600">
                                <span class="font-medium">Method:</span> 
                                {{ $order->delivery_fee > 0 ? 'Delivery' : 'Pickup' }}
                            </p>
                            @if($order->delivery_fee > 0)
                            <p class="text-gray-600">
                                <span class="font-medium">Address:</span> 
                                {{ $order->delivery_address }}
                            </p>
                            @endif
                            <p class="text-gray-600">
                                <span class="font-medium">Payment:</span> 
                                {{ ucfirst($order->payment_method) }}
                            </p>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->delivery_fee > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivery Fee</span>
                                <span class="text-gray-900">${{ number_format($order->delivery_fee, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span class="text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                                <span class="text-lg font-medium text-gray-900">Total</span>
                                <span class="text-lg font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t border-gray-200 px-6 py-5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <li class="py-4 flex">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $item->menuItem->image) }}" alt="{{ $item->menuItem->name }}" 
                                 class="w-20 h-20 rounded-md object-cover object-center">
                        </div>
                        <div class="ml-4 flex-1 flex flex-col sm:flex-row justify-between">
                            <div class="pr-4">
                                <h4 class="text-base font-medium text-gray-900">{{ $item->menuItem->name }}</h4>
                                <p class="mt-1 text-sm text-gray-500">{{ $item->menuItem->description }}</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <p class="text-base font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                <p class="mt-1 text-sm text-gray-500">${{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Special Instructions -->
            @if($order->special_instructions)
            <div class="border-t border-gray-200 px-6 py-5 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Special Instructions</h3>
                <p class="text-gray-600">{{ $order->special_instructions }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <a href="{{ route('menu.index') }}" 
                   class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection