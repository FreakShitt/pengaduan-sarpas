# 📱 API Documentation - Pengaduan Sarpras Mobile

Base URL: `http://localhost/pengaduan-sarpas/public/api/v1`

## 🔐 Authentication

Semua endpoint yang memerlukan authentication menggunakan **Bearer Token** yang didapat dari Login/Register.

Header format:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

## 📋 Endpoints

### 1. **Register** (Public)
Registrasi user baru (role: siswa)

**Endpoint:** `POST /register`

**Request Body:**
```json
{
  "nama_pengguna": "John Doe",
  "username": "john123",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response Success (201):**
```json
{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "user": {
      "id": 1,
      "nama_pengguna": "John Doe",
      "username": "john123",
      "role": "siswa"
    },
    "token": "1|abcdef123456..."
  }
}
```

**Response Error (422):**
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "username": ["Username sudah digunakan"]
  }
}
```

---

### 2. **Login** (Public)
Login user yang sudah terdaftar

**Endpoint:** `POST /login`

**Request Body:**
```json
{
  "username": "john123",
  "password": "password123"
}
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 1,
      "nama_pengguna": "John Doe",
      "username": "john123",
      "role": "siswa"
    },
    "token": "2|xyz789..."
  }
}
```

**Response Error (401):**
```json
{
  "success": false,
  "message": "Username atau password salah"
}
```

---

### 3. **Logout** (Protected)
Logout dan hapus token

**Endpoint:** `POST /logout`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

---

### 4. **Get Current User** (Protected)
Mendapatkan info user yang sedang login

**Endpoint:** `GET /me`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response Success (200):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "nama_pengguna": "John Doe",
      "username": "john123",
      "role": "siswa"
    }
  }
}
```

---

### 5. **Get Profile** (Protected)
Mendapatkan detail profile user

**Endpoint:** `GET /profile`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response Success (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama_pengguna": "John Doe",
    "username": "john123",
    "role": "siswa",
    "created_at": "2025-11-05T10:30:00.000000Z",
    "updated_at": "2025-11-05T10:30:00.000000Z"
  }
}
```

---

### 6. **Update Profile** (Protected)
Update profile user (nama, username, atau password)

**Endpoint:** `PUT /profile`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
```

**Request Body (Update Nama & Username):**
```json
{
  "nama_pengguna": "John Doe Updated",
  "username": "john_updated"
}
```

**Request Body (Update Password):**
```json
{
  "current_password": "password123",
  "new_password": "newpassword456",
  "new_password_confirmation": "newpassword456"
}
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Profile berhasil diupdate",
  "data": {
    "id": 1,
    "nama_pengguna": "John Doe Updated",
    "username": "john_updated",
    "role": "siswa"
  }
}
```

---

### 7. **Homepage** (Protected)
Mendapatkan data untuk homepage (statistik + latest pengaduan)

**Endpoint:** `GET /homepage`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response Success (200):**
```json
{
  "success": true,
  "data": {
    "stats": {
      "total_pengaduan": 10,
      "diajukan": 2,
      "diproses": 3,
      "selesai": 4,
      "ditolak": 1
    },
    "latest_pengaduan": [
      {
        "id": 5,
        "lokasi": "Kelas 10A",
        "barang": "Proyektor",
        "keluhan": "Proyektor tidak menyala",
        "status": "diajukan",
        "tanggal": "05 Nov 2025 14:30",
        "foto_url": "http://localhost/pengaduan-sarpas/public/uploads/1234567890.jpg"
      }
    ]
  }
}
```

---

### 8. **Get Lokasi** (Protected)
Mendapatkan list lokasi untuk dropdown

**Endpoint:** `GET /lokasi`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response Success (200):**
```json
{
  "success": true,
  "data": [
    {
      "id_lokasi": 1,
      "nama_lokasi": "Kelas 10A"
    },
    {
      "id_lokasi": 2,
      "nama_lokasi": "Lab Komputer"
    }
  ]
}
```

---

### 9. **Get Barang** (Protected)
Mendapatkan list barang berdasarkan lokasi

**Endpoint:** `GET /barang?id_lokasi=1`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Query Params:**
- `id_lokasi` (required): ID lokasi

**Response Success (200):**
```json
{
  "success": true,
  "data": [
    {
      "id_barang": 1,
      "nama_barang": "Proyektor",
      "kondisi": "baik"
    },
    {
      "id_barang": 2,
      "nama_barang": "AC",
      "kondisi": "rusak"
    }
  ]
}
```

---

### 10. **Create Pengaduan** (Protected)
Membuat pengaduan baru

**Endpoint:** `POST /pengaduan`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
id_lokasi: 1
id_barang: 2
keluhan: "AC tidak dingin"
foto: [file gambar] (optional)
```

