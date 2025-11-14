# 📱 Responsive Design Documentation

## Overview
Seluruh UI sistem SARPAS telah dioptimasi untuk tampilan mobile dengan menggunakan **mobile-first responsive design**. Semua halaman akan otomatis menyesuaikan layout di berbagai ukuran layar.

---

## ✅ Breakpoints

Sistem menggunakan 4 breakpoint utama:

| Breakpoint | Device Type | Max Width |
|------------|-------------|-----------|
| **Mobile Small** | Small phones | 480px |
| **Mobile** | Phones | 768px |
| **Tablet** | Tablets | 1024px |
| **Desktop** | Desktop/Laptop | 1280px+ |

---

## 🎨 Responsive Features

### 1. **Navigation Menu**
- ✅ Hamburger menu (☰) pada mobile
- ✅ Collapsible menu dengan toggle animation
- ✅ User info dan logout button di dalam mobile menu
- ✅ Full navigation bar di desktop

**Implementation:**
```html
<button class="mobile-menu-btn" onclick="toggleMenu()">☰</button>
<ul class="mono-nav-links" id="navLinks">
    <!-- Navigation items -->
</ul>
```

### 2. **Tables (Responsive Scrolling)**
- ✅ Horizontal scroll pada mobile
- ✅ Hide non-essential columns (.hide-mobile)
- ✅ Smooth touch scrolling (-webkit-overflow-scrolling)

**Implementation:**
```html
<div class="table-responsive">
    <table class="mono-table">
        <th class="hide-mobile">Detail</th> <!-- Hidden on mobile -->
    </table>
</div>
```

### 3. **Typography Scaling**
- ✅ Automatic font size reduction pada mobile
- ✅ Maintains readability across all devices

| Element | Desktop | Tablet | Mobile | Small Mobile |
|---------|---------|--------|--------|--------------|
| H1 (Hero) | 4rem | 3rem | 2rem | 1.75rem |
| H2 | 3rem | 2rem | 1.75rem | 1.5rem |
| H3 | 2rem | 1.75rem | 1.5rem | 1.25rem |

### 4. **Stats Grid**
- ✅ Auto-fit columns di desktop (repeat(auto-fit, minmax(180px, 1fr)))
- ✅ Single column layout di mobile
- ✅ Maintained padding dan spacing

### 5. **Forms**
- ✅ Full-width buttons di mobile
- ✅ Touch-friendly input sizes (min 44px)
- ✅ Prevent iOS zoom on focus (font-size: 16px)
- ✅ Stacked layout di mobile

### 6. **Cards & Buttons**
- ✅ Full-width buttons (.mono-btn → width: 100% on mobile)
- ✅ Small buttons (.mono-btn-sm) keep original width
- ✅ Reduced padding di mobile

---

## 📋 Updated Pages

### ✅ Admin Pages
1. **Dashboard** (`admin/dashboard_monochrome.blade.php`)
   - Responsive nav + hamburger menu
   - Responsive stats grid
   - Table with horizontal scroll
   - Hide columns on mobile

2. **Laporan** (`admin/laporan.blade.php`)
   - Responsive navigation
   - Responsive table
   - Mobile-friendly filters

3. **Pengaduan Detail** (`admin/pengaduan_detail.blade.php`)
   - Already responsive (standalone form)

### ✅ Petugas Pages
1. **Dashboard** (`petugas/dashboard_monochrome.blade.php`)
   - Responsive navigation
   - Responsive table with filters
   - Mobile-optimized pagination

### ✅ User Pages (Siswa/Guru)
1. **Dashboard** (`user/dashboard.blade.php`)
   - Responsive navigation
   - Stats grid → single column mobile
   - Table horizontal scroll

2. **Login/Register** (`Auth/login_monochrome.blade.php`)
   - Already responsive (centered form, max-width)

---

## 🛠️ CSS Utilities Added

### New Classes in `monochrome.css`:

```css
/* Table Responsive */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Hide/Show Utilities */
.hide-mobile        /* Hide on ≤768px */
.show-mobile        /* Show only on ≤768px */

/* Mobile Menu */
.mobile-menu-btn    /* Hamburger button (hidden on desktop) */
.mono-nav-links.active  /* Active state for mobile menu */

/* Grid Utilities */
.grid-responsive    /* 1 column on mobile */
.flex-responsive    /* Flex-direction: column on mobile */
```

---

## 📱 Testing Checklist

Test di semua breakpoints:

- [ ] **320px** - iPhone SE / Small phones
- [ ] **375px** - iPhone 12/13/14
- [ ] **414px** - iPhone Plus models
- [ ] **768px** - iPad Portrait
- [ ] **1024px** - iPad Landscape / Small laptop
- [ ] **1280px+** - Desktop

### Test Scenarios:
1. ✅ Navigation menu toggle works
2. ✅ Tables scroll horizontally on mobile
3. ✅ Forms are easy to fill on touch devices
4. ✅ Buttons are large enough (min 44px tap target)
5. ✅ Text is readable (no zoom needed)
6. ✅ Stats grid stacks properly on mobile
7. ✅ No horizontal overflow issues

---

## 🚀 Browser DevTools Testing

### Chrome DevTools:
1. Press `F12`
2. Click **Toggle Device Toolbar** (Ctrl+Shift+M)
3. Select device: iPhone 12 Pro, iPad, etc.
4. Test navigation, tables, forms

### Responsive Mode:
- Test portrait & landscape orientations
- Verify touch targets are ≥44px
- Check font sizes (no iOS auto-zoom)

---

## 🔧 JavaScript Functions

### Mobile Menu Toggle:
```javascript
function toggleMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.toggle('active');
}
```

**Usage:** Called by hamburger button (☰) on all pages

---

## 📦 Files Modified

### CSS:
- `resources/css/monochrome.css` (added ~200 lines responsive code)

### Blade Templates:
1. `resources/views/admin/dashboard_monochrome.blade.php`
2. `resources/views/admin/laporan.blade.php`
3. `resources/views/petugas/dashboard_monochrome.blade.php`
4. `resources/views/user/dashboard.blade.php`

### Already Responsive:
- `resources/views/Auth/login_monochrome.blade.php`
- `resources/views/Auth/register_monochrome.blade.php`

---

## 🎯 Design Principles

1. **Mobile-First**: Base styles for mobile, desktop enhancements
2. **Touch-Friendly**: Min 44px tap targets
3. **Progressive Enhancement**: Works without JS, better with JS
4. **Performance**: Minimal CSS, no heavy frameworks
5. **Accessibility**: Semantic HTML, keyboard navigation

---

## 🐛 Known Issues / Future Improvements

### ✅ Completed:
- [x] Mobile navigation
- [x] Responsive tables
- [x] Typography scaling
- [x] Form optimization
- [x] Grid layouts

### 🔄 Potential Improvements:
- [ ] Add swipe gestures for table scrolling
- [ ] Add loading skeletons for better perceived performance
- [ ] Optimize images for mobile (lazy loading)
- [ ] Add PWA manifest for "Add to Home Screen"

---

## 📞 Support

Jika ada masalah dengan responsive design:

1. **Clear browser cache** (Ctrl+Shift+Delete)
2. **Run:** `npm run build` untuk recompile CSS
3. **Check:** Browser DevTools Console untuk error
4. **Test:** Di real device (bukan hanya emulator)

---

**Last Updated:** <?= date('Y-m-d H:i:s') ?>  
**Version:** 1.0  
**Status:** ✅ Production Ready
