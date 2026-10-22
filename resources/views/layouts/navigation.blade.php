<nav style="background: #ffffff; border-bottom: 1px solid #e5e7eb;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 1rem; display: flex; justify-content: space-between; height: 4rem; align-items: center;">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a href="{{ route('home') }}" style="display: flex; align-items: center;">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="#111827" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 2L4 10v12l14 8 14-8V10L18 2zm0 4.5l9 5.2v6.6l-9 5.2-9-5.2v-6.6l9-5.2z"/>
                </svg>
                <span style="font-weight: 700; font-size: 1.125rem; color: #111827; margin-left: 0.5rem;">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div style="display: flex; gap: 2rem;">
                <a href="{{ route('home') }}" style="text-decoration: none; padding: 0.25rem 0; font-size: 0.875rem; font-weight: 500; color: #4f46e5; border-bottom: 2px solid #4f46e5;">Home</a>
                <a href="{{ route('products.index') }}" style="text-decoration: none; padding: 0.25rem 0; font-size: 0.875rem; font-weight: 500; color: #6b7280; transition: color 0.2s;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#6b7280'">Store</a>
                <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; padding: 0.25rem 0; font-size: 0.875rem; font-weight: 500; color: #6b7280; transition: color 0.2s;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#6b7280'">Admin Panel</a>
            </div>
        </div>
        <div style="display: flex; align-items: center;">
            <div style="position: relative; display: inline-block;">
                <button onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'block' ? 'none' : 'block'" style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.5rem 0.75rem; border: 1px solid transparent; font-size: 0.875rem; font-weight: 500; color: #6b7280; background: #ffffff; border-radius: 0.375rem; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#6b7280'">
                    <div>{{ Auth::user()->name }}</div>
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div style="display: none; position: absolute; right: 0; margin-top: 0.5rem; width: 12rem; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 50;">
                    <a href="{{ route('profile.edit') }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #374151; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #374151; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">Log Out</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
