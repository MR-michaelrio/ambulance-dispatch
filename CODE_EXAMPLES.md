# Dark Mode Code Examples

## 1. Basic Dark Mode Setup

### tailwind.config.js
```javascript
export default {
    darkMode: 'class', // ← This enables dark mode
    // ... rest of config
}
```

## 2. Dark Mode Script (in app.blade.php)

```javascript
function darkMode() {
    return {
        isDark: false,
        
        // Called on page load
        initDarkMode() {
            const stored = localStorage.getItem('darkMode');
            if (stored !== null) {
                this.isDark = stored === 'true';
            } else {
                // Detect system preference on first visit
                this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            this.applyDarkMode();
        },
        
        // Called when toggle button is clicked
        toggleDarkMode() {
            this.isDark = !this.isDark;
            localStorage.setItem('darkMode', this.isDark); // Save preference
            this.applyDarkMode();
        },
        
        // Apply 'dark' class to HTML
        applyDarkMode() {
            if (this.isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }
}
```

## 3. Toggle Button (in navigation.blade.php)

```html
<!-- Dark Mode Toggle Button -->
<button 
    @click="toggleDarkMode()" 
    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-300 transform hover:scale-110"
    title="Toggle Dark Mode">
    <span x-show="!isDark" class="block text-xl">🌙</span>
    <span x-show="isDark" class="block text-xl">☀️</span>
</button>
```

## 4. Component Styling Examples

### Form Input
```html
<input 
    class="border-gray-300 dark:border-gray-600 
           bg-white dark:bg-gray-700 
           text-gray-900 dark:text-gray-50 
           focus:border-indigo-500 dark:focus:border-indigo-400 
           dark:focus:ring-indigo-400 
           transition-colors">
```

### Card Component
```html
<div class="bg-white dark:bg-gray-800 
            shadow dark:shadow-lg 
            border border-gray-200 dark:border-gray-700 
            rounded-lg p-6 
            transition-colors">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        Title
    </h3>
    <p class="text-gray-600 dark:text-gray-400">
        Content
    </p>
</div>
```

### Button Component
```html
<button class="bg-gray-800 dark:bg-indigo-600 
               hover:bg-gray-700 dark:hover:bg-indigo-700 
               text-white 
               focus:ring-indigo-500 dark:focus:ring-indigo-400 
               focus:ring-offset-2 dark:focus:ring-offset-gray-900 
               transition ease-in-out duration-150">
    Save
</button>
```

### Badge/Label
```html
<span class="bg-blue-100 dark:bg-blue-900 
             text-blue-800 dark:text-blue-200 
             px-3 py-1 rounded-full text-xs font-medium">
    Active
</span>
```

## 5. Form Label
```html
<label class="block font-medium text-sm 
              text-gray-700 dark:text-gray-300 
              transition-colors">
    {{ $value }}
</label>
```

## 6. Error Message
```html
@if ($messages)
    <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 transition-colors">
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
```

## 7. Modal Overlay
```html
<!-- Backdrop -->
<div class="absolute inset-0 
            bg-gray-500 dark:bg-gray-900 
            opacity-75 dark:opacity-90">
</div>

<!-- Modal Box -->
<div class="bg-white dark:bg-gray-800 
            rounded-lg overflow-hidden 
            shadow-xl dark:shadow-2xl 
            border border-gray-200 dark:border-gray-700">
    {{ $slot }}
</div>
```

## 8. Navigation Link with Dark Mode
```html
<a href="#" class="text-sm font-medium 
                  text-gray-700 dark:text-gray-300 
                  hover:text-indigo-600 
                  dark:hover:text-indigo-400 
                  transition-colors">
    Link
</a>
```

## 9. Full Page Example

