<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAutoReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your message - PersonalCareStore',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.auto-reply',
            // "message" is reserved by Laravel for the mail Message instance.
            with: ['contactMessage' => $this->contactMessage],
        );
    }
}
