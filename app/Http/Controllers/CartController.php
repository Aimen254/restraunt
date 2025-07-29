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

        $cartItem = auth()->user()->cartItems()
            ->where('menu_item_id', $menuItem->id)
            ->first();

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

        $cartCount = auth()->user()->cartItems()->count();

        if (!$request->wantsJson()) {
            return redirect()->route('cart.index')
                ->with('success', 'Item added to cart');
        }

        // Return JSON for AJAX requests
        return response()->json([
            'success' => true,
            'count' => $cartCount,
            'message' => 'Item added to cart',
            'redirect' => route('cart.index')
        ]);
    }

    public function update(Cart $cart, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'subtotal' => number_format($cart->price * $request->quantity, 2),
            'total' => $this->calculateTotal()
        ]);
    }

    private function calculateTotal()
    {
        $subtotal = auth()->user()->cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        $tax = $subtotal * 0.1;
        return number_format($subtotal + $tax, 2);
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
        $request->validate([
            'payment_method' => 'required|string|in:cash,card',
            'is_delivery' => 'required|in:0,1',
            'delivery_address' => 'required_if:is_delivery,1',
            'special_instructions' => 'nullable|string|max:500',
            'total_amount' => 'required|numeric',
            'tax_amount' => 'required|numeric'
        ]);
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
        $orderNumber = 'ORD-' . strtoupper(uniqid());
        // Create order
        $order = $user->orders()->create([
            'order_number' => $orderNumber,
            'total' => $request->total_amount,
            'subtotal' => $request->total_amount,
            'tax' => $request->tax_amount,
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

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['success' => true]);
    }

}