```html
<!DOCTYPE html>
<html lang="en" x-data="darkMode()" :class="isDark ? 'dark' : ''" @load="initDarkMode()">
<head>
    <meta charset="UTF-8">
    <title>Page Title</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-50 transition-colors">
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold">App</h1>
            <button @click="toggleDarkMode()" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                <span x-show="!isDark">🌙</span>
                <span x-show="isDark">☀️</span>
            </button>
        </div>
    </nav>

    <main class="p-6">
        <div class="bg-white dark:bg-gray-800 rounded p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Content</h2>
            <p class="text-gray-600 dark:text-gray-400">Dark mode works!</p>
        </div>
    </main>

    <script>
        function darkMode() {
            return {
                isDark: false,
                initDarkMode() {
                    const stored = localStorage.getItem('darkMode');
                    if (stored !== null) {
                        this.isDark = stored === 'true';
                    } else {
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
</body>
</html>
```

## 10. Common Tailwind Dark Mode Patterns

### Text Colors
```html
<!-- Light text → Dark text -->
<p class="text-gray-900 dark:text-white">Primary text</p>
<p class="text-gray-600 dark:text-gray-400">Secondary text</p>
<p class="text-gray-500 dark:text-gray-500">Tertiary text</p>
```

### Background Colors
```html
<!-- Light background → Dark background -->
<div class="bg-white dark:bg-gray-800">Primary card</div>
<div class="bg-gray-50 dark:bg-gray-900">Secondary bg</div>
<div class="bg-gray-100 dark:bg-gray-700">Tertiary bg</div>
```

### Borders
```html
<!-- Light border → Dark border -->
<div class="border border-gray-200 dark:border-gray-700">Card</div>
<div class="border border-gray-300 dark:border-gray-600">Input</div>
```

### Shadows
```html
<!-- Light shadow → Dark shadow -->
<div class="shadow dark:shadow-lg">Card</div>
<div class="shadow-md dark:shadow-xl">Modal</div>
```

### Hover States
```html
<button class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
    Hover me
</button>
```

## 11. Color Mapping Reference

| Component | Light | Dark |
|-----------|-------|------|
| Text | `text-gray-900` | `dark:text-white` |
| Muted Text | `text-gray-600` | `dark:text-gray-400` |
| Background | `bg-white` | `dark:bg-gray-800` |
| Card | `bg-white` | `dark:bg-gray-800` |
| Input | `bg-white` | `dark:bg-gray-700` |
| Border | `border-gray-200` | `dark:border-gray-700` |
| Shadow | `shadow` | `dark:shadow-lg` |
| Hover | `hover:bg-gray-100` | `dark:hover:bg-gray-700` |

## 12. Copy-Paste Ready Classes

```html
<!-- Navigation -->
class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm dark:shadow-xl transition-colors"

<!-- Card -->
class="bg-white dark:bg-gray-800 shadow dark:shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 transition-colors"

<!-- Button (Primary) -->
class="bg-indigo-600 dark:bg-indigo-700 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white transition-colors"

<!-- Input -->
class="border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-50 transition-colors"

<!-- Text -->
class="text-gray-900 dark:text-white"

<!-- Secondary Text -->
class="text-gray-600 dark:text-gray-400"
```

---

## Testing Dark Mode

### Quick Test
1. Open `dark-mode-demo.html` in browser
2. Click moon/sun icon
3. Refresh page - mode persists
4. Open DevTools → Application → LocalStorage → find `darkMode` key

### In Laravel
1. Run `php artisan serve`
2. Visit `/dashboard`
3. Click toggle button in navbar
4. Check localStorage in browser DevTools
5. Verify all pages show dark styling

---

## Performance Tips

1. **Use CSS Classes**: Dark mode is CSS-based, no JavaScript overhead
2. **Leverage Tailwind**: Built-in optimization through purge/content config
3. **No Repaints Needed**: Class toggle on html element cascades to all children
4. **Smooth Transitions**: CSS handles all color changes, no JS required
5. **Minimal Bundle Size**: No additional packages needed (uses Tailwind + Alpine.js already included)

---

Happy dark mode building! 🌙✨
