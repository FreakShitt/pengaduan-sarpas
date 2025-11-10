# ✅ Laravel API untuk Flutter - Setup Complete!

## 🎉 Yang Sudah Dikonfigurasi:

### 1. **Laravel Sanctum** ✅
- Package installed dan configured
- Token authentication ready
- CORS policy configured

### 2. **API Controllers** ✅
- **AuthController**: Register, Login, Logout, Me
- **ProfileController**: Show Profile, Update Profile (termasuk change password)
- **PengaduanController**: Homepage, Create, History, Detail, Master Data (Lokasi & Barang)

### 3. **API Routes** ✅
File: `routes/api.php`
- Semua endpoint tersedia di prefix `/api/v1`
- Protected routes menggunakan `auth:sanctum` middleware
- 12 endpoints siap digunakan

### 4. **User Model** ✅
- HasApiTokens trait added
- Ready untuk token management

### 5. **Documentation** ✅
- **API_DOCUMENTATION.md**: Complete API docs dengan request/response examples
- **FLUTTER_INTEGRATION_GUIDE.md**: Panduan lengkap integrasi Flutter
- **Postman_Collection.json**: Ready to import untuk testing

---

## 📋 API Endpoints Summary

### Public Endpoints (Tidak perlu token):
```
POST /api/v1/register          - Register user baru (siswa)
POST /api/v1/login             - Login user
```

### Protected Endpoints (Perlu Bearer Token):
```
# Authentication
POST /api/v1/logout            - Logout user
GET  /api/v1/me                - Get current user info

# Profile
GET  /api/v1/profile           - Get profile detail
PUT  /api/v1/profile           - Update profile (nama, username, password)

# Homepage
GET  /api/v1/homepage          - Get stats + latest pengaduan

# Master Data
GET  /api/v1/lokasi            - Get list lokasi
GET  /api/v1/barang            - Get list barang by lokasi

# Pengaduan
POST /api/v1/pengaduan         - Create pengaduan (support image upload)
GET  /api/v1/pengaduan/history - Get riwayat pengaduan
GET  /api/v1/pengaduan/{id}    - Get detail pengaduan
```

---

## 🧪 Testing API

### Cara 1: Menggunakan Postman
1. Import file `Postman_Collection.json`
2. Set environment variable `base_url` = `http://localhost/pengaduan-sarpas/public/api/v1`
3. Test endpoint Register → Login (token akan auto-save)
4. Test endpoint lainnya yang memerlukan authentication

### Cara 2: Menggunakan cURL
```bash
# Register
curl -X POST http://localhost/pengaduan-sarpas/public/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "nama_pengguna": "Test User",
    "username": "testuser",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost/pengaduan-sarpas/public/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "testuser",
    "password": "password123"
  }'

# Get Homepage (ganti YOUR_TOKEN dengan token dari login)
curl -X GET http://localhost/pengaduan-sarpas/public/api/v1/homepage \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📱 Flutter Integration

### Quick Start:
1. Baca **FLUTTER_INTEGRATION_GUIDE.md** untuk panduan lengkap
2. Copy models, services, dan example screens ke project Flutter
3. Update `base_url` di `api_config.dart` sesuai dengan server Anda
4. Install dependencies yang dibutuhkan
5. Test koneksi dengan endpoint Login

### Minimal Dependencies:
```yaml
dependencies:
  http: ^1.1.0
  flutter_secure_storage: ^9.0.0
  image_picker: ^1.0.4
```

---

## 🔧 Fitur API yang Tersedia

### ✅ Fitur Selesai:
1. **Register & Login** - Registrasi dan autentikasi user (role: siswa/guru)
2. **Profile Management** - View dan update profile termasuk change password
3. **Homepage Data** - Statistik pengaduan + 5 pengaduan terbaru
4. **Master Data** - List lokasi dan barang
5. **Create Pengaduan** - Support normal item & temporary item dengan upload foto
6. **History Pengaduan** - Riwayat dengan filter status
7. **Detail Pengaduan** - Detail lengkap pengaduan

### 🚀 Response Format:
Semua response menggunakan format konsisten:
```json
{
  "success": true/false,
  "message": "...",
  "data": {...},
  "errors": {...}  // hanya jika ada error validasi
}
```

---

## 📁 File Structure

```
pengaduan-sarpas/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php          ✅ Complete
│   │   ├── ProfileController.php       ✅ Complete
│   │   └── PengaduanController.php     ✅ Complete
│   └── Models/
│       └── User.php                     ✅ Updated (HasApiTokens)
├── routes/
│   └── api.php                          ✅ Complete
├── config/
│   ├── cors.php                         ✅ Complete
│   └── sanctum.php                      ✅ Complete
├── API_DOCUMENTATION.md                 ✅ Complete
├── FLUTTER_INTEGRATION_GUIDE.md         ✅ Complete
└── Postman_Collection.json              ✅ Complete
```

---

## 🎯 Next Steps untuk Flutter Developer:

1. **Setup Flutter Project**
   - Create new Flutter project
   - Add dependencies
   - Setup project structure

2. **Implement Models**
   - User, Pengaduan, Lokasi, Barang

3. **Implement Services**
   - StorageService (secure storage untuk token)
   - ApiService (HTTP client wrapper)
   - AuthService, PengaduanService

4. **Build UI Screens**
   - Login & Register
   - Homepage dengan stats
   - Create Pengaduan (dengan image picker)
   - History & Detail

5. **Test & Debug**
   - Test semua endpoint
   - Handle error cases
   - Implement loading states

---

## 🔐 Security Notes:

- ✅ Passwords di-hash dengan bcrypt
- ✅ API menggunakan Bearer Token (Sanctum)
- ✅ Token disimpan di secure storage (Flutter)
- ✅ CORS configured untuk mobile access
- ✅ Validation di semua input
- ✅ Role-based access (hanya siswa/guru untuk mobile)

---

## 📞 Support:

Jika ada pertanyaan atau masalah:
1. Check **API_DOCUMENTATION.md** untuk detail endpoint
2. Check **FLUTTER_INTEGRATION_GUIDE.md** untuk Flutter integration
3. Test dengan Postman untuk isolasi masalah
4. Check Laravel logs: `storage/logs/laravel.log`

---

**🎉 API Laravel siap untuk diintegrasikan dengan Flutter! 🚀**

Happy Coding! 💻
