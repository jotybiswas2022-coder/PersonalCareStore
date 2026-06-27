/* ============================================================
   Custom Admin JS — Mobile Sidebar Toggle
   ============================================================ */

(function () {
    'use strict';

    const sidebar = document.getElementById('sidebarCollapse');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    const closeBtn = document.querySelector('.sidebar-close button');
    let bodyScrollLocked = false;

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('open');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        bodyScrollLocked = true;
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
        bodyScrollLocked = false;
    }

    // Toggle button click
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    // Close button click
    if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeSidebar();
        });
    }

    // Overlay click
    if (overlay) {
        overlay.addEventListener('click', function () {
            closeSidebar();
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Handle window resize — close sidebar on desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768 && sidebar && sidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // Auto-close sidebar when clicking a nav link on mobile
    if (sidebar) {
        sidebar.querySelectorAll('.sidebar-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 768) {
                    closeSidebar();
                }
            });
        });
    }

})();
