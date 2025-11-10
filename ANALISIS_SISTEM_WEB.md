# ANALISIS SISTEM PENGADUAN SARANA PRASARANA (WEB)

## 1. PENDAHULUAN

Sistem Pengaduan Sarana Prasarana berbasis web adalah aplikasi manajemen pengaduan fasilitas sekolah yang dibangun dengan Laravel Framework. Sistem ini memiliki 4 level user (Admin, Petugas, Guru, Siswa) dengan fitur yang berbeda sesuai role masing-masing.

## 2. TEKNOLOGI & TOOLS

### 2.1 Backend Framework
- **Laravel 12.0** - PHP Framework (MVC Pattern)
- **PHP 8.2** - Server-side programming language
- **Composer** - Dependency management

### 2.2 Frontend
- **Blade Template Engine** - Laravel templating
- **Bootstrap 5** - CSS Framework
- **Vite** - Modern frontend build tool
- **JavaScript/jQuery** - Client-side scripting

### 2.3 Database
- **MySQL** - Relational Database Management System
- **Laravel Eloquent ORM** - Object-Relational Mapping

### 2.4 Authentication & Security
- **Laravel Sanctum** - API token authentication (untuk mobile app)
- **Laravel Session** - Web authentication
- **Bcrypt** - Password hashing
- **CSRF Protection** - Cross-Site Request Forgery protection
- **Middleware** - Route protection & authorization

### 2.5 Development Environment
- **Laragon** - Local development server
- **Composer** - Package manager
- **NPM** - Node package manager
- **Git** - Version control

## 3. ARSITEKTUR APLIKASI

### 3.1 MVC Pattern
```
┌─────────────────────────────────────────┐
│             WEB BROWSER                 │
│      (User Interface - View)            │
└────────────────┬────────────────────────┘
                 │ HTTP Request
                 ▼
┌─────────────────────────────────────────┐
│         ROUTES (web.php)                │
│    (URL Mapping & Middleware)           │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│         CONTROLLER                      │
│  - AuthController                       │
│  - AdminController                      │
│  - PetugasController                    │
│  - PengaduanController                  │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│         MODEL (Eloquent ORM)            │
│  - User, Pengaduan, Lokasi,             │
│  - Barang, ItemRequest                  │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│         MySQL DATABASE                  │
└─────────────────────────────────────────┘
```

### 3.2 Folder Structure
```
pengaduan-sarpas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── PengaduanController.php
│   │   │   ├── PetugasController.php
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── PengaduanController.php
│   │   │       └── ProfileController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Pengaduan.php
│       ├── Lokasi.php
│       ├── Barang.php
│       └── ItemRequest.php
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_pengaduans_table.php
│   │   ├── create_lokasi_table.php
│   │   ├── create_barang_table.php
│   │   ├── create_lokasi_barang_table.php
│   │   └── create_item_requests_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       └── LokasiBarangSeeder.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── admin.blade.php
│       │   └── petugas.blade.php
│       ├── Auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── user/
│       │   └── dashboard.blade.php
│       ├── pengaduan/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       ├── petugas/
│       │   ├── dashboard.blade.php
│       │   └── show.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── petugas.blade.php
│           ├── users.blade.php
│           ├── lokasi.blade.php
│           ├── barang.blade.php
│           ├── item-requests.blade.php
│           └── laporan.blade.php
│
├── routes/
│   ├── web.php        # Web routes
│   └── api.php        # API routes (untuk mobile)
│
├── public/
│   ├── uploads/       # Foto pengaduan
│   └── index.php      # Entry point
│
└── config/
    ├── app.php
    ├── database.php
    ├── auth.php
    └── cors.php
```

## 4. ROLE & PERMISSIONS

### 4.1 User Roles
| Role | Akses | Fitur Utama |
|------|-------|-------------|
| **Admin** | Full Access | CRUD User, Petugas, Lokasi, Barang, Item Request, Laporan |
| **Petugas** | Medium Access | View & Update Status Pengaduan |
| **Guru** | User Access | Create & View Pengaduan |
| **Siswa** | User Access | Create & View Pengaduan |

### 4.2 Route Protection
```php
// Public routes
Route::get('/login')
Route::post('/login')
Route::get('/register')
Route::post('/register')

// Siswa & Guru routes
Route::middleware(['auth', 'role:siswa,guru'])->group(function () {
    Route::get('/dashboard')
    Route::get('/pengaduan')
    Route::post('/pengaduan')
})

// Petugas routes
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/dashboard')
    Route::put('/laporan/{id}/update-status')
})

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard')
    Route::resource('petugas')
    Route::resource('users')
    Route::resource('lokasi')
    Route::resource('barang')
    Route::get('/laporan')
})
```

## 5. FITUR PER ROLE

### 5.1 ADMIN
**Dashboard**
- Total statistik: user, petugas, pengaduan, lokasi, barang
- Grafik pengaduan per status

**Manajemen Petugas**
- Tambah petugas baru
- Lihat daftar petugas
- Edit/Hapus petugas

**Manajemen User (Siswa & Guru)**
- Tambah user baru
- Lihat daftar user
- Edit/Hapus user

**Manajemen Lokasi**
- CRUD lokasi (Ruang Kelas, Lab, dll)
- Set status aktif/non-aktif

**Manajemen Barang**
- CRUD barang
- Relasi barang dengan lokasi (many-to-many)

**Item Request**
- Approve/Reject request barang baru dari user
- Auto-add ke master barang jika approved

**Laporan**
- View semua pengaduan
- Filter berdasarkan status, tanggal
- Export ke PDF/DOC

### 5.2 PETUGAS
**Dashboard**
- Statistik pengaduan assigned
- List pengaduan berdasarkan status

**Update Status Pengaduan**
- Ubah status: diajukan → diproses → selesai/ditolak
- Tambah catatan petugas
- View detail lengkap pengaduan

### 5.3 GURU & SISWA
**Dashboard**
- Statistik pengaduan pribadi
- Pengaduan terbaru (5 items)
- Quick action: Buat Pengaduan

**Buat Pengaduan**
- Pilih lokasi (dropdown)
- Pilih barang sesuai lokasi (AJAX dropdown)
- Centang "Item Tidak Ada" → Request barang baru
- Isi detail laporan
- Upload foto bukti (max 2MB)

**Riwayat Pengaduan**
- List semua pengaduan user
- Filter berdasarkan status
- View detail + foto

## 6. DATABASE SCHEMA

