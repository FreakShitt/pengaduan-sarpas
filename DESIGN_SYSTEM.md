# Clean Monochrome Design System dengan Subtle Accents

## Filosofi Desain
Sistem desain ini menggunakan **soft monochrome sebagai base** (medium gray, putih, abu-abu) dengan **subtle accent colors** untuk elemen interaktif dan status yang membutuhkan perhatian pengguna.

**Kenapa Soft Monochrome?**
- Lebih nyaman untuk mata dalam penggunaan jangka panjang
- Memberikan kesan profesional dan modern tanpa terlalu keras
- Kontras yang cukup tanpa terlalu tajam atau melelahkan
- Tetap readable dengan WCAG AA compliance
- **Rounded corners** untuk tampilan yang lebih friendly

---

## Color Palette

### Monochrome Base
```css
--color-black: #2D2D2D  /* Medium dark gray (bukan pure black, bukan terlalu dark) */
--color-white: #FFFFFF  /* Pure white */
--color-gray-50 sampai gray-900 (9 levels)
```

**Evolusi Warna:**
- ❌ **Awal**: `#000000` (pure black - terlalu tajam & keras)
- ⚠️ **Revisi 1**: `#1A1A1A` (soft dark gray - masih terlalu gelap)
- ✅ **Sekarang**: `#2D2D2D` (medium dark gray - balance sempurna)

### Border Radius
```css
--radius-sm: 4px   /* Badge, small elements */
--radius-md: 8px   /* Buttons, inputs */
--radius-lg: 12px  /* Cards, containers */
--radius-xl: 16px  /* Large sections */
```

**Keuntungan Rounded Corners:**
- ✅ Lebih soft & friendly
- ✅ Modern design trend
- ✅ Tidak terlalu lancip/tajam
- ✅ Lebih mudah dipandang mata

### Subtle Accents (Low Saturation)
```css
/* Red - untuk actions berbahaya, status ditolak */
--color-red-600: #B91C1C (primary red)
--color-red-700: #991B1B (hover state)

/* Green - untuk success, status selesai */
--color-green-600: #15803D (primary green)
--color-green-700: #14532D (hover state)

/* Blue - untuk informasi, status diajukan */
--color-blue-600: #2563EB (primary blue)

/* Yellow - untuk warning, status diproses */
--color-yellow-600: #CA8A04 (primary yellow)
```

---

## Component Usage

### 1. Buttons

#### Default Button (Monochrome)
```html
<button class="mono-btn">Default Action</button>
<button class="mono-btn-primary">Primary Action</button>
```

#### Colored Action Buttons
```html
<!-- Logout, Delete, Cancel -->
<button class="mono-btn-danger">Logout</button>
<button class="mono-btn-danger">Delete</button>

<!-- Submit, Approve, Confirm -->
<button class="mono-btn-success">Submit</button>
<button class="mono-btn-success">Approve</button>

<!-- Info Actions -->
<button class="mono-btn-info">View Details</button>

<!-- Warning Actions -->
<button class="mono-btn-warning">Pending Review</button>

<!-- Outline Danger (untuk secondary delete) -->
<button class="mono-btn-outline-danger">Remove</button>
```

**Kapan menggunakan warna:**
- ✅ **Danger (Red)**: Logout, Delete, Reject, Cancel permanent action
- ✅ **Success (Green)**: Submit form, Approve, Mark as complete
- ✅ **Info (Blue)**: View, Detail, Navigate
- ✅ **Warning (Yellow)**: Caution actions, temporary states
- ❌ **Jangan gunakan** untuk button biasa seperti "Back", "Edit", "Search" → gunakan mono-btn default

---

### 2. Status Badges

#### Status Pengaduan
```html
<span class="mono-badge mono-badge-diajukan">Diajukan</span>
<span class="mono-badge mono-badge-diproses">Diproses</span>
<span class="mono-badge mono-badge-selesai">Selesai</span>
<span class="mono-badge mono-badge-ditolak">Ditolak</span>
```

#### Status Item Request
```html
<span class="mono-badge mono-badge-pending">Pending</span>
<span class="mono-badge mono-badge-approved">Approved</span>
<span class="mono-badge mono-badge-rejected">Rejected</span>
```

**Warna Otomatis:**
- 🔵 **Blue** = Diajukan (baru masuk)
- 🟡 **Yellow** = Diproses (sedang ditangani)
- 🟢 **Green** = Selesai/Approved (berhasil)
- 🔴 **Red** = Ditolak/Rejected (gagal)
- ⚫ **Gray** = Pending (menunggu)

