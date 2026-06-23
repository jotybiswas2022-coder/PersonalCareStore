@php $s = settings(); @endphp
<style>
    .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start; }
    @media (max-width: 768px) {
        .contact-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    }
</style>
<section style="position: relative; overflow: hidden; background: linear-gradient(165deg, #F0FDF4 0%, #FFFFFF 50%, #FFFDF5 100%); padding: 5rem 1rem;">
    {{-- Decorative shapes --}}
    <div style="position: absolute; top: -80px; right: -80px; width: 240px; height: 240px; border-radius: 50%; background: radial-gradient(circle, rgba(46,139,87,0.08) 0%, transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -60px; left: -60px; width: 200px; height: 200px; border-radius: 50%; background: radial-gradient(circle, rgba(255,209,102,0.08) 0%, transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; top: 40%; left: 10%; width: 100px; height: 100px; border-radius: 50%; border: 2px solid rgba(46,139,87,0.06); pointer-events: none;"></div>
    <div style="position: absolute; bottom: 25%; right: 8%; width: 70px; height: 70px; border-radius: 50%; border: 2px solid rgba(255,209,102,0.08); pointer-events: none;"></div>

    <div style="max-width: 1280px; margin: 0 auto; position: relative; z-index: 1;">
        {{-- Header --}}
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(46,139,87,0.10); color: #2E8B57; font-size: 0.8125rem; font-weight: 600; padding: 0.375rem 1rem; border-radius: 9999px; margin-bottom: 1rem; border: 1px solid rgba(46,139,87,0.15);">
                <span style="width: 0.5rem; height: 0.5rem; background: #2E8B57; border-radius: 50%;"></span>
                Get in Touch
            </span>
            <h2 style="font-size: 2rem; font-weight: 700; color: #212529; margin-bottom: 0.75rem; letter-spacing: -0.02em;">Contact Us</h2>
            <p style="color: #6b7280; font-size: 0.9375rem; max-width: 32rem; margin: 0 auto; line-height: 1.6;">Have questions or need help? We're here to assist you — reach out anytime!</p>
        </div>

        {{-- Contact Form + Cards row --}}
        <div class="contact-grid">
            {{-- Contact Form --}}
            <div style="background: #ffffff; border-radius: 1rem; border: 1px solid #e9ecef; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #212529; margin-bottom: 0.25rem;">Send us a Message</h3>
                <p style="font-size: 0.8125rem; color: #6b7280; margin-bottom: 1.5rem;">Have a question or concern? Write to us and we'll respond shortly.</p>

                @if(session('success'))
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.75rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; margin-bottom: 1.25rem;">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label for="contact_name" style="display: block; font-size: 0.8125rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Your Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="contact_name" name="name" value="{{ old('name') }}" required
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid {{ $errors->has('name') ? '#ef4444' : '#d1d5db' }}; border-radius: 0.5rem; font-size: 0.875rem; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#2E8B57'" onblur="this.style.borderColor='#d1d5db'">
                        @error('name')<p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="contact_email" style="display: block; font-size: 0.8125rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Your Email <span style="color: #ef4444;">*</span></label>
                        <input type="email" id="contact_email" name="email" value="{{ old('email') }}" required
                               style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid {{ $errors->has('email') ? '#ef4444' : '#d1d5db' }}; border-radius: 0.5rem; font-size: 0.875rem; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#2E8B57'" onblur="this.style.borderColor='#d1d5db'">
                        @error('email')<p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="contact_message" style="display: block; font-size: 0.8125rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">Your Message <span style="color: #ef4444;">*</span></label>
                        <textarea id="contact_message" name="message" rows="4" required
                                  style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid {{ $errors->has('message') ? '#ef4444' : '#d1d5db' }}; border-radius: 0.5rem; font-size: 0.875rem; outline: none; resize: vertical; transition: border-color 0.2s;"
                                  onfocus="this.style.borderColor='#2E8B57'" onblur="this.style.borderColor='#d1d5db'">{{ old('message') }}</textarea>
                        @error('message')<p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                            style="width: 100%; background: linear-gradient(135deg, #2E8B57, #3CB371); color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-size: 0.9375rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(46,139,87,0.2);"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(46,139,87,0.3)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(46,139,87,0.2)'">
                        Send Message
                    </button>

                </form>
            </div>

            {{-- Contact Cards column --}}
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
            {{-- Phone --}}
            <div style="background: #ffffff; border-radius: 1rem; border: 1px solid #e9ecef; padding: 1.5rem 1.25rem; display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.06)'; this.style.borderColor='#2E8B57'; this.querySelector('.c-icon').style.transform='scale(1.05)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'; this.style.borderColor='#e9ecef'; this.querySelector('.c-icon').style.transform='scale(1)'">
                <div class="c-icon" style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; background: linear-gradient(135deg, #E8F5E9, #C8E6C9); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #2E8B57; transition: transform 0.3s ease;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-size: 0.8125rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.125rem;">Phone</h3>
                    <a href="tel:{{ $s->contact_phone ?? '+8801700000000' }}" style="color: #212529; font-weight: 600; font-size: 0.9375rem; text-decoration: none;" onmouseover="this.style.color='#2E8B57'" onmouseout="this.style.color='#212529'">{{ $s->contact_phone ?? '+880 1700-000000' }}</a>
                </div>
            </div>

            {{-- Email --}}
            <div style="background: #ffffff; border-radius: 1rem; border: 1px solid #e9ecef; padding: 1.5rem 1.25rem; display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.06)'; this.style.borderColor='#2E8B57'; this.querySelector('.c-icon').style.transform='scale(1.05)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'; this.style.borderColor='#e9ecef'; this.querySelector('.c-icon').style.transform='scale(1)'">
                <div class="c-icon" style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; background: linear-gradient(135deg, #E8F5E9, #C8E6C9); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #2E8B57; transition: transform 0.3s ease;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-size: 0.8125rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.125rem;">Email</h3>
                    <a href="mailto:{{ $s->contact_email ?? 'support@personalcarestore.com' }}" style="color: #212529; font-weight: 600; font-size: 0.9375rem; text-decoration: none;" onmouseover="this.style.color='#2E8B57'" onmouseout="this.style.color='#212529'">{{ $s->contact_email ?? 'support@personalcarestore.com' }}</a>
                </div>
            </div>

            {{-- Address --}}
            <div style="background: #ffffff; border-radius: 1rem; border: 1px solid #e9ecef; padding: 1.5rem 1.25rem; display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.06)'; this.style.borderColor='#2E8B57'; this.querySelector('.c-icon').style.transform='scale(1.05)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'; this.style.borderColor='#e9ecef'; this.querySelector('.c-icon').style.transform='scale(1)'">
                <div class="c-icon" style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; background: linear-gradient(135deg, #E8F5E9, #C8E6C9); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #2E8B57; transition: transform 0.3s ease;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-size: 0.8125rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.125rem;">Address</h3>
                    <p style="color: #212529; font-size: 0.9375rem; line-height: 1.4;">{{ $s->contact_address ?? '123 Personal Care Lane, Khulna, Bangladesh' }}</p>
                </div>
            </div>

            {{-- Hours --}}
            <div style="background: #ffffff; border-radius: 1rem; border: 1px solid #e9ecef; padding: 1.5rem 1.25rem; display: flex; align-items: center; gap: 1rem; transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.04);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.06)'; this.style.borderColor='#2E8B57'; this.querySelector('.c-icon').style.transform='scale(1.05)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)'; this.style.borderColor='#e9ecef'; this.querySelector('.c-icon').style.transform='scale(1)'">
                <div class="c-icon" style="width: 2.75rem; height: 2.75rem; min-width: 2.75rem; background: linear-gradient(135deg, #FFF8E1, #FFECB3); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #D4A017; transition: transform 0.3s ease;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <h3 style="font-size: 0.8125rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.125rem;">Hours</h3>
                    <p style="color: #212529; font-size: 0.875rem; line-height: 1.4;">{!! nl2br(e($s->contact_hours ?? 'Sat -- Thu: 9 AM - 8 PM')) !!}</p>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
