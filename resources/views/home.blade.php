@extends('spa')

@section('title', 'Home Page - Restaurant Name')
@section('header', 'Welcome to Restaurant Name')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section aria-labelledby="hero-heading" class="relative bg-gray-900 text-white">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Restaurant dining area" class="w-full h-full object-cover opacity-50">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
            <div class="lg:w-1/2">
                <h1 id="hero-heading" class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    Authentic Cuisine, Unforgettable Experience
                </h1>
                <p class="mt-6 text-xl max-w-3xl">
                    Discover our carefully crafted menu featuring the finest ingredients and traditional recipes with a modern twist.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('menu.index') }}" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Menu
                    </a>
                    <a href="{{ route('reservations.create') }}" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Make Reservation
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section aria-labelledby="categories-heading" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 id="categories-heading" class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Our Specialties
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">
                    Explore our most popular menu categories
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($featuredCategories as $category)
                <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="aspect-w-3 aspect-h-2 bg-gray-200 group-hover:opacity-75">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover object-center">
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <a href="{{ route('menu.index', ['category' => $category->id]) }}" class="focus:outline-none">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $category->name }}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {{ $category->description }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section aria-labelledby="testimonials-heading" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 id="testimonials-heading" class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    What Our Guests Say
                </h2>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($testimonials as $testimonial)
                <blockquote class="bg-gray-50 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="{{ $testimonial->avatar ? asset('storage/' . $testimonial->avatar) : asset('images/default-avatar.jpg') }}" alt="{{ $testimonial->name }}">
                        </div>
                        <div class="ml-4">
                            <div class="text-base font-medium text-gray-900">{{ $testimonial->name }}</div>
                            <div class="text-sm text-gray-500">{{ $testimonial->date->format('F Y') }}</div>
                        </div>
                    </div>
                    <div class="mt-4 text-base text-gray-600">
                        <p>"{{ $testimonial->comment }}"</p>
                    </div>
                </blockquote>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section aria-labelledby="cta-heading" class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 lg:py-24">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h2 id="cta-heading" class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Ready to experience our cuisine?
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg leading-6 text-indigo-200">
                        Book your table now and enjoy an exceptional dining experience.
                    </p>
                </div>
                <div class="mt-8 lg:mt-0">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('reservations.create') }}" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Reserve a Table
                        </a>
                        <a href="{{ route('menu.index') }}" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-800 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Full Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hours & Location -->
    <section aria-labelledby="hours-location-heading" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                <div class="mb-8 lg:mb-0">
                    <h2 id="hours-location-heading" class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Hours & Location
                    </h2>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Opening Hours</h3>
                        <dl class="mt-2 space-y-2">
                            <div class="flex">
                                <dt class="w-32 text-gray-600">Monday - Thursday</dt>
                                <dd class="text-gray-900">11:00 AM - 10:00 PM</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-gray-600">Friday - Saturday</dt>
                                <dd class="text-gray-900">11:00 AM - 11:00 PM</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-gray-600">Sunday</dt>
                                <dd class="text-gray-900">10:00 AM - 9:00 PM</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Our Location</h3>
                    <div class="mt-4 aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215209054345!2d-73.98784468459382!3d40.74844047932881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" 
                            width="600" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            title="Our restaurant location on Google Maps"
                            aria-label="Map showing our restaurant location">
                        </iframe>
                    </div>
                    <p class="mt-4 text-gray-600">
                        123 Restaurant Street, Foodville, NY 10001<br>
                        Phone: (555) 123-4567
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection