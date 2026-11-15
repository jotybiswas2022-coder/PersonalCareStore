@extends('admin.layouts.app')

@push('styles')
    @include('admin.coupons._styles')
@endpush

@section('content')
<div class="cp-head">
    <div>
        <h1>New coupon</h1>
        <p>Set the code, discount and limits.</p>
    </div>
</div>

<div class="cp-card">
    <div class="cp-body">
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @include('admin.coupons._form')
        </form>
    </div>
</div>
@endsection
