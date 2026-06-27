<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribers()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(20);
        return view('admin.newsletter.subscribers', compact('subscribers'));
    }

    public function sendForm()
    {
        $count = NewsletterSubscriber::count();
        return view('admin.newsletter.send', compact('count'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        $subscribers = NewsletterSubscriber::all();

        if ($subscribers->isEmpty()) {
            return redirect()->route('admin.newsletter.send')
                ->with('error', 'No subscribers to send to.');
        }

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewsletterMail(
                $request->subject,
                $request->body
            ));
        }

        $count = $subscribers->count();

        return redirect()->route('admin.newsletter.send')
            ->with('success', "Newsletter queued successfully to {$count} subscriber(s).");
    }

    public function destroy($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('admin.newsletter.subscribers')
            ->with('success', 'Subscriber removed successfully.');
    }
}
