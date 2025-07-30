<div class="space-y-6">
    <!-- Order Header -->
    <div class="border-b border-gray-200 pb-4">
        <h2 class="text-2xl font-bold">Order #{{ $order->order_number }}</h2>
        <p class="text-gray-500">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <!-- Order Items -->
    <div class="space-y-4">
        <h3 class="text-lg font-medium">Items</h3>
        <ul class="divide-y divide-gray-200">
            @foreach($order->items as $item)
            <li class="py-4 flex">
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $item->menuItem->image) }}" 
                         class="w-16 h-16 rounded-md object-cover">
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="text-base font-medium">{{ $item->menuItem->name }}</h4>
                    <p class="text-sm text-gray-500">${{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                </div>
                <div class="ml-4">
                    <p class="text-base font-medium">${{ number_format($item->price * $item->quantity, 2) }}</p>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

    <!-- Order Summary -->
    <div class="border-t border-gray-200 pt-4">
        <h3 class="text-lg font-medium">Summary</h3>
        <div class="mt-2 space-y-2">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->delivery_fee > 0)
            <div class="flex justify-between">
                <span>Delivery Fee</span>
                <span>${{ number_format($order->delivery_fee, 2) }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span>Tax</span>
                <span>${{ number_format($order->tax_amount, 2) }}</span>
            </div>
            <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                <span class="font-medium">Total</span>
                <span class="font-medium">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
    </div>
</div>