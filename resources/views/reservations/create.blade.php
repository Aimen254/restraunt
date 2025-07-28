@extends('spa')

@section('title', 'Create Reservation')
@section('header', 'Book a Table')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="reservation_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="reservation_date" id="reservation_date" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div>
                            <label for="reservation_time" class="block text-sm font-medium text-gray-700">Time</label>
                            <select name="reservation_time" id="reservation_time" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select a time</option>
                                @for($hour = 11; $hour <= 22; $hour++)
                                    <option value="{{ sprintf('%02d:00:00', $hour) }}">{{ $hour }}:00</option>
                                    @if($hour < 22)
                                        <option value="{{ sprintf('%02d:30:00', $hour) }}">{{ $hour }}:30</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        
                        <div>
                            <label for="party_size" class="block text-sm font-medium text-gray-700">Party Size</label>
                            <select name="party_size" id="party_size" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ Str::plural('person', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div>
                            <label for="table_id" class="block text-sm font-medium text-gray-700">Table Preference</label>
                            <select name="table_id" id="table_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">No preference</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}">Table #{{ $table->id }} ({{ $table->capacity }} people)</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                            <textarea name="special_requests" id="special_requests" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" 
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Book Table
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection