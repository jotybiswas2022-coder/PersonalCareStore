@extends('emails.layout')

@section('title', 'Order ' . $order->order_number . ' received')
@section('heading', 'Thanks for your order!')

@section('content')
    <p style="margin:0 0 14px;">Hi {{ $order->shippingAddress?->first_name ?? 'there' }},</p>

    <p style="margin:0 0 18px;">
        We received your order <strong>{{ $order->order_number }}</strong>.
        @if($order->payment_status === 'unpaid')
            Please complete the payment and upload the proof so we can start packing it.
        @else
            We will let you know as soon as it ships.
        @endif
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E4EEE8;border-radius:12px;overflow:hidden;margin-bottom:18px;">
        <tr>
            <th align="left" style="background:#F6FAF7;padding:10px 14px;font-size:12px;color:#617067;font-weight:600;">Item</th>
            <th align="right" style="background:#F6FAF7;padding:10px 14px;font-size:12px;color:#617067;font-weight:600;">Total</th>
        </tr>
        @foreach($order->items as $item)
            <tr>
                <td style="padding:10px 14px;border-top:1px solid #E4EEE8;font-size:14px;color:#10261A;">
                    {{ $item->product_name }}
                    <span style="color:#93A39A;">&times; {{ $item->quantity }}</span>
                </td>
                <td align="right" style="padding:10px 14px;border-top:1px solid #E4EEE8;font-size:14px;color:#10261A;white-space:nowrap;">
                    {{ currencyFormat($item->subtotal) }}
                </td>
            </tr>
        @endforeach
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;color:#374151;">
        <tr>
            <td style="padding:3px 0;">Subtotal</td>
            <td align="right" style="padding:3px 0;">{{ currencyFormat($order->subtotal) }}</td>
        </tr>
        <tr>
            <td style="padding:3px 0;">Delivery</td>
            <td align="right" style="padding:3px 0;">{{ currencyFormat($order->shipping_cost) }}</td>
        </tr>
        @if((float) $order->tax > 0)
            <tr>
                <td style="padding:3px 0;">VAT</td>
                <td align="right" style="padding:3px 0;">{{ currencyFormat($order->tax) }}</td>
            </tr>
        @endif
        <tr>
            <td style="padding:10px 0 0;border-top:1px solid #E4EEE8;font-weight:700;color:#10261A;">Total</td>
            <td align="right" style="padding:10px 0 0;border-top:1px solid #E4EEE8;font-weight:700;color:#10261A;">{{ currencyFormat($order->total) }}</td>
        </tr>
    </table>

    @if($order->shippingAddress)
        <p style="margin:18px 0 4px;font-size:12px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#2E8B57;">Delivering to</p>
        <p style="margin:0;color:#617067;font-size:14px;line-height:1.6;">
            {{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}<br>
            {{ $order->shippingAddress->address_line1 }}@if($order->shippingAddress->address_line2), {{ $order->shippingAddress->address_line2 }}@endif<br>
            {{ $order->shippingAddress->city }} {{ $order->shippingAddress->postal_code }}<br>
            {{ $order->shippingAddress->phone }}
        </p>
    @endif

    <p style="margin:22px 0 0;">
        <a href="{{ route('track-order.index') }}"
           style="display:inline-block;background:#FFD166;color:#12261B;text-decoration:none;font-weight:700;font-size:14px;padding:12px 20px;border-radius:10px;">
            Track this order
        </a>
    </p>
@endsection
