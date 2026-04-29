# Dark Mode Website - Ambulance Dispatch

A modern, responsive website with a fully functional Dark Mode feature built with HTML, Tailwind CSS, and JavaScript.

## ✨ Features

### 1. **Clean, Modern & Responsive Design**
- Desktop and mobile optimized layouts
- Smooth animations and transitions
- Professional color schemes for both light and dark modes
- Gradient accents and hover effects

### 2. **Dark Mode Toggle**
- Beautiful, animated toggle button (🌙/☀️) in the navbar
- Smooth transitions between light and dark modes
- Rotates and scales on interaction
- Located in the top-right corner for easy access

### 3. **Theme Persistence**
- Saves user preference to localStorage
- Persists across page refreshes and browser sessions
- Key: `ambulance-dispatch-theme`
- Stores value: `dark-mode` or `light-mode`

### 4. **System Preference Detection**
- Automatically detects system theme preference using `prefers-color-scheme: dark`
- Applied only if no user preference is saved in localStorage
- User preference always takes priority

### 5. **Comprehensive Styling**
- All components support theme switching:
  - Navbar with smooth transitions
  - Hero section with gradient text
  - Service cards with hover effects
  - Feature list with icon animations
  - Stats section with gradients
  - CTA sections with prominent buttons
  - Footer with links

### 6. **Smooth Transitions**
- CSS transitions for all color changes (0.3s - 0.4s duration)
- No harsh color jumps
- Respects `prefers-reduced-motion` for accessibility

### 7. **Icons & Visual Elements**
- Font Awesome 6.4.0 icons integrated
- Ambulance icon in navbar
- Service and feature icons throughout
- Social media icons in footer
- Smooth icon transitions on theme change

### 8. **Mobile Responsive**
- Hamburger menu placeholder for mobile navigation
- Responsive grid layouts
- Touch-friendly buttons and interactive elements
- Mobile-optimized font sizes

## 📂 File Structure

```
.
├── dark-mode-demo.html       # Main HTML file with semantic structure
├── dark-mode-styles.css      # CSS variables and styling for both themes
└── dark-mode-script.js       # Dark mode manager and utility functions
```

## 🚀 How to Use

### 1. **Quick Start**
Simply open the HTML file in a web browser:
```bash
open dark-mode-demo.html
```

Or drag and drop the file into your browser.

### 2. **Toggle Dark Mode**
Click the moon/sun icon (🌙/☀️) in the top-right navbar to switch between:
- **Light Mode** (default)
- **Dark Mode**

The preference is automatically saved!

### 3. **Programmatic Access**
The JavaScript exposes global utility functions:

```javascript
// Toggle between dark and light modes
toggleTheme();

// Get current theme ('dark' or 'light')
getCurrentThemeMode();

// Set theme programmatically
setThemeMode('dark');   // or 'light'

// Get the manager instance
window.darkModeManager
```

## 🎨 Color System

### Light Mode
- Primary Background: `#ffffff`
- Secondary Background: `#f8fafc`
- Text Primary: `#1e293b`
- Text Secondary: `#64748b`
- Accent: `#f97316` (Orange)

### Dark Mode
- Primary Background: `#0f172a`
- Secondary Background: `#1e293b`
- Text Primary: `#f1f5f9`
- Text Secondary: `#cbd5e1`
- Accent: `#fb923c` (Lighter Orange)

All colors are defined as CSS variables in `:root` for easy customization.

## 🔧 Customization

### Change the Storage Key
Edit `dark-mode-script.js`:
```javascript
this.STORAGE_KEY = 'your-custom-key';
```

### Change Colors
Edit `dark-mode-styles.css`:
```css
:root {
    --bg-primary: #your-color;
    --text-primary: #your-color;
    /* ... etc */
}
```

### Change Animation Duration
Edit both CSS and HTML files, search for `duration-300` and change to your preferred duration.

### Add New Sections
Follow the existing pattern:
1. Add HTML with proper class names
2. Use CSS variables (e.g., `var(--text-primary)`)
3. Add `transition-colors duration-300` classes

## ✅ Browser Support

- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support
- Mobile Browsers: ✅ Full support (iOS Safari, Chrome Mobile, etc.)

## 🎯 Key Implementation Details

### localStorage Persistence
```javascript
localStorage.setItem('ambulance-dispatch-theme', 'dark-mode');
const theme = localStorage.getItem('ambulance-dispatch-theme');
```

### System Preference Detection
```javascript
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
```

### Theme Application
```javascript
document.body.classList.add('dark-mode');  // Apply dark theme
document.body.classList.remove('light-mode');
```

### CSS Variables
```css
body.dark-mode {
    --bg-primary: #0f172a;
    /* Theme switches instantly via variable values */
}
```

## 📱 Responsive Breakpoints

- Mobile: < 768px (md breakpoint)
- Tablet: 768px - 1024px
- Desktop: > 1024px

Uses Tailwind CSS responsive classes: `md:`, `lg:`, etc.

## ⚡ Performance Optimizations

1. **CSS Variables** - No JavaScript needed for basic theme switching
2. **Debouncing** - System preference changes debounced (300ms)
3. **Smooth Transitions** - Uses CSS transitions instead of JavaScript animations
4. **Efficient DOM Updates** - Only updates necessary elements
5. **Minimal JavaScript** - Small, focused manager class

## 🔐 Accessibility Features

1. **Color Contrast** - WCAG AA compliant color ratios
2. **Reduced Motion** - Respects `prefers-reduced-motion` media query
3. **Semantic HTML** - Proper heading hierarchy and structure
4. **Keyboard Navigation** - All buttons fully keyboard accessible
5. **Icon Labels** - Font Awesome icons with semantic meaning

## 🐛 Troubleshooting

### Dark Mode Not Persisting?
- Check browser's localStorage is enabled
- Look in DevTools → Application → Local Storage
- Verify the key is saved correctly

### Theme Not Applying on Page Load?
- Verify all three files are in the same directory
- Check browser console for JavaScript errors
- Ensure CDN links for Tailwind and Font Awesome are loading

### Colors Not Changing?
1. Check if CSS file is linked properly
2. Verify CSS variables are set correctly in `dark-mode-styles.css`
3. Clear browser cache (Ctrl+Shift+Delete)
4. Open DevTools and inspect element to see computed styles

### Mobile Navbar Not Responsive?
The current implementation has a placeholder for mobile menu. To implement:
- Add JavaScript for hamburger menu toggle
- Create slide-out navigation menu
- Update mobile breakpoint styling

## 📖 Documentation

All code is well-commented with detailed explanations:
- HTML: Component descriptions and structure
- CSS: Section headers for different theme areas
- JavaScript: Function documentation and usage examples

## 🎓 Learning Resources

This project demonstrates:
- CSS Custom Properties (Variables)
- localStorage API
- matchMedia API
- JavaScript Classes
- DOM Manipulation
- Responsive Design with Tailwind CSS
- Smooth Transitions and Animations

## 📝 License

Free to use and modify for personal and commercial projects.

---

**Ready to use!** Simply open `dark-mode-demo.html` in your browser and start exploring the dark mode feature. 🌙✨
