<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactMessageController extends Controller
{
    public function find()
    {
        $messages = ContactMessage::latest()->get(['id', 'view_token', 'created_at', 'admin_reply', 'name', 'email']);
        return view('frontend.contact.find', compact('messages'));
    }

    public function show($token)
    {
        $message = ContactMessage::where('view_token', $token)->firstOrFail();
        return view('frontend.contact.message', compact('message'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $validated['view_token'] = Str::random(40);

        $contactMessage = ContactMessage::create($validated);

        return redirect()->route('contact.message', $contactMessage->view_token)
            ->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }

}
