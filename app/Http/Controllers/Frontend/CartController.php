<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cartItems = Cart::forCurrentOwner()
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->final_price;
            return $price * $item->quantity;
        });

        $couponState = Coupon::resolveSessionCoupon(session('coupon_code'), (float) $subtotal);

        if ($couponState['error']) {
            session()->forget('coupon_code');
            session()->flash('error', $couponState['error']);
        }

        $coupon = $couponState['coupon'];
        $discount = $couponState['discount'];
        $subtotalAfterDiscount = max(0, (float) $subtotal - $discount);

        return view('frontend.cart.index', compact('cartItems', 'subtotal', 'coupon', 'discount', 'subtotalAfterDiscount'));
    }

    /**
     * Apply a coupon code to the current cart.
     */
    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $cartItems = Cart::forCurrentOwner()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Add something to your cart before applying a coupon.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->final_price * $item->quantity);

        $coupon = Coupon::findByCode($validated['code']);

        if (! $coupon) {
            return back()->with('error', 'That coupon code is not valid.');
        }

        if ($error = $coupon->validationError((float) $subtotal)) {
            return back()->with('error', $error);
        }

        session()->put('coupon_code', $coupon->code);

        return back()->with('success', 'Coupon "' . $coupon->code . '" applied - you save ' . currencyFormat($coupon->discountFor((float) $subtotal)) . '.');
    }

    /**
     * Remove the coupon from the current cart.
     */
    public function removeCoupon()
    {
        session()->forget('coupon_code');

        return back()->with('success', 'Coupon removed.');
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, string $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $product = Product::where('is_active', true)->findOrFail($productId);

        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->stock_quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem = Cart::forCurrentOwner()
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock_quantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create(array_merge(Cart::currentOwnerAttributes(), [
                'product_id' => $productId,
                'quantity' => $quantity,
            ]));
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, string $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $cartItem = Cart::forCurrentOwner()
            ->with('product')
            ->findOrFail($cartId);

        $quantity = $request->input('quantity');

        if ($quantity === 0) {
            $cartItem->delete();
            if ($request->wantsJson()) {
                return response()->json(['removed' => true, 'message' => 'Item removed from cart.']);
            }
            return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
        }

        if ($quantity > $cartItem->product->stock_quantity) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Not enough stock available.', 'max' => $cartItem->product->stock_quantity], 422);
            }
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update(['quantity' => $quantity]);

        $subtotal = Cart::forCurrentOwner()
            ->with('product')
            ->get()
            ->sum(fn($i) => ($i->product->final_price ?? 0) * $i->quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'quantity' => $quantity,
                'subtotal' => currencyFormat($cartItem->product->final_price * $quantity),
                'cartSubtotal' => currencyFormat($subtotal),
                'itemCount' => Cart::forCurrentOwner()->count(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    /**
     * Set delivery area (inside/outside Khulna) in session.
     */
    public function setDeliveryArea(Request $request)
    {
        $request->validate(['area' => 'required|in:inside,outside']);
        session()->put('delivery_area', $request->area);
        return response()->json(['success' => true]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(string $cartId)
    {
        $cartItem = Cart::forCurrentOwner()->findOrFail($cartId);

        $cartItem->delete();

        $remainingCount = Cart::forCurrentOwner()->count();

        if (request()->wantsJson()) {
            return response()->json([
                'removed' => true,
                'itemCount' => $remainingCount,
                'cartSubtotal' => currencyFormat(
                    Cart::forCurrentOwner()
                        ->with('product')
                        ->get()
                        ->sum(fn($i) => ($i->product->final_price ?? 0) * $i->quantity)
                ),
                'empty' => $remainingCount === 0,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
