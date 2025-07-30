<ul class="divide-y divide-gray-200">
    @foreach($orders as $order)
    <li class="order-item py-4 px-4 hover:bg-gray-50 cursor-pointer" data-order-id="{{ $order->id }}">
        <div class="flex items-center justify-between">
            <div class="flex items-center min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-lg font-medium text-indigo-600 truncate">
                        Order #{{ $order->order_number }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $order->created_at->format('M j, Y \a\t g:i A') }}
                    </p>
                </div>
            </div>
            <div>
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($order->status) }}
                </span>
                <span class="ml-2 text-sm text-gray-500">
                    ${{ number_format($order->total_amount, 2) }}
                </span>
            </div>
        </div>
    </li>
    @endforeach
</ul>