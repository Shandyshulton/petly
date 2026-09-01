// Global theme (dark/light) manager.
// Persists the choice in localStorage and toggles `.dark` on <html>.
(function () {
    const KEY = 'theme';

    function apply(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    function current() {
        const saved = localStorage.getItem(KEY);
        if (saved === 'dark' || saved === 'light') return saved;
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // Apply as early as possible to avoid a flash of the wrong theme
    apply(current());

    window.petlyTheme = {
        get: current,
        set: function (theme) {
            localStorage.setItem(KEY, theme);
            apply(theme);
        },
        toggle: function () {
            const next = current() === 'dark' ? 'light' : 'dark';
            this.set(next);
            return next;
        },
    };
    window.setTheme = window.petlyTheme.set;

    // Optional: wire up radio inputs used by the theme page (theme-light / theme-dark)
    document.addEventListener('DOMContentLoaded', function () {
        const light = document.getElementById('theme-light');
        const dark = document.getElementById('theme-dark');

        if (light && dark) {
            if (current() === 'dark') dark.checked = true;
            else light.checked = true;

            light.addEventListener('change', function () {
                if (light.checked) window.petlyTheme.set('light');
            });
            dark.addEventListener('change', function () {
                if (dark.checked) window.petlyTheme.set('dark');
            });
        }
    });
})();
