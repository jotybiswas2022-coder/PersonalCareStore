<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $exists = NewsletterSubscriber::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You are already subscribed!',
            ]);
        }

        NewsletterSubscriber::create([
            'email' => strtolower($request->email),
        ]);

        return response()->json([
            'message' => 'Thank you for subscribing!',
        ]);
    }
}
