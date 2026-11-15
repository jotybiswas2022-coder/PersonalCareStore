@extends('admin.layouts.app')

@push('styles')
    @include('admin.coupons._styles')
@endpush

@section('content')
<div class="cp-head">
    <div>
        <h1>Edit coupon</h1>
        <p>{{ $coupon->code }} &middot; used {{ $coupon->used_count }}{{ $coupon->usage_limit ? ' of ' . $coupon->usage_limit : '' }} times</p>
    </div>
</div>

<div class="cp-card">
    <div class="cp-body">
        <form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}">
            @include('admin.coupons._form', ['coupon' => $coupon])
        </form>
    </div>
</div>
@endsection
