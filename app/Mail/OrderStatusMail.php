<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order, public string $status)
    {
        $this->order->loadMissing(['items', 'shippingAddress']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order ' . $this->order->order_number . ' is ' . $this->status,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.status',
            with: [
                'order' => $this->order,
                'status' => $this->status,
            ],
        );
    }
}