---

### 3. Alerts / Notifications

```html
<!-- Success Message -->
<div class="mono-alert mono-alert-success">
    Data berhasil disimpan!
</div>

<!-- Error Message -->
<div class="mono-alert mono-alert-error">
    Terjadi kesalahan. Silakan coba lagi.
</div>

<!-- Warning Message -->
<div class="mono-alert mono-alert-warning">
    Perhatian: Data akan dihapus secara permanen.
</div>

<!-- Info Message -->
<div class="mono-alert mono-alert-info">
    Informasi: Pengaduan Anda sedang ditinjau.
</div>
```

---

## Implementation Examples

### Example 1: Logout Button di Navbar
```html
<nav class="mono-nav">
    <div class="mono-logo">SARPAS</div>
    <div>
        <a href="/dashboard" class="mono-btn">Dashboard</a>
        <a href="/profile" class="mono-btn">Profile</a>
        <form method="POST" action="/logout" style="display:inline">
            @csrf
            <button type="submit" class="mono-btn mono-btn-danger">Logout</button>
        </form>
    </div>
</nav>
```

### Example 2: Form dengan Delete Button
```html
<form action="/lokasi/{{ $lokasi->id }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Form fields... -->
    
    <div style="display:flex; justify-content:space-between; margin-top:2rem">
        <button type="button" 
                onclick="if(confirm('Yakin hapus?')) document.getElementById('delete-form').submit()" 
                class="mono-btn mono-btn-danger">
            Delete Lokasi
        </button>
        
        <div style="display:flex; gap:1rem">
            <a href="/admin/lokasi" class="mono-btn">Cancel</a>
            <button type="submit" class="mono-btn-success">Update</button>
        </div>
    </div>
</form>

<form id="delete-form" action="/lokasi/{{ $lokasi->id }}" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>
```

### Example 3: Status Table dengan Color
```html
<table class="mono-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Laporan</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengaduans as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->detail_laporan }}</td>
            <td>
                @if($p->status === 'diajukan')
                    <span class="mono-badge mono-badge-diajukan">Diajukan</span>
                @elseif($p->status === 'diproses')
                    <span class="mono-badge mono-badge-diproses">Diproses</span>
                @elseif($p->status === 'selesai')
                    <span class="mono-badge mono-badge-selesai">Selesai</span>
                @else
                    <span class="mono-badge mono-badge-ditolak">Ditolak</span>
                @endif
            </td>
            <td>
                <a href="/pengaduan/{{ $p->id }}" class="mono-btn mono-btn-sm">Detail</a>
                @if($p->user_id === auth()->id())
                    <button class="mono-btn mono-btn-sm mono-btn-outline-danger">Delete</button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

---

## Design Principles

### ✅ DO:
- Gunakan warna **hanya untuk elemen yang butuh perhatian** (logout, delete, status, alerts)
- Pertahankan **mayoritas UI tetap monochrome** (70-80%)
- Gunakan warna **konsisten dengan artinya** (red=danger, green=success)
- Pilih **saturation rendah** agar tidak mencolok

### ❌ DON'T:
- Jangan gunakan warna pada **semua button**
- Jangan gunakan warna **dekoratif** atau gradien
- Jangan gunakan warna yang **terlalu bright/neon**
- Jangan gunakan **lebih dari 4 warna aksen** dalam satu halaman

---

## Accessibility Notes

- Semua kombinasi warna sudah memenuhi **WCAG AA contrast ratio** (min 4.5:1)
- Red buttons dapat dibedakan dengan **context** (text: "Delete", "Logout")
- Status badges menggunakan **text labels** selain warna
- Focus states tetap menggunakan **border hitam** untuk konsistensi

---

## Migration Guide

Jika ingin mengubah halaman yang sudah ada:

1. **Identifikasi actions berbahaya** → tambahkan `mono-btn-danger`
2. **Identifikasi status** → tambahkan badge warna sesuai state
3. **Identifikasi notifikasi** → tambahkan alert warna sesuai tipe
4. **Biarkan elemen lain** tetap monochrome

**Before:**
```html
<button class="mono-btn">Logout</button>
```

**After:**
```html
<button class="mono-btn mono-btn-danger">Logout</button>
```

---

## File Structure

```
resources/css/
├── app.css (import monochrome.css)
└── monochrome.css (design system lengkap)
```

**Build command:**
```bash
npm run build
```

**Output:**
- `public/build/assets/app-[hash].css` (compiled & minified)
