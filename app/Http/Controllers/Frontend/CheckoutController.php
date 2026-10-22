<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetail;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
    public function index()
    {
        $sessionId = session()->getId();
        $cartItems = Cart::where('session_id', $sessionId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->final_price;
            return $price * $item->quantity;
        });

        $setting = settings();
        $deliveryArea = session('delivery_area', 'inside');
        $deliveryCharge = $deliveryArea === 'inside' ? ($setting?->delivery_charge_inside ?? 0) : ($setting?->delivery_charge_outside ?? 0);
        $vatPercent = $setting?->vat_percentage ?? 0;
        $vatAmount = round($subtotal * ($vatPercent / 100), 2);
        $total = $subtotal + $deliveryCharge + $vatAmount;

        return view('frontend.checkout.index', compact('cartItems', 'subtotal', 'deliveryCharge', 'vatPercent', 'vatAmount', 'total', 'deliveryArea'));
    }

    /**
     * Process the checkout and create an order.
     */
    public function process(Request $request)
    {
        $sessionId = session()->getId();
        $cartItems = Cart::where('session_id', $sessionId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:255',
        ]);

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->final_price;
            return $price * $item->quantity;
        });

        $setting = settings();
        $deliveryArea = session('delivery_area', 'inside');
        $shippingCost = $deliveryArea === 'inside' ? ($setting?->delivery_charge_inside ?? 0) : ($setting?->delivery_charge_outside ?? 0);
        $vatPercent = $setting?->vat_percentage ?? 0;
        $tax = round($subtotal * ($vatPercent / 100), 2);
        $total = $subtotal + $shippingCost + $tax;

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'guest_email' => $validated['email'],
            'user_id' => auth()->id(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax' => $tax,
            'total' => $total,
            'payment_status' => 'unpaid',
            'payment_method' => null,
        ]);

        foreach ($cartItems as $cartItem) {
            $price = $cartItem->product->final_price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'product_price' => $price,
                'quantity' => $cartItem->quantity,
                'subtotal' => $price * $cartItem->quantity,
            ]);
        }

        ShippingAddress::create([
            'order_id' => $order->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address_line1' => $validated['address_line1'],
            'address_line2' => $validated['address_line2'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'] ?? null,
            'postal_code' => $validated['postal_code'],
            'country' => $validated['country'] ?? 'Bangladesh',
        ]);

        // Store email in session for guest success page access
        session()->put('checkout_email', $validated['email']);

        // Clear the cart
        Cart::where('session_id', $sessionId)->delete();

        return redirect()->route('checkout.success', $order->id);
    }

    /**
     * Show the order success page.
     */
    public function success(string $orderId)
    {
        $order = Order::with(['items', 'shippingAddress'])->findOrFail($orderId);

        // Security: only allow the session that created this order to view it
        if ($order->user_id !== auth()->id() && $order->guest_email !== session()->get('checkout_email')) {
            // For guest checkout, store the email in session when they place the order
            if (!session()->has('checkout_email') || session('checkout_email') !== $order->guest_email) {
                abort(404);
            }
        }

        $paymentDetails = PaymentDetail::where('is_active', true)->get();

        return view('frontend.checkout.success', compact('order', 'paymentDetails'));
    }

    public function uploadProof(Request $request, string $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Prevent proof submission for cancelled orders
        if ($order->status === 'cancelled') {
            return redirect()->route('checkout.success', $order->id)
                ->with('error', 'This order has been cancelled and cannot accept payment proof.');
        }

        $validated = $request->validate([
            'transaction_id' => 'required|string|max:255',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $path = $request->file('proof_image')->store('proofs', 'public');

        $order->update([
            'transaction_id' => $validated['transaction_id'],
            'proof_image' => $path,
            'payment_status' => 'paid',
        ]);

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Payment proof submitted successfully.');
    }

    /**
     * Cancel checkout and return to cart.
     */
    public function cancel()
    {
        return redirect()->route('cart.index')->with('info', 'Checkout cancelled. Your cart items are still saved.');
    }
}
