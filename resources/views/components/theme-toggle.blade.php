<button type="button"
    x-data="{ theme: window.petlyTheme ? window.petlyTheme.get() : (document.documentElement.classList.contains('dark') ? 'dark' : 'light') }"
    @petly-theme-change.window="theme = $event.detail.theme"
    @click="theme = window.petlyTheme ? window.petlyTheme.toggle() : (theme === 'dark' ? 'light' : 'dark'); if (!window.petlyTheme) { localStorage.setItem('theme', theme); document.documentElement.classList.toggle('dark', theme === 'dark') }"
    :aria-label="theme === 'dark' ? 'Switch to light theme' : 'Switch to dark theme'"
    :title="theme === 'dark' ? 'Light mode' : 'Dark mode'"
    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-[#FE9494] hover:text-[#FE9494] dark:border-slate-700 dark:bg-slate-800 dark:text-gray-200 dark:hover:border-[#FE9494] dark:hover:text-[#FE9494]">
    <i class="text-xl" :class="theme === 'dark' ? 'ri-sun-line' : 'ri-moon-line'"></i>
</button>
