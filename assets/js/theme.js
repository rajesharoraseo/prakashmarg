// assets/js/theme.js
// This script runs early in the <head> to prevent FOUC (Flash of Unstyled Content)
(function() {
    try {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme === 'dark' || (!storedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    } catch (e) {
        console.error('Theme retrieval failed', e);
    }
})();
