<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);

        $totalMessages = ContactMessage::count();
        $unrepliedMessages = ContactMessage::unreplied()->count();
        $repliedMessages = ContactMessage::whereNotNull('admin_reply')->count();

        return view('admin.messages.index', compact('messages', 'totalMessages', 'unrepliedMessages', 'repliedMessages'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $message = ContactMessage::findOrFail($id);
        $message->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_at' => now(),
        ]);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Reply sent successfully.');
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted.');
    }
}
