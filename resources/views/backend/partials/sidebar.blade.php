<!-- Sidebar (desktop only) -->
<aside class="sidebar d-none d-md-block" id="sidebarCollapse">
    <div class="sidebar-header">
        <a href="/admin" class="brand">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>{{ __('messages.admin') }} Panel</span>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ url('/admin') }}"
               class="{{ request()->is('admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/account') }}"
               class="{{ request()->is('admin/account') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Account</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/services') }}"
               class="{{ request()->is('admin/services*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Services</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/case-studies') }}"
               class="{{ request()->is('admin/case-studies*') ? 'active' : '' }}">
                <i class="bi bi-journal-code"></i>
                <span>Case Studies</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/experiences') }}"
               class="{{ request()->is('admin/experiences*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i>
                <span>Experiences</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/skills') }}"
               class="{{ request()->is('admin/skills*') ? 'active' : '' }}">
                <i class="bi bi-lightning-charge"></i>
                <span>Skills</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/projects') }}"
               class="{{ request()->is('admin/projects*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i>
                <span>Projects</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/testimonials') }}"
               class="{{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                <i class="bi bi-chat-quote"></i>
                <span>Testimonials</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/faqs') }}"
               class="{{ request()->is('admin/faqs*') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i>
                <span>FAQs</span>
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/contact') }}"
               class="{{ request()->is('admin/contact') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper"></i>
                <span>Messages</span>
            </a>
        </li>
    </ul>
</aside>