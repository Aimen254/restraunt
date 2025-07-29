<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::with(['menuItems' => function ($query) {
            $query->where('is_active', true)
                ->orderBy('name');
        }])->whereHas('menuItems', function ($query) {
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

    public function search(Request $request)
    {
        $query = $request->input('q', '');

        $categories = Category::with(['menuItems' => function ($q) use ($query) {
            $q->where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%")
                        ->orWhere('description', 'like', "%$query%");
                })
                ->orderBy('name');
        }])
            ->whereHas('menuItems', function ($q) use ($query) {
                $q->where('is_active', true)
                    ->where(function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%");
                    });
            })
            ->orderBy('name')
            ->get();

        return view('menu.partials.items', compact('categories'));
    }
}
