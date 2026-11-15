<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->get();

        return view('frontend.wishlist.index', compact('items'));
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Removed from your wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
        ]);

        return back()->with('success', 'Saved to your wishlist.');
    }

    public function destroy(Wishlist $wishlist)
    {
        abort_unless($wishlist->user_id === auth()->id(), 404);

        $wishlist->delete();

        return back()->with('success', 'Removed from your wishlist.');
    }
}
