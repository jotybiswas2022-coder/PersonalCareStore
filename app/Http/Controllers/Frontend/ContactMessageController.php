<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contactMessage = ContactMessage::create($validated);

        return redirect()->route('contact.my-messages', ['email' => $contactMessage->email])
            ->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

    public function myMessages(Request $request)
    {
        $email = $request->query('email');
        $messages = collect();

        if ($email) {
            $messages = ContactMessage::where('email', $email)
                ->latest()
                ->get();
        }

        return view('frontend.contact.my-messages', compact('messages', 'email'));
    }
}
