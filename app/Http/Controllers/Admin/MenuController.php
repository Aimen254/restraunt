<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of menu items.
     */
    public function index()
    {
        $menuItems = MenuItem::with('category')->paginate(10);
        return view('admin.menu.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:menu_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        MenuItem::create($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified menu item.
     */
    public function edit(MenuItem $menu)
    {
        $categories = Category::all();
        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:menu_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified menu item.
     */
    // In the destroy method:
    public function destroy(MenuItem $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => 'Menu item deleted successfully.']);
        }

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}
