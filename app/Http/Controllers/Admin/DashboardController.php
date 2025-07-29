<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        $today = Carbon::today();
        
        // Get today's reservations count
        $todayReservations = Reservation::whereDate('reservation_date', $today)->count();
        
        // Get today's orders count
        $todayOrders = Order::whereDate('created_at', $today)->count();
        
        // Calculate today's revenue (assuming you have a 'total' column in orders table)
        $todayRevenue = Order::whereDate('created_at', $today)->sum('total');

        return view('admin.dashboard', [
            'todayReservations' => $todayReservations,
            'todayOrders' => $todayOrders,
            'todayRevenue' => $todayRevenue
        ]);
    }
}
