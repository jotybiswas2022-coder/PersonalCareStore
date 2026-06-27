<!-- Sidebar (desktop only) -->
<aside class="sidebar d-none d-md-block" id="sidebarCollapse"
     style="width:260px; min-width:260px; background:linear-gradient(180deg,#0f172a,#1e293b); min-height:100%; border-right:none; box-shadow:4px 0 20px rgba(0,0,0,0.1); position:sticky; top:0; height:calc(100vh - 57px); overflow-y:auto; display:flex; flex-direction:column; transition:transform 0.3s cubic-bezier(0.16,1,0.3,1); z-index:1040;">

    <div class="sidebar-header" style="padding:0.9rem 1.2rem; border-bottom:1px solid rgba(255,255,255,0.06); margin-bottom:0.25rem; flex-shrink:0;">
        <a href="/admin" class="brand"
           style="font-size:0.92rem; font-weight:800; color:#fff; text-decoration:none; display:flex; align-items:center; gap:0.55rem; letter-spacing:-0.2px;">
            <i class="bi bi-grid-1x2-fill" style="font-size:1.2rem; color:#6366f1;"></i>
            <span style="background:linear-gradient(135deg,#fff 60%,#94a3b8); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">{{ __('messages.admin') }} Panel</span>
        </a>
    </div>

    <ul class="sidebar-menu" style="list-style:none; padding:0; margin:0; flex:1;">
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin') }}"
               class="{{ request()->is('admin') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-speedometer2" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/account') }}"
               class="{{ request()->is('admin/account') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-person-circle" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Account</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/services') }}"
               class="{{ request()->is('admin/services*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-gear" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Services</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/case-studies') }}"
               class="{{ request()->is('admin/case-studies*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-journal-code" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Case Studies</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/experiences') }}"
               class="{{ request()->is('admin/experiences*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-briefcase" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Experiences</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/skills') }}"
               class="{{ request()->is('admin/skills*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-lightning-charge" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Skills</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/projects') }}"
               class="{{ request()->is('admin/projects*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-folder2-open" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Projects</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/testimonials') }}"
               class="{{ request()->is('admin/testimonials*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-chat-quote" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Testimonials</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/faqs') }}"
               class="{{ request()->is('admin/faqs*') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-question-circle" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>FAQs</span>
            </a>
        </li>
        <li style="margin-bottom:1px;">
            <a href="{{ url('/admin/contact') }}"
               class="{{ request()->is('admin/contact') ? 'active' : '' }}"
               style="display:flex; align-items:center; gap:10px; padding:7px 14px; margin:0 8px; color:rgba(255,255,255,0.6); text-decoration:none; font-weight:500; font-size:0.8rem; border-radius:8px; border-left:none; transition:all 0.2s cubic-bezier(0.16,1,0.3,1); position:relative;">
                <i class="bi bi-envelope-paper" style="font-size:15px; width:20px; text-align:center; color:rgba(255,255,255,0.35); transition:all 0.2s; flex-shrink:0;"></i>
                <span>Messages</span>
            </a>
        </li>
    </ul>
</aside>

<style>
/* Sidebar hover & active states (inline CSS can't handle :hover, ::after) */
.sidebar-menu a::after {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%) scaleY(0);
    width: 3px;
    height: 18px;
    border-radius: 0 3px 3px 0;
    background: #6366f1;
    transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.sidebar-menu a:hover {
    background: rgba(99,102,241,0.1);
    color: #fff;
    padding-left: 16px;
}
.sidebar-menu a:hover i {
    color: #a5b4fc;
}
.sidebar-menu a.active {
    background: rgba(99,102,241,0.15);
    color: #fff;
    font-weight: 600;
    padding-left: 16px;
}
.sidebar-menu a.active::after {
    transform: translateY(-50%) scaleY(1);
}
.sidebar-menu a.active i {
    color: #818cf8;
}

/* Sidebar custom scrollbar */
#sidebarCollapse::-webkit-scrollbar { width: 4px; }
#sidebarCollapse::-webkit-scrollbar-track { background: transparent; }
#sidebarCollapse::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
#sidebarCollapse::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>
