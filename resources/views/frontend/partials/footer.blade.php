@php $s = settings(); @endphp
<footer style="background: linear-gradient(180deg, #1B5E20 0%, #0D3B1E 100%); margin-top: auto;">
    <style>
        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr !important; gap: 2rem !important; }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr !important; gap: 2rem !important; }
        }
    </style>
    {{-- Decorative top border --}}
    <div style="height: 4px; background: linear-gradient(90deg, #FFD166, #2E8B57, #FFD166);"></div>

    <div style="max-width: 1280px; margin: 0 auto; padding: 3.5rem 1.5rem 2rem;">
        <!-- ── Main grid ── -->
        <div class="footer-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2.5rem;">
            {{-- Brand column --}}
            <div>
                <div style="display: flex; align-items: center; gap: 0.625rem; margin-bottom: 1rem;">
                    <span style="width: 2rem; height: 2rem; background: #FFD166; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: #212529; font-weight: 800; font-size: 0.9375rem;">P</span>
                    <span style="color: #ffffff; font-size: 1.25rem; font-weight: 700; letter-spacing: -0.02em;">PersonalCareStore</span>
                </div>
                <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem; line-height: 1.7; margin-bottom: 1.25rem; max-width: 24rem;">
                    Your trusted destination for premium personal care and home care products. Quality you can trust, delivered with care.
                </p>
                {{-- Social icons --}}
                <div style="display: flex; gap: 0.625rem;">
                    <a href="#" style="width: 2.125rem; height: 2.125rem; background: rgba(255,255,255,0.08); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#FFD166'; this.style.color='#212529'" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='rgba(255,255,255,0.6)'" aria-label="Facebook">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" style="width: 2.125rem; height: 2.125rem; background: rgba(255,255,255,0.08); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#FFD166'; this.style.color='#212529'" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='rgba(255,255,255,0.6)'" aria-label="Twitter">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" style="width: 2.125rem; height: 2.125rem; background: rgba(255,255,255,0.08); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#FFD166'; this.style.color='#212529'" onmouseout="this.style.background='rgba(255,255,255,0.08)'; this.style.color='rgba(255,255,255,0.6)'" aria-label="Instagram">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 style="color: #ffffff; font-size: 0.9375rem; font-weight: 600; margin-bottom: 1.125rem;">Quick Links</h4>
                <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                    <a href="{{ route('products.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.color='#FFD166'; this.style.paddingLeft='4px'" onmouseout="this.style.color='rgba(255,255,255,0.6)'; this.style.paddingLeft='0'">Products</a>
                    <a href="{{ route('cart.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.color='#FFD166'; this.style.paddingLeft='4px'" onmouseout="this.style.color='rgba(255,255,255,0.6)'; this.style.paddingLeft='0'">Cart</a>
                    <a href="{{ route('track-order.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.color='#FFD166'; this.style.paddingLeft='4px'" onmouseout="this.style.color='rgba(255,255,255,0.6)'; this.style.paddingLeft='0'">Track Order</a>    @auth
        <a href="{{ route('orders.index') }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.color='#FFD166'; this.style.paddingLeft='4px'" onmouseout="this.style.color='rgba(255,255,255,0.6)'; this.style.paddingLeft='0'">My Orders</a>
    @endauth
                </div>
            </div>

            {{-- Support --}}
            <div>
                <h4 style="color: #ffffff; font-size: 0.9375rem; font-weight: 600; margin-bottom: 1.125rem;">Support</h4>
                <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                    @if($s && $s->contact_phone)
                        <a href="tel:{{ $s->contact_phone }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.color='#FFD166'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">{{ $s->contact_phone }}</a>
                    @endif
                    @if($s && $s->contact_email)
                        <a href="mailto:{{ $s->contact_email }}" style="color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.color='#FFD166'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">{{ $s->contact_email }}</a>
                    @endif
                    @if($s && $s->contact_address)
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.8125rem; line-height: 1.5;">{{ $s->contact_address }}</span>
                    @endif
                </div>
            </div>

            {{-- Contact --}}
            <div>
                <h4 style="color: #ffffff; font-size: 0.9375rem; font-weight: 600; margin-bottom: 1.125rem;">Business Hours</h4>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @if($s && $s->contact_hours)
                        <span style="color: rgba(255,255,255,0.6); font-size: 0.875rem; line-height: 1.5;">{!! nl2br(e($s->contact_hours)) !!}</span>
                    @else
                        <span style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">Sat - Thu: 9 AM - 8 PM</span>
                    @endif
                    <span style="color: rgba(255,255,255,0.4); font-size: 0.8125rem; margin-top: 0.25rem;">Friday: Closed</span>
                </div>
            </div>
        </div>

        <!-- ── Bottom bar ── -->
        <div style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <p style="color: rgba(255,255,255,0.4); font-size: 0.8125rem;">
                &copy; {{ date('Y') }} PersonalCareStore. All rights reserved.
            </p>
            <div style="display: flex; gap: 1.25rem;">
                <a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Privacy Policy</a>
                <a href="#" style="color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
