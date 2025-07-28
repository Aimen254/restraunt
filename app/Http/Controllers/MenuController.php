<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with(['menuItems' => function($query) {
            $query->where('is_active', true)
                  ->orderBy('name');
        }])->whereHas('menuItems', function($query) {
            $query->where('is_active', true);
        })->orderBy('name')->get();

        return view('menu.index', compact('categories'));
    }

    public function show(MenuItem $menuItem)
    {
         if (!$menuItem->is_active) {
            abort(404);
        }

        return view('menu.show', compact('menuItem'));
    }
}
