<!DOCTYPE html>
<html lang="en" x-data="darkMode()" :class="isDark ? 'dark' : ''" @load="initDarkMode()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Ambulance Dispatch GMCI'))</title>

    <!-- Tailwind CSS (CDN, tanpa Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js (Core) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Dark Mode Script -->
    <script>
        function darkMode() {
            return {
                isDark: false,
                initDarkMode() {
                    // Check localStorage first
                    const stored = localStorage.getItem('darkMode');
                    if (stored !== null) {
                        this.isDark = stored === 'true';
                    } else {
                        // Check system preference
                        this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    }
                    this.applyDarkMode();
                },
                toggleDarkMode() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('darkMode', this.isDark);
                    this.applyDarkMode();
                },
                applyDarkMode() {
                    if (this.isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>

    <style>
        /* Smooth transitions for dark mode */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .transition-colors {
            transition-property: background-color, border-color, color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-50 min-h-screen transition-colors">

    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

</body>
</html>
