document.addEventListener("DOMContentLoaded", function () {
    const themeLight = document.getElementById("theme-light");
    const themeDark = document.getElementById("theme-dark");

    function setTheme(theme) {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
            themeDark.checked = true;
        } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            themeLight.checked = true;
        }
    }

    function loadTheme() {
        const savedTheme = localStorage.getItem("theme") || "light";
        setTheme(savedTheme);
    }

    // Event listener untuk radio button
    themeLight.addEventListener("change", () => setTheme("light"));
    themeDark.addEventListener("change", () => setTheme("dark"));

    // Panggil fungsi loadTheme saat halaman dimuat
    loadTheme();
});
