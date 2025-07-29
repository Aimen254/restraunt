@extends('layouts.admin')

@section('title', 'Edit Reservation')
@section('header', 'Edit Reservation')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Customer</label>
                            <select id="user_id" name="user_id" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="table_id" class="block text-sm font-medium text-gray-700">Table</label>
                            <select id="table_id" name="table_id" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ $reservation->table_id == $table->id ? 'selected' : '' }}>
                                        Table #{{ $table->id }} ({{ $table->capacity }} people)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="reservation_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="reservation_date" id="reservation_date" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('reservation_date', $reservation->reservation_date ? $reservation->reservation_date->format('Y-m-d') : '') }}"
                                min="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="reservation_time" class="block text-sm font-medium text-gray-700">Time</label>
                            <select id="reservation_time" name="reservation_time" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @for($hour = 11; $hour <= 22; $hour++)
                                    <option value="{{ sprintf('%02d:00:00', $hour) }}" {{ $reservation->reservation_time == sprintf('%02d:00:00', $hour) ? 'selected' : '' }}>
                                        {{ $hour }}:00
                                    </option>
                                    @if($hour < 22)
                                        <option value="{{ sprintf('%02d:30:00', $hour) }}" {{ $reservation->reservation_time == sprintf('%02d:30:00', $hour) ? 'selected' : '' }}>
                                            {{ $hour }}:30
                                        </option>
                                    @endif
                                @endfor
                            </select>
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <label for="party_size" class="block text-sm font-medium text-gray-700">Party Size</label>
                            <input type="number" name="party_size" id="party_size" min="1" max="20" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('party_size', $reservation->party_size) }}">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="col-span-6">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                            <textarea id="special_requests" name="special_requests" rows="3"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Delete Reservation
                            </button>
                        </form>
                        <div>
                            <a href="{{ route('admin.reservations.index') }}" 
                               class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Update Reservation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection