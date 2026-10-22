<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $query = Review::with(['product', 'user']);

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('guest_name', 'like', "%{$search}%");
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

        // Stats
        $totalReviews = Review::count();
        $approvedReviews = Review::where('is_approved', true)->count();
        $pendingReviews = Review::where('is_approved', false)->count();
        $repliedReviews = Review::whereNotNull('admin_reply')->count();
        $avgRating = Review::avg('rating');

        if (request()->wantsJson()) {
            return response()->json([
                'html' => view('admin.reviews._table', compact('reviews'))->render(),
                'pagination' => $reviews->links()->render(),
                'total' => $reviews->total(),
            ]);
        }

        return view('admin.reviews.index', compact('reviews', 'totalReviews', 'approvedReviews', 'pendingReviews', 'repliedReviews', 'avgRating'));
    }
}
