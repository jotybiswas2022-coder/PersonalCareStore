<script>
    (function () {
        document.querySelectorAll('.pw-toggle').forEach(function (btn) {
            var wrap = btn.closest('.input-wrap');
            var input = wrap ? wrap.querySelector('input') : null;
            var icons = btn.querySelectorAll('svg');
            if (!input || icons.length < 2) return;

            btn.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-pressed', show ? 'true' : 'false');
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                icons[0].style.display = show ? 'none' : '';
                icons[1].style.display = show ? '' : 'none';
                input.focus();
            });
        });
    })();
</script>
