<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\CheckoutException;
use App\Mail\OrderPlacedMail;
use App\Mail\PaymentProofReceivedMail;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
    public function index()
    {
        $cartItems = Cart::forCurrentOwner()
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

        $couponState = Coupon::resolveSessionCoupon(session('coupon_code'), (float) $subtotal);

        if ($couponState['error']) {
            session()->forget('coupon_code');
            session()->flash('error', $couponState['error']);
        }

        $coupon = $couponState['coupon'];
        $discount = $couponState['discount'];
        $taxableSubtotal = max(0, (float) $subtotal - $discount);
        $vatAmount = round($taxableSubtotal * ($vatPercent / 100), 2);
        $total = $taxableSubtotal + $deliveryCharge + $vatAmount;

        return view('frontend.checkout.index', compact(
            'cartItems', 'subtotal', 'deliveryCharge', 'vatPercent', 'vatAmount', 'total', 'deliveryArea', 'coupon', 'discount'
        ));
    }

    /**
     * Process the checkout and create an order.
     */
    public function process(Request $request)
    {
        $cartItems = Cart::forCurrentOwner()
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

        try {
            $order = DB::transaction(function () use ($cartItems, $validated) {
                // Lock the ordered rows so two checkouts cannot oversell the same units.
                $products = Product::whereIn('id', $cartItems->pluck('product_id')->unique()->values())
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($cartItems as $cartItem) {
                    $product = $products->get($cartItem->product_id);

                    if (! $product || ! $product->is_active) {
                        throw new CheckoutException('An item in your cart is no longer available. Please remove it and try again.');
                    }

                    if ($cartItem->quantity > $product->stock_quantity) {
                        throw new CheckoutException($product->stock_quantity > 0
                            ? 'Only ' . $product->stock_quantity . ' left of "' . $product->name . '". Please update your cart.'
                            : '"' . $product->name . '" is out of stock. Please remove it from your cart.');
                    }
                }

                $subtotal = $cartItems->sum(function ($cartItem) use ($products) {
                    return $products->get($cartItem->product_id)->final_price * $cartItem->quantity;
                });

                $setting = settings();
                $deliveryArea = session('delivery_area', 'inside');
                $shippingCost = $deliveryArea === 'inside' ? ($setting?->delivery_charge_inside ?? 0) : ($setting?->delivery_charge_outside ?? 0);
                $vatPercent = $setting?->vat_percentage ?? 0;

                // Lock the coupon row so a limited-use code cannot be redeemed
                // twice by two checkouts at the same moment.
                $coupon = null;
                $discount = 0.0;

                if ($couponCode = session('coupon_code')) {
                    $coupon = Coupon::whereRaw('UPPER(code) = ?', [Coupon::normalizeCode($couponCode)])
                        ->lockForUpdate()
                        ->first();

                    if ($coupon) {
                        if ($error = $coupon->validationError((float) $subtotal)) {
                            throw new CheckoutException('Coupon "' . $coupon->code . '": ' . $error);
                        }

                        $discount = $coupon->discountFor((float) $subtotal);
                    }
                }

                $taxableSubtotal = max(0, (float) $subtotal - $discount);
                $tax = round($taxableSubtotal * ($vatPercent / 100), 2);
                $total = $taxableSubtotal + $shippingCost + $tax;

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
                    'stock_reserved_at' => now(),
                    'coupon_code' => $coupon?->code,
                    'discount' => $discount,
                ]);

                foreach ($cartItems as $cartItem) {
                    $product = $products->get($cartItem->product_id);
                    $price = $product->final_price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'product_name' => $product->name,
                        'product_price' => $price,
                        'quantity' => $cartItem->quantity,
                        'subtotal' => $price * $cartItem->quantity,
                    ]);

                    $product->decrement('stock_quantity', $cartItem->quantity);
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

                if ($coupon) {
                    $coupon->increment('used_count');
                }

                // Clear the cart only once the order is safely stored
                Cart::forCurrentOwner()->delete();

                return $order;
            });
        } catch (CheckoutException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('coupon_code');

        // Store email in session for guest success page access
        session()->put('checkout_email', $validated['email']);

        sendNotificationEmail($validated['email'], new OrderPlacedMail($order));

        return redirect()->route('checkout.success', $order->id);
    }

    /**
     * Show the order success page.
     */
    public function success(string $orderId)
    {
        $order = Order::with(['items', 'shippingAddress'])->findOrFail($orderId);

        $this->ensureOrderAccess($order);

        $paymentDetails = PaymentDetail::where('is_active', true)->get();

        return view('frontend.checkout.success', compact('order', 'paymentDetails'));
    }

    public function uploadProof(Request $request, string $orderId)
    {
        $order = Order::findOrFail($orderId);

        $this->ensureOrderAccess($order);

        // Prevent proof submission for cancelled orders
        if ($order->status === 'cancelled') {
            return redirect()->route('checkout.success', $order->id)
                ->with('error', 'This order has been cancelled and cannot accept payment proof.');
        }

        if ($request->has('delete_proof')) {
            if ($order->proof_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($order->proof_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($order->proof_image);
            }
            $order->update([
                'proof_image' => null,
                'transaction_id' => null,
                'payment_status' => 'unpaid',
            ]);
            return redirect()->back()->with('success', 'Payment proof deleted successfully.');
        }

        $validated = $request->validate([
            'payment_method_used' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:255',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $path = $request->file('proof_image')->store('proofs', 'public');

        $order->update([
            'payment_method' => $validated['payment_method_used'],
            'transaction_id' => $validated['transaction_id'],
            'proof_image' => $path,
            'payment_status' => 'paid',
        ]);

        sendNotificationEmail(
            $order->guest_email ?? $order->user?->email,
            new PaymentProofReceivedMail($order)
        );

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Payment proof submitted successfully.');
    }

    /**
     * Only the customer who placed the order may see it or attach its payment
     * proof: the owning account, or the guest session that checked out.
     */
    private function ensureOrderAccess(Order $order): void
    {
        if (auth()->check() && $order->user_id === auth()->id()) {
            return;
        }

        $sessionEmail = session()->get('checkout_email');

        if ($sessionEmail && $order->guest_email && hash_equals((string) $order->guest_email, (string) $sessionEmail)) {
            return;
        }

        abort(404);
    }

    /**
     * Cancel checkout and return to cart.
     */
    public function cancel()
    {
        return redirect()->route('cart.index')->with('info', 'Checkout cancelled. Your cart items are still saved.');
    }
}
