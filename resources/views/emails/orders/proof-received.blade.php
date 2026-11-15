@extends('emails.layout')

@section('title', 'Payment proof received')
@section('heading', 'Payment proof received')

@section('content')
    <p style="margin:0 0 14px;">Hi {{ $order->shippingAddress?->first_name ?? 'there' }},</p>

    <p style="margin:0 0 18px;">
        Thanks! We received your payment proof for order
        <strong>{{ $order->order_number }}</strong> and our team is verifying it now.
        You will get another email as soon as the payment is approved.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;color:#374151;">
        <tr>
            <td style="padding:4px 0;color:#617067;">Payment method</td>
            <td align="right" style="padding:4px 0;font-weight:600;">{{ strtoupper((string) $order->payment_method) }}</td>
        </tr>
        <tr>
            <td style="padding:4px 0;color:#617067;">Transaction ID</td>
            <td align="right" style="padding:4px 0;font-weight:600;">{{ $order->transaction_id }}</td>
        </tr>
        <tr>
            <td style="padding:4px 0;color:#617067;">Amount</td>
            <td align="right" style="padding:4px 0;font-weight:600;">{{ currencyFormat($order->total) }}</td>
        </tr>
    </table>

    <p style="margin:20px 0 0;">
        <a href="{{ route('track-order.index') }}"
           style="display:inline-block;background:#FFD166;color:#12261B;text-decoration:none;font-weight:700;font-size:14px;padding:12px 20px;border-radius:10px;">
            Track this order
        </a>
    </p>
@endsection
