<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'featuredCategories' => Category::where('is_active', true)->limit(3)->get(),
            'testimonials' => Testimonial::approved()->latest()->limit(3)->get()
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        return view('dashboard', [
            'recentOrders' => $user->orders()
                ->latest()
                ->take(5)
                ->get(),
            'upcomingReservations' => $user->reservations()
                ->where('reservation_date', '>=', now())
                ->orderBy('reservation_date')
                ->take(5)
                ->get()
        ]);
    }
}
