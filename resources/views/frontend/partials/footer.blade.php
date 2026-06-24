<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <span class="logo-icon">B</span>
                        <span>BasaFinder</span>
                    </div>
                    <p class="footer-desc">Bangladesh's most trusted rental property marketplace. Find your perfect home with confidence.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a href="#" aria-label="Twitter"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                        <a href="#" aria-label="Instagram"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                        <a href="#" aria-label="LinkedIn"><svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('search') }}">Browse Properties</a>
                    <a href="{{ route('post-property') }}">Post Property</a>
                    <a href="{{ route('home') }}#properties">Featured Properties</a>
                </div>
                <div class="footer-col">
                    <h4>Property Types</h4>
                    <a href="{{ route('search', ['property_type' => 'Flat']) }}">Flats & Apartments</a>
                    <a href="{{ route('search', ['property_type' => 'House']) }}">Houses & Villas</a>
                    <a href="{{ route('search', ['property_type' => 'Sublet']) }}">Sublets</a>
                    <a href="{{ route('search', ['property_type' => 'Bachelor Mess']) }}">Bachelor Mess</a>
                    <a href="{{ route('search', ['property_type' => 'Office']) }}">Offices & Commercial</a>
                </div>
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <form method="POST" action="{{ route('contact.submit') }}" class="footer-contact-form">
                        @csrf
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <textarea name="message" placeholder="Write your message..." required rows="3"></textarea>
                        <button type="submit">Send Message</button>
                    </form>
                    <a href="{{ route('contact.find') }}" style="display:block; margin-top:0.75rem; color:#64748b; font-size:0.8125rem; text-decoration:none; text-align:center; transition:color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#64748b'">My Messages</a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p>&copy; {{ date('Y') }} BasaFinder. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer { margin-top: auto; }
.footer-main { background: #f8fafc; padding: 4rem 0 2rem; }
.footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 2.5rem; }
@media (max-width: 1024px) { .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; } }
@media (max-width: 640px) {
    .footer-main { padding: 2rem 0 1.5rem; }
    .footer-grid { grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .footer-brand { grid-column: span 2; }
    .footer-desc { max-width: 100%; font-size: 0.8125rem; margin-bottom: 0.75rem; }
    .footer-social a { width: 1.75rem; height: 1.75rem; }
    .footer-col h4 { font-size: 0.8125rem; margin-bottom: 0.625rem; }
    .footer-col a { font-size: 0.75rem; margin-bottom: 0.375rem; }
    .footer-col:last-child { grid-column: 1 / -1; }
    .footer-col:last-child h4 { font-size: 0.9375rem; }
    .footer-contact-form input,
    .footer-contact-form textarea { padding: 0.5rem 0.75rem; font-size: 0.85rem; margin-bottom: 0.5rem; }
    .footer-contact-form button { padding: 0.5rem; font-size: 0.85rem; }
    .footer-bottom { padding: 0.75rem 0; }
    .footer-bottom-inner { flex-direction: column; text-align: center; gap: 0.375rem; }
    .footer-bottom-inner p { font-size: 0.7rem; }
    .footer-bottom-links { gap: 0.75rem; }
    .footer-bottom-links a { font-size: 0.7rem; }
}
.footer-logo { display: flex; align-items: center; gap: 0.625rem; margin-bottom: 1rem; }
.footer-logo .logo-icon { width: 2rem; height: 2rem; background: linear-gradient(135deg, var(--primary), #1D4ED8); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1rem; }
.footer-logo span:last-child { color: var(--secondary); font-size: 1.25rem; font-weight: 700; letter-spacing: -0.02em; }
.footer-desc { color: #64748b; font-size: 0.875rem; line-height: 1.7; margin-bottom: 1.5rem; max-width: 24rem; }
.footer-social { display: flex; gap: 0.625rem; }
.footer-social a { width: 2.125rem; height: 2.125rem; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; transition: all 0.2s; }
.footer-social a:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }
.footer-col h4 { color: var(--secondary); font-size: 0.9375rem; font-weight: 600; margin-bottom: 1.125rem; }
.footer-col a { display: block; color: #64748b; text-decoration: none; font-size: 0.875rem; margin-bottom: 0.625rem; transition: all 0.2s; }
.footer-col a:hover { color: var(--accent); padding-left: 4px; }
.footer-contact-form input,
.footer-contact-form textarea {
    width: 100%;
    padding: 0.5rem 0.75rem;
    margin-bottom: 0.5rem;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: var(--secondary);
    font-size: 0.8125rem;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.footer-contact-form input::placeholder,
.footer-contact-form textarea::placeholder { color: #94a3b8; }
.footer-contact-form input:focus,
.footer-contact-form textarea:focus { border-color: var(--primary); }
.footer-contact-form button {
    width: 100%;
    padding: 0.5rem;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    font-family: inherit;
}
.footer-contact-form button:hover { background: var(--primary-dark); }
.footer-bottom { background: #e2e8f0; padding: 1.25rem 0; border-top: 1px solid rgba(0,0,0,0.05); }
.footer-bottom-inner { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
.footer-bottom-inner p { color: #64748b; font-size: 0.8125rem; }
.footer-bottom-links { display: flex; gap: 1.25rem; }
.footer-bottom-links a { color: #64748b; text-decoration: none; font-size: 0.8125rem; transition: color 0.2s; }
.footer-bottom-links a:hover { color: var(--accent); }
</style>
