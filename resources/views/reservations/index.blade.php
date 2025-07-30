@extends('spa')

@section('title', 'My Reservations')
@section('header', 'Your Reservations')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Your Reservations</h1>
            <a href="{{ route('reservations.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                + New Reservation
            </a>
        </div>

        @if($reservations->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations yet</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by booking a table.</p>
                <div class="mt-6">
                    <a href="{{ route('reservations.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Book a Table
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-8">
                @foreach($reservations as $reservation)
                <div class="border-b border-gray-200 pb-8">
                    <div class="sm:flex sm:items-center sm:justify-between sm:space-x-5">
                        <div class="flex items-center space-x-5">
                            <div class="flex-shrink-0">
                                <div class="relative">
                                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-gray-500">
                                        <span class="text-lg font-medium leading-none text-white">T</span>
                                    </span>
                                </div>
                            </div>
                            <div class="pt-1.5">
                                <h3 class="text-lg font-medium text-gray-900">
                                    @if($reservation->table)
                                        Table #{{ $reservation->table->id }}
                                    @else
                                        Table (Not Assigned)
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-500">
                                    For {{ $reservation->party_size }} {{ Str::plural('person', $reservation->party_size) }}
                                </p>
                                @if($reservation->special_requests)
                                    <p class="mt-1 text-sm text-gray-500">
                                        <span class="font-medium">Special Requests:</span> {{ $reservation->special_requests }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:mt-0 sm:flex-row sm:space-x-3 sm:space-y-0 sm:space-x-reverse">
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                            </span>
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-0.5 text-sm font-medium text-blue-800">
                                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y') }}
                            </span>
                             <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="cancel-form">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="cancel-reservation inline-flex items-center rounded-full bg-red-100 px-3 py-0.5 text-sm font-medium text-red-800 hover:bg-red-200">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection