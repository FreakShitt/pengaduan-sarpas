# 🚀 SIMULASI LAUNCHING - SISTEM PENGADUAN SARPRAS

## ✅ Database Sudah Dibersihkan!

### Status Database:
- **Total Users**: 1 (Admin saja)
- **Total Pengaduan**: 0
- **Total Item Requests**: 0

### Akun Admin (Untuk Login Pertama Kali):
```
Username: Administrator
Email: (sudah terdaftar di database)
Password: (gunakan password yang sudah di-set sebelumnya)
```

---

## 📋 Simulasi User Journey

### 1️⃣ **TAHAP REGISTRASI - User Baru**

#### A. Registrasi Siswa/Guru (Pengadu)
1. Buka halaman registrasi
2. Pilih role: **Pengadu** (untuk siswa/guru)
3. Isi data:
   - Nama Pengguna
   - Email
   - Password
   - Konfirmasi Password
4. Submit → User pengadu terdaftar

#### B. Admin Menambahkan Petugas
1. Login sebagai **Admin**
2. Menu: **Petugas** → Tambah Petugas Baru
3. Isi data petugas:
   - Nama Pengguna
   - Email
   - Password
4. Submit → Petugas terdaftar

---

### 2️⃣ **TAHAP PENGGUNAAN SISTEM**

#### A. Pengadu Melaporkan Kerusakan
1. Login sebagai **Pengadu** (siswa/guru)
2. Dashboard → **Buat Laporan Baru**
3. Isi form:
   - **Lokasi**: Pilih dari dropdown (Lab Komputer, Ruang Kelas 7A, dll)
   - **Barang**: Pilih barang yang rusak
   - **Detail Laporan**: Jelaskan kerusakan
   - **Upload Gambar**: Foto barang rusak
4. Submit → Status: **Diajukan** (warna kuning)

#### B. Admin Mereview Laporan
1. Login sebagai **Admin**
2. Dashboard → Lihat laporan baru masuk
3. Klik laporan → Review detail
4. **Assign ke Petugas**:
   - Bisa tambahkan **Catatan Admin** (opsional)
   - Status masih **Diajukan** (menunggu petugas)

#### C. Petugas Menangani Laporan
1. Login sebagai **Petugas**
2. Dashboard → Lihat laporan yang masuk
3. Klik laporan → Proses:
   - Update status → **Diproses** (biru)
   - Tambahkan **Catatan Petugas**: "Sedang mengecek kerusakan"
4. Setelah selesai perbaikan:
   - Update status → **Selesai** (hijau)
   - Catatan: "Barang sudah diperbaiki"

**✨ FITUR BARU**: Petugas yang update status akan tercatat! Admin bisa lihat siapa yang menangani setiap laporan di kolom "Petugas" (Dashboard Admin)

#### D. Pengadu Melihat Progress
1. Login sebagai **Pengadu**
2. Dashboard → **Riwayat Laporan**
3. Lihat status:
   - 🟡 **Diajukan**: Menunggu ditangani
   - 🔵 **Diproses**: Petugas sedang bekerja
   - 🟢 **Selesai**: Perbaikan selesai
   - 🔴 **Ditolak**: Laporan ditolak (dengan catatan)

---

### 3️⃣ **FITUR BARANG TEMPORARY (Item Request)**

#### A. Pengadu Request Barang Baru
1. Login sebagai **Pengadu**
2. Form Laporan → **Barang tidak ada di list?**
3. Centang: **☑ Barang yang saya laporkan tidak ada di daftar**
4. Isi nama barang manual: Contoh: "Proyektor Epson EB-X41"
5. Submit → Item Request terkirim ke Admin

#### B. Admin Approve/Reject Item Request
1. Login sebagai **Admin**
2. Menu: **Item Requests**
3. Review request barang baru:
   - **Setuju** → Barang masuk ke master data
   - **Tolak** → Barang ditolak (bisa tambah catatan)
4. Pengadu akan dapat notifikasi

---

### 4️⃣ **MONITORING ADMIN**

#### Dashboard Admin Features:
- **Total Pengaduan**: Statistik semua laporan
- **Filter Laporan**:
  - Search by nama/detail
  - Filter by status
  - Filter by lokasi
- **Recent Reports Table**:
  - Kolom **Petugas**: Nama petugas yang menangani
  - Sortable & Filterable

#### Halaman Laporan Admin:
- **Export Data**:
  - 📄 Export to PDF (tombol merah)
  - 📝 Export to DOC (tombol biru)
- **Filter Advanced**:
  - Date range
  - Status
  - Lokasi

#### Halaman Barang:
- **Filter by Lokasi**: Lihat barang per ruangan
- **Edit/Delete**: Kelola master data barang
- **Stats**: Total barang per lokasi

#### Halaman Petugas:
- **Performance Stats**:
  - Total Laporan Selesai
  - Total Laporan Sedang Diproses
- **Add/Edit/Delete** Petugas

---

## 🎨 DESIGN SYSTEM

### Monochrome Modern Theme:
- **Header**: Black background, white text
- **Stats Cards**: White background, black border, hover effect
- **Badges**:
  - Default: White bg, black border
  - Filled: Black bg, white text
  - Outlined: Thin black border
- **Tables**: Minimalist, no emojis, consistent monochrome
- **Buttons**: Black/white theme, no custom colors

---

## 🔐 SECURITY & ROLES

### Role Permissions:
| Feature | Admin | Petugas | Pengadu |
|---------|-------|---------|---------|
| Lihat Semua Laporan | ✅ | ✅ | ❌ (hanya miliknya) |
| Update Status | ✅ | ✅ | ❌ |
| Kelola Users | ✅ | ❌ | ❌ |
| Kelola Barang | ✅ | ❌ | ❌ |
| Kelola Lokasi | ✅ | ❌ | ❌ |
| Approve Item Request | ✅ | ❌ | ❌ |
| Buat Laporan | ❌ | ❌ | ✅ |
| Export Data | ✅ | ❌ | ❌ |

---

## 📊 TEST SCENARIOS

### Scenario 1: Full Cycle Report
1. Pengadu buat laporan → Status: Diajukan
2. Admin review → Assign catatan (opsional)
3. Petugas update → Status: Diproses + Catatan
4. Petugas selesai → Status: Selesai + Catatan
5. Pengadu lihat riwayat → Laporan selesai ✓

### Scenario 2: Item Request
1. Pengadu lapor barang baru (not in list)
2. Admin terima request → Menu Item Requests
3. Admin approve → Barang masuk master data
4. Pengadu bisa pilih barang baru di form berikutnya

### Scenario 3: Multiple Reports
1. Buat 5-10 laporan dari berbagai lokasi
2. Test filter di dashboard admin:
   - Filter by status
   - Filter by lokasi
   - Search by keyword
3. Test petugas column → Nama petugas muncul setelah update

### Scenario 4: Export Data
1. Buat beberapa laporan dengan status berbeda
2. Admin → Halaman Laporan
3. Gunakan filter (date range, status, lokasi)
4. Export to PDF → Download file
5. Export to DOC → Download file

---

## ✨ FITUR TERBARU (Just Added!)

### 1. Petugas Tracking
- Setiap kali petugas update status laporan
- Sistem otomatis menyimpan ID petugas tersebut
- Admin bisa lihat di kolom "Petugas" (Dashboard)
- Field database: `petugas_id` (baru ditambahkan)

### 2. Consistent Monochrome Design
- **SEMUA** halaman admin: Monochrome theme
- **NO** emojis di tabel/badges
- **NO** custom colors (pure black/white/gray)
- Standalone pages (no layout inheritance)

### 3. Enhanced Filters
- Dashboard: Search + Status + Lokasi (text input)
- Barang: Lokasi dropdown dengan "Ruang Kelas (Semua)"
- Laporan: Date range + Status + Lokasi

---

## 🚀 READY TO LAUNCH!

Database bersih, hanya ada 1 admin.
Siap untuk simulasi user journey dari awal!

**Next Steps:**
1. ✅ Start server: `php artisan serve`
2. ✅ Buka browser: `http://127.0.0.1:8000`
3. ✅ Login as Admin
4. ✅ Mulai simulasi registrasi user baru
5. ✅ Test full workflow!

---

**Catatan**: Migration cleanup sudah dijalankan. Data lama (pengaduan, item requests, petugas, siswa/guru) sudah dihapus. Database fresh dan siap untuk demo launching! 🎉
