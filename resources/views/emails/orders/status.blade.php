@extends('emails.layout')

@section('title', 'Order ' . $order->order_number . ' is ' . $status)
@section('heading', 'Your order is ' . $status)

@section('content')
    <p style="margin:0 0 14px;">Hi {{ $order->shippingAddress?->first_name ?? 'there' }},</p>

    <p style="margin:0 0 18px;">
        Order <strong>{{ $order->order_number }}</strong> has been updated to
        <strong style="color:#17603C;">{{ $status }}</strong>.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E4EEE8;border-radius:12px;overflow:hidden;margin-bottom:18px;">
        @foreach($order->items as $item)
            <tr>
                <td style="padding:10px 14px;font-size:14px;color:#10261A;{{ $loop->first ? '' : 'border-top:1px solid #E4EEE8;' }}">
                    {{ $item->product_name }}
                    <span style="color:#93A39A;">&times; {{ $item->quantity }}</span>
                </td>
            </tr>
        @endforeach
    </table>

    <p style="margin:0 0 6px;font-size:14px;color:#617067;">Order total</p>
    <p style="margin:0;font-size:20px;font-weight:700;color:#10261A;">{{ currencyFormat($order->total) }}</p>

    @if($status === 'cancelled')
        <p style="margin:18px 0 0;color:#617067;font-size:14px;">
            Any reserved stock has been returned to the store. If this was unexpected, just reply to this email.
        </p>
    @elseif($status === 'processing')
        <p style="margin:18px 0 0;color:#617067;font-size:14px;">
            We are packing your order now and will update you again when it ships.
        </p>
    @elseif($status === 'shipped')
        <p style="margin:18px 0 0;color:#617067;font-size:14px;">
            Your parcel is on the way. Keep your phone nearby for the delivery call.
        </p>
    @elseif($status === 'delivered')
        <p style="margin:18px 0 0;color:#617067;font-size:14px;">
            Delivered! We would love to hear how the products worked for you.
        </p>
    @endif

    <p style="margin:20px 0 0;">
        <a href="{{ route('track-order.index') }}"
           style="display:inline-block;background:#FFD166;color:#12261B;text-decoration:none;font-weight:700;font-size:14px;padding:12px 20px;border-radius:10px;">
            View order status
        </a>
    </p>
@endsection
