# 📚 UI Libraries Documentation

## Installed Libraries

Website Jeycookie sekarang dilengkapi dengan library modern untuk UI yang rapi dan profesional:

### 1. **DaisyUI** (v4.12.14)
- Component library built on Tailwind CSS
- Menyediakan pre-built components: buttons, cards, alerts, modals, dropdowns, dll
- Dokumentasi: https://daisyui.com

**Contoh penggunaan:**
```html
<!-- Button -->
<button class="btn btn-primary">Click Me</button>

<!-- Alert -->
<div class="alert alert-success">
  <i class="fas fa-check-circle"></i>
  <span>Success Message</span>
</div>

<!-- Card -->
<div class="card bg-base-100 shadow-xl">
  <div class="card-body">
    <h2 class="card-title">Title</h2>
  </div>
</div>

<!-- Dropdown -->
<div class="dropdown">
  <button class="btn">Menu</button>
  <ul class="dropdown-content menu">
    <li><a>Item 1</a></li>
    <li><a>Item 2</a></li>
  </ul>
</div>
```

### 2. **Blade Icons** (v1.8.0)
- SVG icon library untuk Laravel Blade
- Ribuan icons yang dapat di-customize
- Dokumentasi: https://blade-ui-kit.com/blade-icons

**Contoh penggunaan:**
```blade
<x-heroicon-o-heart class="h-6 w-6" />
<x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
```

### 3. **Tailwind CSS** (v3.4.17)
- Utility-first CSS framework
- Sudah terintegrasi dengan DaisyUI
- Dokumentasi: https://tailwindcss.com

### 4. **Alpine.js** (v3.x)
- Lightweight JavaScript framework
- Interactivity tanpa build process yang kompleks
- Dokumentasi: https://alpinejs.dev

**Contoh penggunaan:**
```blade
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <div x-show="open" class="p-4">Content</div>
</div>
```

### 5. **SweetAlert2** (v11.14.5)
- Modal library yang indah dan responsif
- Confirmations, alerts, prompts
- Dokumentasi: https://sweetalert2.github.io

**Contoh penggunaan:**
```javascript
// Success alert
Swal.fire({
  title: 'Success!',
  text: 'Product added to cart',
  icon: 'success',
  timer: 2000
});

// Confirmation
Swal.fire({
  title: 'Delete?',
  text: 'Are you sure?',
  icon: 'warning',
  showCancelButton: true
}).then((result) => {
  if (result.isConfirmed) {
    // Delete action
  }
});
```

### 6. **Tailwind Forms Plugin** (v0.5.7)
- Default styling untuk form elements
- Input, select, checkbox, radio yang konsisten

### 7. **Tailwind Typography Plugin** (v0.5.13)
- Typography utilities untuk prose content
- Styling untuk heading, paragraf, list

## Project Configuration

### `tailwind.config.js`
Konfigurasi Tailwind dengan DaisyUI themes:
```javascript
daisyui: {
    themes: ['light', 'dark'],
}
```

### `vite.config.js`
Build configuration untuk development dan production

### Color Palette
- **Primary**: Pink (#ec4899)
- **Secondary**: Purple (#8b5cf6)
- **Accent**: Orange (#f97316)

## Build Commands

```bash
# Development
npm run dev

# Production build
npm run build

# Production + Watch
npm run build -- --watch
```

## Best Practices

### 1. Gunakan DaisyUI Components
```blade
<!-- ❌ Hindari -->
<div class="px-4 py-2 bg-blue-500 text-white rounded">Button</div>

<!-- ✅ Gunakan -->
<button class="btn btn-primary">Button</button>
```

### 2. Responsive Design
```blade
<!-- Mobile first approach -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
  <!-- Cards -->
</div>
```

### 3. Accessibility
```blade
<!-- Always use semantic HTML -->
<button aria-label="Close menu">
  <i class="fas fa-times"></i>
</button>
```

### 4. Alpine.js untuk interactivity ringan
```blade
<!-- Modal dengan Alpine -->
<div x-data="{ open: false }">
  <button @click="open = true">Open</button>
  <div x-show="open" @click.outside="open = false">
    <!-- Modal content -->
  </div>
</div>
```

### 5. SweetAlert2 untuk user feedback
```blade
<!-- Konfirmasi aksi destructive -->
<button onclick="confirmDelete(() => deleteForm.submit())">
  Delete
</button>
```

## File Locations

- **CSS**: `resources/css/app.css`
- **JavaScript**: `resources/js/app.js`
- **Layouts**: `resources/views/layouts/`
- **Build Output**: `public/build/`

## Troubleshooting

### 1. Styles tidak muncul
```bash
npm run build
php artisan view:clear
```

### 2. Icons tidak muncul
```bash
composer update blade-ui-kit/blade-icons
php artisan vendor:publish --tag=blade-icons
```

### 3. Alpine.js tidak bekerja
Pastikan script di-load: `@vite(['resources/css/app.css', 'resources/js/app.js'])`

## Resources

- [DaisyUI Components](https://daisyui.com/components/)
- [Tailwind CSS Utilities](https://tailwindcss.com/docs)
- [Alpine.js Directives](https://alpinejs.dev/directives)
- [SweetAlert2 Examples](https://sweetalert2.github.io/examples)
- [Font Awesome Icons](https://fontawesome.com/icons)

## Next Steps

1. Update semua view files untuk menggunakan DaisyUI components
2. Implement custom themes untuk branding
3. Optimize images dan assets
4. Add form validation dengan Alpine.js
5. Implement progressive enhancement

---

**Last Updated**: January 7, 2026
