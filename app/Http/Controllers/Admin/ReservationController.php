<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'table'])
                        ->latest()
                        ->paginate(10);
        
        return view('admin.reservation.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        $users = User::all();
        $tables = Table::all();
        
        return view('admin.reservation.create', compact('users', 'tables'));
    }

    /**
     * Store a newly created reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'party_size' => 'required|integer|min:1|max:20',
            'status' => 'required|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string'
        ]);

        Reservation::create($validated);

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reservation created successfully.');
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit(Reservation $reservation)
    {
        $users = User::all();
        $tables = Table::all();
        
        return view('admin.reservation.edit', compact('reservation', 'users', 'tables'));
    }

    /**
     * Update the specified reservation.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'party_size' => 'required|integer|min:1|max:20',
            'status' => 'required|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string'
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified reservation.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reservation deleted successfully.');
    }
}