**Request Body (Temporary Item):**
```
id_lokasi: 1
is_temporary_item: true
temporary_item_name: "Whiteboard Baru"
temporary_item_description: "Whiteboard untuk kelas"
keluhan: "Butuh whiteboard baru"
foto: [file gambar] (optional)
```

**Response Success (201):**
```json
{
  "success": true,
  "message": "Pengaduan berhasil dibuat",
  "data": {
    "id": 10,
    "status": "diajukan"
  }
}
```

---

### 11. **Get Pengaduan History** (Protected)
Mendapatkan riwayat pengaduan user

**Endpoint:** `GET /pengaduan/history?status=all`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Query Params:**
- `status` (optional): `all`, `diajukan`, `diproses`, `selesai`, `ditolak`

**Response Success (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 10,
      "lokasi": "Kelas 10A",
      "barang": "AC",
      "keluhan": "AC tidak dingin",
      "status": "diajukan",
      "is_temporary_item": false,
      "catatan_petugas": null,
      "tanggal": "05 Nov 2025 14:30",
      "foto_url": "http://localhost/pengaduan-sarpas/public/uploads/1234567890.jpg"
    }
  ]
}
```

---

### 12. **Get Pengaduan Detail** (Protected)
Mendapatkan detail pengaduan

**Endpoint:** `GET /pengaduan/{id}`

**Headers:**
```
Authorization: Bearer YOUR_TOKEN
```

**Response Success (200):**
```json
{
  "success": true,
  "data": {
    "id": 10,
    "lokasi": "Kelas 10A",
    "barang": "AC",
    "keluhan": "AC tidak dingin",
    "status": "diproses",
    "is_temporary_item": false,
    "temporary_item_description": null,
    "catatan_petugas": "Sedang ditangani teknisi",
    "tanggal": "05 Nov 2025 14:30",
    "foto_url": "http://localhost/pengaduan-sarpas/public/uploads/1234567890.jpg"
  }
}
```

**Response Error (404):**
```json
{
  "success": false,
  "message": "Pengaduan tidak ditemukan"
}
```

---

## 📊 Status Codes

- `200` - OK (Success)
- `201` - Created (Resource created successfully)
- `401` - Unauthorized (Invalid credentials or token)
- `403` - Forbidden (No access)
- `404` - Not Found (Resource not found)
- `422` - Unprocessable Entity (Validation error)
- `500` - Internal Server Error

---

## 🔒 Error Handling

Semua error response mengikuti format:
```json
{
  "success": false,
  "message": "Error message here",
  "errors": {
    "field_name": ["Error detail"]
  }
}
```

---

## 📝 Notes untuk Flutter Developer

1. **Base URL**: Sesuaikan dengan server Anda
2. **Token Storage**: Simpan token di secure storage (flutter_secure_storage)
3. **Image Upload**: Gunakan multipart/form-data dengan package http atau dio
4. **Error Handling**: Cek `success` field untuk validasi response
5. **Pagination**: Saat ini belum ada pagination, akan ditambahkan jika diperlukan

---

## 🧪 Testing dengan Postman

1. Import collection dari file ini
2. Set environment variable `base_url` = `http://localhost/pengaduan-sarpas/public/api/v1`
3. Set environment variable `token` setelah login
4. Test semua endpoint secara berurutan

---

## 📦 Flutter Packages Recommended

```yaml
dependencies:
  http: ^1.1.0  # atau dio: ^5.3.3
  flutter_secure_storage: ^9.0.0
  image_picker: ^1.0.4
  cached_network_image: ^3.3.0
```
