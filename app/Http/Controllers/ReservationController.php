<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Auth::user()->reservations()->with('table')->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $tables = Table::where('is_available', true)->get();
        return view('reservations.create', compact('tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'party_size' => 'required|integer|min:1|max:10',
            'table_id' => 'nullable|exists:tables,id',
            'special_requests' => 'nullable|string|max:500'
        ]);

        $reservation = Auth::user()->reservations()->create([
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'party_size' => $validated['party_size'],
            'table_id' => $validated['table_id'],
            'special_requests' => $validated['special_requests'],
            'status' => 'confirmed'
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully!');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Reservation cancelled successfully');
    }
}