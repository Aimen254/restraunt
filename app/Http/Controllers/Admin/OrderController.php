<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        // Typically not needed for admin as orders are created by users
        abort(404);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        // Typically not needed for admin as orders are created by users
        abort(404);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order deleted successfully.');
    }
}