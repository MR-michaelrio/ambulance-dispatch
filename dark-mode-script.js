/* =====================================================
   Dark Mode Script - JavaScript
   ===================================================== */

class DarkModeManager {
    constructor() {
        this.STORAGE_KEY = 'ambulance-dispatch-theme';
        this.DARK_CLASS = 'dark-mode';
        this.LIGHT_CLASS = 'light-mode';
        this.toggle = document.getElementById('darkModeToggle');

        this.init();
    }

    /**
     * Initialize the dark mode manager
     * Sets up event listeners and loads saved preference
     */
    init() {
        // Load saved theme or use system preference
        this.loadTheme();

        // Add click event listener to toggle button
        if (this.toggle) {
            this.toggle.addEventListener('click', () => this.toggleDarkMode());
        }

        // Listen for system theme changes
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                // Only apply if user hasn't set a preference
                if (!this.hasUserPreference()) {
                    this.setTheme(e.matches ? this.DARK_CLASS : this.LIGHT_CLASS);
                }
            });
        }
    }

    /**
     * Check if user has saved a theme preference
     */
    hasUserPreference() {
        return localStorage.getItem(this.STORAGE_KEY) !== null;
    }

    /**
     * Load theme from localStorage or system preference
     */
    loadTheme() {
        const savedTheme = localStorage.getItem(this.STORAGE_KEY);

        if (savedTheme) {
            // Use saved preference
            this.setTheme(savedTheme);
        } else {
            // Use system preference
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            this.setTheme(prefersDark ? this.DARK_CLASS : this.LIGHT_CLASS);
        }
    }

    /**
     * Set the theme and update all DOM elements
     */
    setTheme(theme) {
        const body = document.body;
        const html = document.documentElement;

        // Remove both classes first
        body.classList.remove(this.DARK_CLASS, this.LIGHT_CLASS);
        html.classList.remove(this.DARK_CLASS, this.LIGHT_CLASS);

        // Add the desired class
        body.classList.add(theme);
        html.classList.add(theme);

        // Update meta theme-color for mobile browsers
        this.updateMetaThemeColor(theme === this.DARK_CLASS);

        // Trigger any animations
        this.animateToggle(theme === this.DARK_CLASS);

        // Log for debugging (optional)
        console.log(`Theme changed to: ${theme}`);
    }

    /**
     * Toggle between dark and light mode
     */
    toggleDarkMode() {
        const isDarkMode = document.body.classList.contains(this.DARK_CLASS);
        const newTheme = isDarkMode ? this.LIGHT_CLASS : this.DARK_CLASS;

        // Save preference
        localStorage.setItem(this.STORAGE_KEY, newTheme);

        // Apply theme
        this.setTheme(newTheme);
    }

    /**
     * Update meta theme-color for better mobile experience
     */
    updateMetaThemeColor(isDark) {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');

        if (!metaThemeColor) {
            metaThemeColor = document.createElement('meta');
            metaThemeColor.name = 'theme-color';
            document.head.appendChild(metaThemeColor);
        }

        // Set appropriate color for dark/light mode
        metaThemeColor.content = isDark ? '#1e293b' : '#ffffff';
    }

    /**
     * Animate the toggle button
     */
    animateToggle(isDark) {
        if (!this.toggle) return;

        // Add animation class
        this.toggle.style.animation = 'none';
        
        // Trigger reflow to restart animation
        void this.toggle.offsetWidth;
        
        this.toggle.style.animation = '';

        // Update icon
        const icon = this.toggle.querySelector('i');
        if (icon) {
            icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        }
    }

    /**
     * Get current theme
     */
    getCurrentTheme() {
        return document.body.classList.contains(this.DARK_CLASS) ? 'dark' : 'light';
    }

    /**
     * Reset to system preference
     */
    resetToSystemPreference() {
        localStorage.removeItem(this.STORAGE_KEY);
        this.loadTheme();
    }
}

// =====================================================
// Initialize Dark Mode Manager when DOM is ready
// =====================================================

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new DarkModeManager();
    });
} else {
    new DarkModeManager();
}

// =====================================================
// Additional Utility Functions
// =====================================================

/**
 * Global function to toggle dark mode programmatically
 * Usage: toggleTheme()
 */
window.toggleTheme = function () {
    const manager = window.darkModeManager || new DarkModeManager();
    manager.toggleDarkMode();
};

/**
 * Global function to get current theme
 * Usage: getCurrentThemeMode()
 */
window.getCurrentThemeMode = function () {
    const body = document.body;
    return body.classList.contains('dark-mode') ? 'dark' : 'light';
};

/**
 * Global function to set theme programmatically
 * Usage: setThemeMode('dark') or setThemeMode('light')
 */
window.setThemeMode = function (mode) {
    const body = document.body;
    const isDark = mode === 'dark';
    
    // Remove both classes
    body.classList.remove('dark-mode', 'light-mode');
    
    // Add the appropriate class
    body.classList.add(isDark ? 'dark-mode' : 'light-mode');
    
    // Save preference
    localStorage.setItem('ambulance-dispatch-theme', isDark ? 'dark-mode' : 'light-mode');
};

// Store manager instance for global access
window.darkModeManager = new DarkModeManager();

/* =====================================================
   Smooth Scroll Behavior Enhancement
   ===================================================== */

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        
        // Only prevent default if it's a valid anchor
        if (href !== '#' && document.querySelector(href)) {
            e.preventDefault();
            const element = document.querySelector(href);
            
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

/* =====================================================
   Performance Optimization - Debouncing
   ===================================================== */

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Debounce theme changes from system
const debouncedThemeChange = debounce(function () {
    const manager = window.darkModeManager;
    if (manager && !manager.hasUserPreference()) {
        manager.loadTheme();
    }
}, 300);