### 6.1 Tabel: users
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_pengguna VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'petugas', 'guru', 'siswa') NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 6.2 Tabel: pengaduans
```sql
CREATE TABLE pengaduans (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    lokasi VARCHAR(255) NOT NULL,
    barang VARCHAR(255) NOT NULL,
    is_temporary_item TINYINT(1) DEFAULT 0,
    detail_laporan TEXT NOT NULL,
    gambar VARCHAR(255) NULL,
    status ENUM('diajukan', 'diproses', 'selesai', 'ditolak') DEFAULT 'diajukan',
    catatan_petugas TEXT NULL,
    catatan_admin TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 6.3 Tabel: lokasi
```sql
CREATE TABLE lokasi (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_lokasi VARCHAR(255) UNIQUE NOT NULL,
    aktif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 6.4 Tabel: barang
```sql
CREATE TABLE barang (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_barang VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 6.5 Tabel: lokasi_barang (Pivot Table)
```sql
CREATE TABLE lokasi_barang (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    lokasi_id BIGINT NOT NULL,
    barang_id BIGINT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (lokasi_id) REFERENCES lokasi(id) ON DELETE CASCADE,
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE
);
```

### 6.6 Tabel: item_requests
```sql
CREATE TABLE item_requests (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nama_lokasi VARCHAR(255) NOT NULL,
    nama_barang VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    requested_by INT NOT NULL,
    status ENUM('diajukan', 'disetujui', 'ditolak') DEFAULT 'diajukan',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (requested_by) REFERENCES users(id)
);
```

### 6.7 Relasi Database
```
users (1) ──────> (N) pengaduans
users (1) ──────> (N) item_requests

lokasi (N) <────> (N) barang [via lokasi_barang]
```

## 7. ALUR SISTEM

### 7.1 Alur Login
```
1. User buka /login
2. Input username & password
3. AuthController::login
4. Validasi credentials
5. Check user role
6. Redirect berdasarkan role:
   - Admin → /admin/dashboard
   - Petugas → /petugas/dashboard
   - Siswa/Guru → /dashboard
```

### 7.2 Alur Buat Pengaduan (Siswa/Guru)
```
1. User klik "Buat Pengaduan"
2. GET /pengaduan/create
3. Load form dengan:
   - Dropdown lokasi (dari DB)
   - Dropdown barang (kosong, tunggu lokasi dipilih)
4. User pilih lokasi
5. AJAX request GET /pengaduan/get-barang?lokasi={X}
6. Populate dropdown barang sesuai lokasi
7. User pilih barang ATAU centang "Item tidak ada"
8. User isi detail laporan
9. User upload foto (optional)
10. Submit form POST /pengaduan
11. PengaduanController::store
    - Validasi input
    - Upload & save foto
    - Insert ke table pengaduans (status: diajukan)
    - Jika item temporary → Insert ke item_requests
12. Redirect ke /pengaduan dengan flash message
```

### 7.3 Alur Update Status (Petugas)
```
1. Petugas login → /petugas/dashboard
2. Lihat list pengaduan
3. Klik detail pengaduan → /petugas/laporan/{id}
4. View detail lengkap (lokasi, barang, foto, dll)
5. Pilih status baru: diproses/selesai/ditolak
6. Isi catatan petugas
7. Submit PUT /petugas/laporan/{id}/update-status
8. PetugasController::updateStatus
    - Validasi status
    - Update database
9. Redirect kembali dengan flash message
```

### 7.4 Alur Approve Item Request (Admin)
```
1. Admin login → /admin/dashboard
2. Klik menu "Item Requests"
3. Lihat list request dari siswa/guru
4. Klik "Approve" pada item tertentu
5. POST /admin/item-requests/{id}/approve
6. AdminController::approveItemRequest
    - Update status item_request → 'disetujui'
    - Insert barang baru ke table barang
    - Insert relasi ke lokasi_barang
7. Redirect dengan flash message "Item disetujui"
```

## 8. FITUR TEKNOLOGI

### 8.1 AJAX & Dynamic Dropdown
```javascript
// Get barang based on lokasi selection
$('#lokasi').on('change', function() {
    let lokasi = $(this).val();
    $.ajax({
        url: '/pengaduan/get-barang',
        data: { lokasi: lokasi },
        success: function(data) {
            $('#barang').html(data.options);
        }
    });
});
```

### 8.2 File Upload Handling
```php
// Upload foto pengaduan
if ($request->hasFile('gambar')) {
    $file = $request->file('gambar');
    $filename = time() . '_' . uniqid() . '.' . $file->extension();
    $file->move(public_path('uploads'), $filename);
    $data['gambar'] = $filename;
}
```

### 8.3 Eloquent Relationships
```php
// Model User
public function pengaduans() {
    return $this->hasMany(Pengaduan::class);
}

// Model Lokasi
public function barangs() {
    return $this->belongsToMany(Barang::class, 'lokasi_barang');
}

// Model Barang
public function lokasis() {
    return $this->belongsToMany(Lokasi::class, 'lokasi_barang');
}
```

### 8.4 Middleware Authorization
```php
// AdminMiddleware.php
public function handle($request, Closure $next) {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }
    return redirect('/login')->with('error', 'Unauthorized');
}
```

### 8.5 Validation
```php
// Validasi input pengaduan
$request->validate([
    'lokasi' => 'required|string',
    'barang' => 'required|string',
    'detail_laporan' => 'required|string|min:10',
    'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
]);
```

## 9. KEAMANAN

### 9.1 Authentication
- Session-based authentication
- Password hashing dengan Bcrypt
- Remember me token
- Logout session destroy

### 9.2 Authorization
- Role-based access control (RBAC)
- Middleware protection pada setiap route
- CSRF token pada semua form

### 9.3 Input Validation
- Server-side validation (Laravel Validator)
- Client-side validation (Bootstrap validation)
- XSS protection (Blade auto-escape)
- SQL Injection protection (Eloquent ORM)

### 9.4 File Upload Security
- File type validation (image only)
- File size limit (max 2MB)
- Unique filename generation
- Store outside web root (optional)

## 10. TESTING

### 10.1 Manual Testing
- ✅ Login dengan berbagai role
- ✅ CRUD operations untuk admin
- ✅ Buat pengaduan dengan/tanpa foto
- ✅ Update status oleh petugas
- ✅ Approve/Reject item request
- ✅ Export laporan

### 10.2 Browser Compatibility
- Chrome/Edge (Chromium)
- Firefox
- Safari (desktop & mobile)

## 11. DEPLOYMENT

### 11.1 Server Requirements
- PHP >= 8.2
- MySQL >= 5.7 / MariaDB >= 10.3
- Composer
- Apache/Nginx web server
- SSL Certificate (production)

### 11.2 Environment Configuration
```env
APP_NAME="Pengaduan Sarpas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pengaduan_sarpas
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=yourdomain.com
SESSION_DOMAIN=.yourdomain.com
```

### 11.3 Deployment Steps
```bash
# 1. Clone repository
git clone https://github.com/yourrepo/pengaduan-sarpas.git

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Database migration & seeding
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=LokasiBarangSeeder

