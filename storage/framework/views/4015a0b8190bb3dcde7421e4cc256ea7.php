<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Ambulance Dispatch GMCI')); ?></title>

    <!-- Tailwind CSS (CDN, tanpa Vite) -->
    <script>
        window.tailwind = {
            config: {
                darkMode: 'class',
            }
        };

        // Apply initial theme before Tailwind renders styles.
        try {
            const stored = localStorage.getItem('darkMode');
            const shouldUseDark = stored === 'true';
            document.documentElement.classList.toggle('dark', shouldUseDark);
            document.documentElement.dataset.theme = shouldUseDark ? 'dark' : 'light';
        } catch (error) {
            console.warn('Unable to read darkMode from localStorage:', error);
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js (Core) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Smooth transitions for dark mode */
        html {
            color-scheme: light;
        }

        html.dark {
            color-scheme: dark;
        }

        html:not(.dark) body {
            background-color: #ffffff !important;
            color: #111827 !important;
        }

        html:not(.dark) .bg-white {
            background-color: #ffffff !important;
        }

        html:not(.dark) .bg-gray-50 {
            background-color: #f9fafb !important;
        }

        html:not(.dark) .bg-slate-50 {
            background-color: #f8fafc !important;
        }

        html:not(.dark) nav {
            background-color: #ffffff !important;
            color: #1f2937 !important;
        }

        html:not(.dark) nav a,
        html:not(.dark) nav button {
            color: #1f2937 !important;
        }

        html:not(.dark) .text-gray-900 {
            color: #111827 !important;
        }

        html:not(.dark) .text-gray-100:not([class*="dark:text-"]),
        html:not(.dark) .text-gray-200:not([class*="dark:text-"]),
        html:not(.dark) .text-gray-300:not([class*="dark:text-"]),
        html:not(.dark) .text-gray-400:not([class*="dark:text-"]),
        html:not(.dark) .text-slate-100:not([class*="dark:text-"]),
        html:not(.dark) .text-slate-200:not([class*="dark:text-"]),
        html:not(.dark) .text-slate-300:not([class*="dark:text-"]),
        html:not(.dark) .text-slate-400:not([class*="dark:text-"]) {
            color: #111827 !important;
        }

        html.dark body {
            background-color: #111827 !important;
            color: #f8fafc !important;
        }

        html.dark .bg-white:not([class*="dark:bg-"]),
        html.dark .bg-gray-50:not([class*="dark:bg-"]),
        html.dark .bg-gray-100:not([class*="dark:bg-"]),
        html.dark .bg-slate-50:not([class*="dark:bg-"]),
        html.dark .bg-blue-50:not([class*="dark:bg-"]),
        html.dark .bg-green-50:not([class*="dark:bg-"]),
        html.dark .bg-yellow-100:not([class*="dark:bg-"]),
        html.dark .bg-orange-100:not([class*="dark:bg-"]),
        html.dark .bg-red-100:not([class*="dark:bg-"]),
        html.dark .bg-indigo-50:not([class*="dark:bg-"]) {
            background-color: #1f2937 !important;
        }

        html.dark .border-gray-200:not([class*="dark:border-"]),
        html.dark .border-gray-100:not([class*="dark:border-"]),
        html.dark .border-gray-300:not([class*="dark:border-"]),
        html.dark .divide-gray-200:not([class*="dark:divide-"]),
        html.dark .divide-gray-50:not([class*="dark:divide-"]) {
            border-color: #374151 !important;
        }

        html.dark .text-gray-900:not([class*="dark:text-"]),
        html.dark .text-gray-800:not([class*="dark:text-"]),
        html.dark .text-gray-700:not([class*="dark:text-"]),
        html.dark .text-gray-600:not([class*="dark:text-"]),
        html.dark .text-gray-500:not([class*="dark:text-"]),
        html.dark .text-gray-400:not([class*="dark:text-"]),
        html.dark .text-gray-300:not([class*="dark:text-"]),
        html.dark .text-gray-200:not([class*="dark:text-"]),
        html.dark .text-slate-900:not([class*="dark:text-"]),
        html.dark .text-slate-800:not([class*="dark:text-"]),
        html.dark .text-slate-700:not([class*="dark:text-"]),
        html.dark .text-slate-600:not([class*="dark:text-"]),
        html.dark .text-slate-500:not([class*="dark:text-"]),
        html.dark .text-slate-400:not([class*="dark:text-"]),
        html.dark .text-slate-300:not([class*="dark:text-"]),
        html.dark .text-slate-200:not([class*="dark:text-"]),
        html.dark .text-black:not([class*="dark:text-"]) {
            color: #f8fafc !important;
        }

        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        [x-cloak] { display: none !important; }

        /* Leaflet control & popup text styling for both themes */
        .leaflet-control,
        .leaflet-popup-content,
        .leaflet-popup-content-wrapper,
        .leaflet-popup-tip {
            transition: background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        html:not(.dark) .leaflet-control,
        html:not(.dark) .leaflet-popup-content,
        html:not(.dark) .leaflet-popup-content-wrapper {
            background: rgba(255,255,255,0.95) !important;
            color: #111827 !important;
            box-shadow: 0 0 0 1px rgba(15,23,42,0.08) !important;
        }

        html:not(.dark) .leaflet-popup-content a,
        html:not(.dark) .leaflet-control a {
            color: #1f2937 !important;
        }

        html.dark .leaflet-control,
        html.dark .leaflet-popup-content,
        html.dark .leaflet-popup-content-wrapper {
            background: rgba(15,23,42,0.9) !important;
            color: #f8fafc !important;
            box-shadow: 0 0 0 1px rgba(255,255,255,0.08) !important;
        }

        html.dark .leaflet-popup-content a,
        html.dark .leaflet-control a {
            color: #f8fafc !important;
        }

        .transition-colors {
            transition-property: background-color, border-color, color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-50 min-h-screen transition-colors">

    
    <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Dark Mode Script -->
    <script>
        function setDarkMode(isDark) {
            console.log('setDarkMode called with:', isDark);

            document.documentElement.classList.toggle('dark', isDark);
            document.documentElement.dataset.theme = isDark ? 'dark' : 'light';
            console.log('HTML dark class:', document.documentElement.classList.contains('dark'));
            console.log('HTML dataset theme:', document.documentElement.dataset.theme);

            const darkIcon = document.getElementById('dark-mode-icon');
            const lightIcon = document.getElementById('light-mode-icon');
            if (darkIcon && lightIcon) {
                if (isDark) {
                    darkIcon.classList.add('hidden');
                    lightIcon.classList.remove('hidden');
                } else {
                    darkIcon.classList.remove('hidden');
                    lightIcon.classList.add('hidden');
                }
                console.log('Icons updated - isDark:', isDark);
            }
        }

        function initDarkMode() {
            let isDark = false;
            try {
                const stored = localStorage.getItem('darkMode');
                isDark = stored === 'true';
                console.log('initDarkMode - stored value:', stored, 'isDark:', isDark);
            } catch (error) {
                console.warn('Unable to read darkMode from localStorage:', error);
            }
            setDarkMode(isDark);
        }

        function toggleDarkMode() {
            const currentState = document.documentElement.classList.contains('dark');
            console.log('toggleDarkMode called - currentState:', currentState);
            const newState = !currentState;
            setDarkMode(newState);
            try {
                localStorage.setItem('darkMode', newState);
                console.log('Saved to localStorage:', newState);
            } catch (error) {
                console.warn('Unable to save darkMode to localStorage:', error);
            }
        }

        console.log('Dark mode script loading...');
        initDarkMode();

        const toggle = document.getElementById('dark-mode-toggle');
        if (toggle) {
            toggle.addEventListener('click', toggleDarkMode);
            console.log('Event listener attached to toggle button');
        } else {
            console.warn('Dark mode toggle button not found in DOM');
        }
        console.log('Dark mode script loaded');
    </script>
</body>
</html>
<?php /**PATH /Applications/Dev/ambulance-dispatch/resources/views/layouts/app.blade.php ENDPATH**/ ?>