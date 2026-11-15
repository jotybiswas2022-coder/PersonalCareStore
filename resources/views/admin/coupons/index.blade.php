@extends('admin.layouts.app')

@push('styles')
    @include('admin.coupons._styles')
@endpush

@section('content')
<div class="cp-head">
    <div>
        <h1>Coupons</h1>
        <p>Create discount codes customers can apply in the cart.</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="cp-btn cp-btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        New coupon
    </a>
</div>

@if(session('success'))
    <div class="cp-flash ok">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="cp-flash bad">{{ session('error') }}</div>
@endif

<div class="cp-card">
    @if($coupons->count() > 0)
        <table class="cp-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Min order</th>
                    <th>Used</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $coupon)
                    <tr>
                        <td class="cp-code">{{ $coupon->code }}</td>
                        <td>{{ $coupon->type_label }}</td>
                        <td>{{ (float) $coupon->min_subtotal > 0 ? currencyFormat($coupon->min_subtotal) : '—' }}</td>
                        <td>{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}</td>
                        <td>
                            @if($coupon->expires_at)
                                {{ $coupon->expires_at->format('d M Y, H:i') }}
                            @else
                                <span class="cp-muted">Never</span>
                            @endif
                        </td>
                        <td>
                            <span class="cp-badge {{ $coupon->is_active ? 'on' : 'off' }}">
                                {{ $coupon->is_active ? 'Active' : 'Paused' }}
                            </span>
                        </td>
                        <td>
                            <div class="cp-actions">
                                <form method="POST" action="{{ route('admin.coupons.toggle', $coupon->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="cp-btn">{{ $coupon->is_active ? 'Pause' : 'Activate' }}</button>
                                </form>
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="cp-btn">Edit</a>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                      onsubmit="return confirm('Delete coupon {{ $coupon->code }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cp-btn cp-btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="cp-empty">No coupons yet. Create your first discount code.</div>
    @endif
</div>

@if($coupons->hasPages())
    <div style="margin-top:1rem;">{{ $coupons->links() }}</div>
@endif
@endsection