# 5. Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache public/uploads

# 6. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 12. KELEBIHAN SISTEM

1. **Multi-Role Management**: 4 level user dengan akses berbeda
2. **Dynamic Form**: Dropdown barang berubah sesuai lokasi
3. **Real-time Processing**: Status update langsung terlihat
4. **Item Request**: User bisa request barang baru yang belum terdaftar
5. **Photo Evidence**: Upload foto untuk validasi laporan
6. **Responsive Design**: Bootstrap 5 responsive layout
7. **Export Feature**: Laporan bisa di-export PDF/DOC
8. **RESTful API**: Support untuk mobile app (Flutter)
9. **Secure**: CSRF, XSS protection, password hashing
10. **Scalable**: MVC pattern, Eloquent ORM

## 13. FUTURE IMPROVEMENT

1. **Notification System**: Email/SMS notif saat status berubah
2. **Real-time Updates**: WebSocket untuk live notification
3. **Dashboard Analytics**: Grafik & statistik lebih detail
4. **Backup System**: Auto backup database
5. **API Documentation**: Swagger/OpenAPI
6. **Unit Testing**: PHPUnit test coverage
7. **Logging**: Activity log untuk audit trail
8. **Multi-language**: i18n support
9. **Dark Mode**: Theme switching
10. **Mobile-first**: Progressive Web App (PWA)

---

**Technology Stack Summary:**
- Framework: Laravel 12.0
- Language: PHP 8.2
- Database: MySQL
- Frontend: Blade + Bootstrap 5 + Vite
- Authentication: Laravel Session + Sanctum
- ORM: Eloquent
- Middleware: Role-based authorization

**Total Routes**: 40+ web routes + 12 API routes
**Total Controllers**: 5 controllers (4 web + API)
**Total Models**: 5 models
**Total Views**: 20+ blade templates
**Total Migrations**: 6 database tables
