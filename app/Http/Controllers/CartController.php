<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('menuItem')->get();

        // Calculate subtotal, tax, and total
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $taxRate = 0.1; // 10% tax - adjust as needed
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    public function add(MenuItem $menuItem, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if item already in cart
        $cartItem = auth()->user()->cartItems()->where('menu_item_id', $menuItem->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity
            ]);
        } else {
            auth()->user()->cartItems()->create([
                'menu_item_id' => $menuItem->id,
                'quantity' => $request->quantity,
                'price' => $menuItem->price
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item removed from cart');
    }

    public function update(Cart $cart, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json(['success' => true]);
    }

    public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('menuItem')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $taxRate = 0.1; // 10% tax
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;

        return view('cart.checkout', compact('cartItems', 'subtotal', 'tax', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('menuItem')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Validate checkout form
        $request->validate([
            'payment_method' => 'required|string',
            'delivery_address' => 'required_if:is_delivery,true|string|max:255',
            'special_instructions' => 'nullable|string|max:500'
        ]);

        // Create order
        $order = $user->orders()->create([
            'total_amount' => $request->total_amount,
            'tax_amount' => $request->tax_amount,
            'delivery_fee' => $request->is_delivery ? 5.00 : 0.00,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'special_instructions' => $request->special_instructions
        ]);

        // Add order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'menu_item_id' => $item->menu_item_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }

        // Clear the cart
        $user->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
    public function show(Cart $cart)
    {
        // Typically you wouldn't need a show page for individual cart items
        // But if you want one, implement it like this:
        return view('cart.show', compact('cart'));
    }
}
