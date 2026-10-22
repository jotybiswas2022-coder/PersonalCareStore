<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'nullable|string|max:5000',
            'image' => 'nullable|image|max:10240',
        ]);

        $order = Order::where('user_id', auth()->id())
            ->where('id', $validated['order_id'])
            ->where('status', 'delivered')
            ->firstOrFail();

        $existing = Review::where('order_id', $order->id)
            ->where('product_id', $validated['product_id'])
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $data = [
            'product_id' => $validated['product_id'],
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'body' => $validated['body'] ?? '',
            'is_approved' => true,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        Review::create($data);

        return back()->with('success', 'Your review has been submitted successfully.');
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'nullable|string|max:5000',
            'image' => 'nullable|image|max:10240',
        ]);

        $data = [
            'rating' => $validated['rating'],
            'body' => $validated['body'] ?? '',
            'is_approved' => true,
        ];

        if ($request->hasFile('image')) {
            if ($review->image) {
                Storage::disk('public')->delete($review->image);
            }
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        $review->update($data);

        return back()->with('success', 'Your review has been updated successfully.');
    }

    public function reply(Request $request, Review $review)
    {
        if (!auth()->user()?->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'admin_reply' => 'required|string|max:5000',
        ]);

        $review->update(['admin_reply' => $validated['admin_reply']]);

        return back()->with('success', 'Reply added successfully.');
    }

    public function deleteImage(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$review->image) {
            return back()->with('error', 'This review does not have an image.');
        }

        Storage::disk('public')->delete($review->image);
        $review->update(['image' => null]);

        return back()->with('success', 'Review image has been deleted successfully.');
    }
}
