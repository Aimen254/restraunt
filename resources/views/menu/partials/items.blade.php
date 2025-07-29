@foreach($categories as $category)
    @if($category->menuItems->count() > 0)
        <div class="mb-8 sm:mb-12 menu-category" data-category="{{ strtolower($category->name) }}">
            <h2 class="text-xl sm:text-2xl font-semibold mb-3 sm:mb-4 border-b pb-2">{{ $category->name }}</h2>
            
            <!-- Grid layout with 1 column on mobile, 2 on tablet, 3 on desktop -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                @foreach($category->menuItems as $item)
                    <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                        <!-- Image container with fixed height -->
                        <div class="h-48 overflow-hidden">
                            <img 
                                src="{{ asset('storage/' . $item->image) }}" 
                                alt="{{ $item->name }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        </div>
                        
                        <!-- Card content with equal height -->
                        <div class="p-4 flex-grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-base sm:text-lg">{{ $item->name }}</h3>
                                <span class="font-bold text-indigo-600 whitespace-nowrap ml-2">${{ number_format($item->price, 2) }}</span>
                            </div>
                            <p class="text-gray-600 text-sm sm:text-base mb-4 line-clamp-3">{{ $item->description }}</p>
                            
                            <!-- Add to cart form at bottom -->
                            <form action="{{ route('cart.add', $item) }}" method="POST" class="mt-auto">
                                @csrf
                                <div class="flex items-center gap-3">
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        value="1" 
                                        min="1" 
                                        class="w-2/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                    >
                                    <button 
                                        type="submit" 
                                        class="w-1/3 bg-indigo-600 text-white py-2 px-3 rounded-md hover:bg-indigo-700 transition-colors duration-300 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endforeach