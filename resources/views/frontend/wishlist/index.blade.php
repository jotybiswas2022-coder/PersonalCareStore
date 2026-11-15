@extends('frontend.layouts.app')

@section('title', 'My Wishlist')
@section('meta_description', 'Products you saved for later at PersonalCareStore.')
@section('robots', 'noindex, nofollow')

@push('styles')
<style>
    .wl-page {
        --ink: #10261A;
        --muted: #617067;
        --green: #2E8B57;
        --green-deep: #17603C;
        --gold: #FFD166;
        --line: #E4EEE8;
        --surface: #FFFFFF;
        --ease: cubic-bezier(0.22, 1, 0.36, 1);

        background: #F6FAF7;
        padding-bottom: 4rem;
    }
    .wl-hero {
        position: relative;
        overflow: hidden;
        padding: 3rem 1.5rem 3.25rem;
        color: #F2FBF5;
        background:
            radial-gradient(900px 400px at 84% 0%, rgba(46,139,87,0.42), transparent 64%),
            linear-gradient(158deg, #07301E 0%, #062718 48%, #03190F 100%);
    }
    .wl-hero-inner { max-width: 1280px; margin: 0 auto; }
    .wl-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.3125rem 0.75rem;
        border-radius: 9999px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.14);
        font-size: 0.6875rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #FFE6A8;
    }
    .wl-hero h1 {
        margin-top: 0.75rem;
        font-size: clamp(1.875rem, 3.4vw, 2.75rem);
        font-weight: 800;
        line-height: 1.05;
        letter-spacing: -0.045em;
        color: #FFFFFF;
    }
    .wl-hero h1 em {
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        background: linear-gradient(100deg, #FFEFC2 0%, #FFD166 45%, #9DF3BE 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
    }
    .wl-hero p { margin-top: 0.625rem; font-size: 0.875rem; color: rgba(233,247,238,0.8); }

    .wl-wrap { max-width: 1280px; margin: 0 auto; padding: 2.25rem 1.5rem 0; }
    .wl-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.25rem;
    }
    .wl-card {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.25rem;
        transition: transform 0.35s var(--ease), box-shadow 0.35s var(--ease), border-color 0.3s ease;
    }
    .wl-card:hover {
        transform: translateY(-4px);
        border-color: #B9E2C9;
        box-shadow: 0 28px 52px -34px rgba(10,60,38,0.42);
    }
    .wl-shot {
        position: relative;
        display: block;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: radial-gradient(circle at 50% 30%, #FFFFFF 0%, #EAF9EF 60%, #D8F2E2 100%);
    }
    .wl-shot img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s var(--ease); }
    .wl-card:hover .wl-shot img { transform: scale(1.06); }
    .wl-shot .no-img { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #C3D4C9; }
    .wl-body { display: flex; flex-direction: column; flex: 1; padding: 0.875rem 1rem 1rem; }
    .wl-cat { font-size: 0.625rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--green); }
    .wl-name {
        margin-top: 0.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 0.875rem;
        font-weight: 700;
        line-height: 1.35;
        color: var(--ink);
        text-decoration: none;
    }
    .wl-name:hover { color: var(--green-deep); }
    .wl-price { display: flex; align-items: baseline; gap: 0.375rem; margin-top: 0.5rem; }
    .wl-price .now { font-size: 1rem; font-weight: 800; letter-spacing: -0.02em; color: var(--ink); }
    .wl-price .was { font-size: 0.75rem; color: #9AA79F; text-decoration: line-through; }
    .wl-actions { display: flex; gap: 0.5rem; margin-top: auto; padding-top: 0.75rem; }
    .wl-atc {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        padding: 0.5625rem;
        border: none;
        border-radius: 0.75rem;
        background: linear-gradient(135deg, #FFE08A, #FFD166 55%, #F5C14E);
        color: #12261B;
        font-family: inherit;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.25s var(--ease), box-shadow 0.25s var(--ease);
    }
    .wl-atc:hover { transform: translateY(-1px); box-shadow: 0 14px 26px -16px rgba(255,209,102,1); }
    .wl-atc:disabled { background: #E8EFEB; color: #93A39A; cursor: not-allowed; box-shadow: none; transform: none; }
    .wl-remove {
        width: 2.25rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--line);
        border-radius: 0.75rem;
        background: transparent;
        color: #B4C6BB;
        cursor: pointer;
        transition: color 0.25s, background 0.25s, border-color 0.25s;
    }
    .wl-remove:hover { color: #E11D48; background: #FEF2F2; border-color: #FBD5D5; }

    .wl-empty {
        padding: 4.5rem 2rem;
        text-align: center;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 1.5rem;
    }
    .wl-empty .ico {
        width: 4rem;
        height: 4rem;
        margin: 0 auto 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1.25rem;
        background: linear-gradient(135deg, #EDF9F2, #D9F2E3);
        border: 1px solid #D6F0E0;
        color: var(--green);
    }
    .wl-empty h2 { font-size: 1.375rem; font-weight: 800; letter-spacing: -0.03em; color: var(--ink); }
    .wl-empty p { max-width: 26rem; margin: 0.375rem auto 1.5rem; font-size: 0.875rem; line-height: 1.65; color: var(--muted); }
    .wl-empty .shop-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        border-radius: 0.875rem;
        background: linear-gradient(135deg, #FFE08A 0%, #FFD166 55%, #F5C14E 100%);
        color: #12261B;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 34px -18px rgba(255,209,102,0.9);
    }
    .wl-alert {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
        padding: 0.75rem 1rem;
        border-radius: 0.875rem;
        background: #EDF9F2;
        border: 1px solid #D6F0E0;
        color: #166534;
        font-size: 0.8125rem;
    }

    @media (max-width: 1100px) { .wl-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 780px) { .wl-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.75rem; } }
    @media (max-width: 640px) {
        .wl-hero { padding: 2.25rem 1rem 2.5rem; }
        .wl-wrap { padding: 1.5rem 1rem 0; }
        .wl-card { border-radius: 0.875rem; }
        .wl-body { padding: 0.625rem; }
        .wl-name { font-size: 0.75rem; }
        .wl-price .now { font-size: 0.8125rem; }
        .wl-actions { flex-direction: column; }
        .wl-atc { font-size: 0.6875rem; padding: 0.5rem; }
        .wl-remove { width: 100%; height: 2rem; }
        .wl-empty { padding: 3rem 1.25rem; }
    }
</style>
@endpush

@section('content')
<div class="wl-page">
    <section class="wl-hero">
        <div class="wl-hero-inner">
            <span class="wl-eyebrow">Saved for later</span>
            <h1>My <em>wishlist</em></h1>
            <p>{{ $items->count() }} {{ \Illuminate\Support\Str::plural('product', $items->count()) }} saved</p>
        </div>
    </section>

    <div class="wl-wrap">
        @if(session('success'))
            <div class="wl-alert">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($items->count() > 0)
            <div class="wl-grid">
                @foreach($items as $item)
                    @php($product = $item->product)
                    @if($product)
                        <article class="wl-card">
                            <a href="{{ route('products.show', $product->id) }}" class="wl-shot">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ $product->image_urls[0] }}" alt="{{ $product->name }}" loading="lazy" decoding="async">
                                @else
                                    <div class="no-img">
                                        <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </a>

                            <div class="wl-body">
                                <div class="wl-cat">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                <a href="{{ route('products.show', $product->id) }}" class="wl-name">{{ $product->name }}</a>

                                <div class="wl-price">
                                    <span class="now">{{ currencyFormat($product->final_price) }}</span>
                                    @if($product->sale_price)
                                        <span class="was">{{ currencyFormat($product->sale_price) }}</span>
                                    @endif
                                </div>

                                <div class="wl-actions">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex:1;display:flex;">
                                        @csrf
                                        @if($product->stock_quantity > 0)
                                            <button type="submit" class="wl-atc">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 20a1 1 0 100 2 1 1 0 000-2zM20 20a1 1 0 100 2 1 1 0 000-2z"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                                                Add to cart
                                            </button>
                                        @else
                                            <button type="button" class="wl-atc" disabled>Sold out</button>
                                        @endif
                                    </form>

                                    <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="wl-remove" title="Remove from wishlist" aria-label="Remove {{ $product->name }} from wishlist">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @else
            <div class="wl-empty">
                <div class="ico">
                    <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </div>
                <h2>Your wishlist is empty</h2>
                <p>Tap the heart on any product to save it here for later.</p>
                <a href="{{ route('products.index') }}" class="shop-btn">Browse products</a>
            </div>
        @endif
    </div>
</div>
@endsection
