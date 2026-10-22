<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function index()
    {
        return view('frontend.track-order.index');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Email-only lookup: show all orders for that email (guest only)
        if (empty($validated['order_number'])) {
            $orders = Order::where('guest_email', $validated['email'])
                ->with(['items', 'shippingAddress'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($orders->isEmpty()) {
                return redirect()->route('track-order.index')
                    ->with('error', 'No orders found with that email address.');
            }

            return view('frontend.track-order.index', compact('orders'));
        }

        // Order number + email lookup: show specific order (guest only)
        $order = Order::where('order_number', $validated['order_number'])
            ->where('guest_email', $validated['email'])
            ->with(['items', 'shippingAddress'])
            ->first();

        if (!$order) {
            return redirect()->route('track-order.index')
                ->with('error', 'No order found with that order number and email combination.');
        }

        return view('frontend.track-order.index', compact('order'));
    }

    public function show(Request $request, $id)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('track-order.index')
                ->with('error', 'Please provide your email to view the order.');
        }

        $order = Order::where('id', $id)
            ->where('guest_email', $email)
            ->with(['items', 'shippingAddress'])
            ->first();

        if (!$order) {
            return redirect()->route('track-order.index')
                ->with('error', 'Order not found or email does not match.');
        }

        return view('frontend.track-order.index', compact('order'));
    }
}
