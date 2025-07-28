@extends('layouts.spa')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="md:flex gap-8">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="w-full rounded-lg shadow">
                    </div>
                    <div class="md:w-1/2">
                        <h1 class="text-3xl font-bold mb-2">{{ $menuItem->name }}</h1>
                        <div class="text-xl font-semibold text-indigo-600 mb-4">${{ number_format($menuItem->price, 2) }}</div>
                        <p class="text-gray-700 mb-6">{{ $menuItem->description }}</p>
                        
                        <div class="mb-6">
                            <span class="text-sm text-gray-500">Category:</span>
                            <span class="ml-2 text-gray-700">{{ $menuItem->category->name }}</span>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <input type="number" min="1" value="1" class="w-20 px-3 py-2 border rounded">
                            <button class="bg-indigo-600 text-white py-2 px-6 rounded hover:bg-indigo-700 transition-colors duration-300">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection