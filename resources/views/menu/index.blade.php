@extends('spa')

@section('content')
<div class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-bold">Our Menu</h1>
                    <input type="text" id="menu-search" placeholder="Search menu..." 
                           class="px-4 py-2 border rounded-md">
                </div>

                <div id="menu-container">
                    @include('menu.partials.items', ['categories' => $categories])
                </div>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/app.js'])
@endsection