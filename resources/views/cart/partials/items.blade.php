<form action="{{ route('cart.add', $item) }}" method="POST" class="mt-auto add-to-cart-form">
    @csrf
    <div class="flex items-center gap-3">
        <input type="number" 
               name="quantity" 
               value="1" 
               min="1" 
               class="w-2/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base">
        <button type="submit" class="w-1/3 bg-indigo-600 text-white py-2 px-3 rounded-md hover:bg-indigo-700 transition-colors duration-300 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Add to Cart
        </button>
    </div>
</form>