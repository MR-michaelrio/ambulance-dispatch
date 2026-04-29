# Dark Mode Implementation Guide

## Overview
A comprehensive Dark Mode feature has been implemented for the Ambulance Dispatch System with smooth transitions, localStorage persistence, and automatic system preference detection.

## Features Implemented

### 1. ✨ Smooth Mode Switching
- **Instant Toggle**: Click the moon (🌙) or sun (☀️) icon to switch modes
- **Smooth Transitions**: All color changes transition smoothly over 300ms
- **Visual Feedback**: Button includes hover scale animation (110%)

### 2. 💾 Persistent Storage
- **localStorage Support**: User preference is saved in browser storage
- **Automatic Restoration**: Preference persists across page refreshes and browser restarts
- **System Detection Fallback**: If no saved preference exists, auto-detects system preference

### 3. 🎨 Comprehensive Styling
- **Full Coverage**: All components support dark mode
- **Comfortable Colors**: Carefully selected color palette for extended viewing
- **Proper Contrast**: All text and elements maintain readability in both modes

## File Changes

### Configuration
- **`tailwind.config.js`** - Added `darkMode: 'class'` strategy

### Core Files
- **`resources/views/layouts/app.blade.php`** - Added dark mode script and Alpine.js integration
- **`resources/views/layouts/navigation.blade.php`** - Added toggle button with icons, styled for dark mode
- **`resources/views/components/app-layout.blade.php`** - New component for app layout

### Components with Dark Mode
- **`resources/views/components/text-input.blade.php`** - Form inputs with dark styling
- **`resources/views/components/input-label.blade.php`** - Form labels with dark styling
- **`resources/views/components/input-error.blade.php`** - Error messages with dark styling
- **`resources/views/components/primary-button.blade.php`** - Primary buttons with dark styling
- **`resources/views/components/secondary-button.blade.php`** - Secondary buttons with dark styling
- **`resources/views/components/danger-button.blade.php`** - Danger buttons with dark styling
- **`resources/views/components/modal.blade.php`** - Modal dialogs with dark styling

### Pages with Dark Mode
- **`resources/views/dashboard.blade.php`** - Dashboard with feature cards
- **`resources/views/profile/edit.blade.php`** - Profile page with dark styling
- **`resources/views/profile/partials/update-profile-information-form.blade.php`**
- **`resources/views/profile/partials/update-password-form.blade.php`**
- **`resources/views/profile/partials/delete-user-form.blade.php`**

### Demo File
- **`dark-mode-demo.html`** - Standalone HTML demo (no Laravel required)

## How Dark Mode Works

### JavaScript Logic
```javascript
function darkMode() {
    return {
        isDark: false,
        
        // Initialize on page load
        initDarkMode() {
            const stored = localStorage.getItem('darkMode');
            if (stored !== null) {
                this.isDark = stored === 'true'; // Use saved preference
            } else {
                // Detect system preference
                this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            this.applyDarkMode();
        },
        
        // Toggle function
        toggleDarkMode() {
            this.isDark = !this.isDark;
            localStorage.setItem('darkMode', this.isDark); // Save preference
            this.applyDarkMode();
        },
        
        // Apply dark class to HTML element
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

### Tailwind CSS Integration
Used Tailwind's `dark:` prefix for dark mode styles:
```html
<!-- Light mode: bg-white, Dark mode: bg-gray-800 -->
<div class="bg-white dark:bg-gray-800">
    <!-- Light text: text-gray-900, Dark text: text-white -->
    <p class="text-gray-900 dark:text-white">Content</p>
</div>
```

## Testing

### Test the Demo File
1. Open `dark-mode-demo.html` in your browser
2. Click the moon/sun icon in the top-right navbar
3. Watch the smooth color transition
4. Refresh the page - mode persists
5. Open Developer Tools → Application → LocalStorage to verify `darkMode` key

### Test in Laravel Application
1. Start the development server: `php artisan serve`
2. Navigate to the dashboard
3. Click the toggle button in the navbar
4. Visit different pages to see dark mode applied everywhere
5. Refresh page - preference is remembered

## Browser Support
- ✅ Chrome/Edge 76+
- ✅ Firefox 67+
- ✅ Safari 14+
- ✅ All modern browsers with CSS custom properties support

## Color Palette

### Light Mode (Default)
- Background: `bg-white` (#ffffff)
- Dark Background: `bg-gray-50` (#f9fafb)
- Text: `text-gray-900` (#111827)
- Border: `border-gray-200` (#e5e7eb)

### Dark Mode
- Background: `dark:bg-gray-900` (#111827)
- Dark Background: `dark:bg-gray-800` (#1f2937)
- Text: `dark:text-white` (#ffffff)
- Text Secondary: `dark:text-gray-400` (#9ca3af)
- Border: `dark:border-gray-700` (#374151)

## Performance Considerations
- **No Flash**: Dark mode applies before DOM render
- **Minimal JavaScript**: Uses Alpine.js (already included)
- **CSS-Based**: Leverages Tailwind CSS, no runtime overhead
- **LocalStorage**: Fast browser-native storage

## Accessibility
- ✅ High Contrast: Text remains readable in both modes
- ✅ Respects System Preference: Honors `prefers-color-scheme`
- ✅ Focus Indicators: Maintained in both modes
- ✅ Color Independence: Not relying on color alone for information

## Future Enhancements (Optional)
- Add system preference listener for dynamic theme switching
- Create theme customization panel (user selects specific colors)
- Add scheduled theme switching (dark mode at night, etc.)
- Implement theme selection in user preferences
- Add Cookies for cross-device synchronization

## Troubleshooting

### Dark mode not working?
1. Check browser console for JavaScript errors
2. Verify Tailwind CSS is loaded
3. Check that `darkMode: 'class'` is in `tailwind.config.js`
4. Clear browser cache and localStorage

### Flash of white on page load?
- Add `<style>` tag in `<head>` before other styles to apply dark mode synchronously

### Some elements not changing color?
- Ensure dark mode classes are applied:
  - Example: `dark:bg-gray-800` for background in dark mode
  - Check component class definitions

## Support
For issues or questions about the dark mode implementation, refer to:
- [Tailwind CSS Dark Mode Docs](https://tailwindcss.com/docs/dark-mode)
- [Alpine.js Documentation](https://alpinejs.dev/)
