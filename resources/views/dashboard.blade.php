@extends('spa')

@section('title', 'User Dashboard')
@section('header', 'My Account Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Banner -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-6 py-5 sm:px-8 sm:py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h2>
                        <p class="mt-1 text-gray-600">Here's what's happening with your account today.</p>
                    </div>
                    <div class="ml-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            Member since {{ Auth::user()->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Left Column - Quick Actions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">My Profile</h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-16 w-16 rounded-full" src="{{ Auth::user()->avatar ?? asset('testimonials/avatar1.jpg') }}" alt="User avatar">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Edit Profile
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="px-6 py-4">
                        <nav class="space-y-2">
                            <a href="{{ route('orders.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50">
                                <span class="truncate">My Orders</span>
                                <span class="ml-auto inline-block py-0.5 px-3 text-xs rounded-full bg-gray-100 group-hover:bg-gray-200">
                                    {{ Auth::user()->orders()->count() }}
                                </span>
                            </a>
                            <a href="{{ route('reservations.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50">
                                <span class="truncate">My Reservations</span>
                                <span class="ml-auto inline-block py-0.5 px-3 text-xs rounded-full bg-gray-100 group-hover:bg-gray-200">
                                    {{ Auth::user()->reservations()->count() }}
                                </span>
                            </a>
                            <a href="{{ route('cart.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-50">
                                <span class="truncate">My Cart</span>
                                <span class="ml-auto inline-block py-0.5 px-3 text-xs rounded-full bg-gray-100 group-hover:bg-gray-200">
                                    {{ Auth::user()->cartItems()->count() }}
                                </span>
                            </a>
                           
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Right Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Orders -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
                        <a href="{{ route('orders.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="px-6 py-4">
                        @if($recentOrders->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $order->order_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ${{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by placing your first order.</p>
                                <div class="mt-6">
                                    <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Browse Menu
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Reservations -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Upcoming Reservations</h3>
                        <a href="{{ route('reservations.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="px-6 py-4">
                        @if($upcomingReservations->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($upcomingReservations as $reservation)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-100 text-indigo-800">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                Table for {{ $reservation->party_size }} on {{ $reservation->reservation_date->format('M j, Y') }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $reservation->reservation_time }} • {{ $reservation->status }}
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('reservations.show', $reservation) }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming reservations</h3>
                                <p class="mt-1 text-sm text-gray-500">Book a table to enjoy our dining experience.</p>
                                <div class="mt-6">
                                    <a href="{{ route('reservations.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Make Reservation
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection