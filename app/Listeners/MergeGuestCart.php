<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class MergeGuestCart
{
    /**
     * Merge the guest cart into the customer's saved cart when they sign in.
     *
     * The login guard regenerates the session id before firing this event, so
     * the guest session id is read from the request cookie that came with the
     * login POST, falling back to the current session id.
     */
    public function handle(Login $event): void
    {
        $sessionIds = array_values(array_unique(array_filter([
            request()->cookie(config('session.cookie')),
            session()->getId(),
        ])));

        if ($sessionIds === []) {
            return;
        }

        $guestItems = Cart::whereIn('session_id', $sessionIds)
            ->whereNull('user_id')
            ->with('product')
            ->get();

        if ($guestItems->isEmpty()) {
            return;
        }

        $userId = $event->user->getAuthIdentifier();

        DB::transaction(function () use ($guestItems, $userId) {
            foreach ($guestItems as $guestItem) {
                $existing = Cart::where('user_id', $userId)
                    ->where('product_id', $guestItem->product_id)
                    ->first();

                if (! $existing) {
                    $guestItem->update(['user_id' => $userId, 'session_id' => null]);

                    continue;
                }

                $stock = (int) ($guestItem->product->stock_quantity ?? 1);
                $merged = max(1, min($stock, $existing->quantity + $guestItem->quantity));

                $existing->update(['quantity' => $merged]);
                $guestItem->delete();
            }
        });
    }
}
