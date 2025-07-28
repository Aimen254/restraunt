@extends('spa')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold mb-8 text-center">Our Menu</h1>

                @foreach($categories as $category)
                    @if($category->menuItems->count() > 0)
                        <div class="mb-12">
                            <h2 class="text-2xl font-semibold mb-4 border-b pb-2">{{ $category->name }}</h2>
                            
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($category->menuItems as $item)
                                    <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300">
                                        <div class="h-48 overflow-hidden">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-between items-start">
                                                <h3 class="font-bold text-lg">{{ $item->name }}</h3>
                                                <span class="font-bold text-indigo-600">${{ number_format($item->price, 2) }}</span>
                                            </div>
                                            <p class="text-gray-600 mt-2">{{ $item->description }}</p>
                                            <form action="{{ route('cart.add', $item) }}" method="POST" class="mt-4">
                                                @csrf
                                                <div class="flex items-center gap-2">
                                                    <input type="number" name="quantity" value="1" min="1" class="w-16 px-2 py-1 border rounded">
                                                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition-colors duration-300">
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
            </div>
        </div>
    </div>
</div>
@endsection