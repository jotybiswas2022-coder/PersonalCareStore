<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with(['items.product', 'shippingAddress', 'reviews'])
            ->findOrFail($id);

        $reviews = $order->reviews->keyBy('product_id');

        return view('frontend.orders.show', compact('order', 'reviews'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'processing'])
            ->findOrFail($id);

        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'cancelled',
            'cancelled_by' => 'user',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Your order has been cancelled successfully.');
    }
}
