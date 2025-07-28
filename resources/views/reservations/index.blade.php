@extends('spa')

@section('title', 'My Reservations')
@section('header', 'Your Reservations')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Upcoming Reservations</h1>

        <div class="mt-8">
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
                                <h3 class="text-lg font-medium text-gray-900">Table #{{ $reservation->table_id }}</h3>
                                <p class="text-sm text-gray-500">
                                    For {{ $reservation->party_size }} {{ Str::plural('person', $reservation->party_size) }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:mt-0 sm:flex-row sm:space-x-3 sm:space-y-0 sm:space-x-reverse">
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('g:i A') }}
                            </span>
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-0.5 text-sm font-medium text-blue-800">
                                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('F j, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection