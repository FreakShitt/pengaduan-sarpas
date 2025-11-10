# 🧪 Panduan Testing API dengan Postman

## 📋 PERSIAPAN SEBELUM TESTING

### 1. **Install Postman**
Download dari: https://www.postman.com/downloads/

### 2. **Pastikan Laravel Server Running**
Buka Command Prompt/PowerShell:
```bash
cd C:\laragon\www\pengaduan-sarpas
php artisan serve
```
Atau pastikan Laragon Apache & MySQL sudah running.

### 3. **Import Collection ke Postman**

**Langkah:**
1. Buka Postman
2. Klik tombol **Import** (pojok kiri atas)
3. Klik **Upload Files**
4. Pilih file: `C:\laragon\www\pengaduan-sarpas\Postman_Collection.json`
5. Klik **Import**
6. Collection "**Pengaduan Sarpras API**" akan muncul di sidebar kiri

---

## 🎯 URUTAN TESTING (WAJIB IKUTI!)

### ✅ **TEST 1: Register User Baru**

**Endpoint:** `POST {{base_url}}/register`

**Langkah:**
1. Expand folder **Auth** di sidebar
2. Klik **Register**
3. Pastikan di tab **Body** → pilih **raw** dan **JSON**
4. Data sudah terisi:
   ```json
   {
     "nama_pengguna": "Test Siswa",
     "username": "testsiswa",
     "password": "password123",
     "password_confirmation": "password123"
   }
   ```
5. **Klik tombol SEND** (biru, kanan atas)

**Response yang diharapkan (Status: 201 Created):**
```json
{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "user": {
      "id": 1,
      "nama_pengguna": "Test Siswa",
      "username": "testsiswa",
      "role": "siswa"
    },
    "token": "1|abcdefghijklmnop..."
  }
}
```

**⚠️ Jika muncul error "Username sudah digunakan":**
- Ganti `username` menjadi `testsiswa2`, `testsiswa3`, dst.

---

### ✅ **TEST 2: Login**

**Endpoint:** `POST {{base_url}}/login`

**Langkah:**
1. Klik **Login** di folder Auth
2. Tab **Body** → **raw** → **JSON**
3. Data:
   ```json
   {
     "username": "testsiswa",
     "password": "password123"
   }
   ```
4. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 1,
      "nama_pengguna": "Test Siswa",
      "username": "testsiswa",
      "role": "siswa"
    },
    "token": "2|xyz123abc456..."
  }
}
```

**🔥 PENTING:** 
- Token akan **OTOMATIS TERSIMPAN** di variable `{{token}}`
- Cek di tab **Tests** ada script untuk save token
- Token ini akan digunakan untuk semua request selanjutnya

---

### ✅ **TEST 3: Get Current User (Me)**

**Endpoint:** `GET {{base_url}}/me`

**Langkah:**
1. Klik **Get Me** di folder Auth
2. Perhatikan di tab **Headers** ada:
   ```
   Key: Authorization
   Value: Bearer {{token}}
   ```
3. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "nama_pengguna": "Test Siswa",
      "username": "testsiswa",
      "role": "siswa"
    }
  }
}
```

**⚠️ Jika error 401 Unauthorized:**
- Login dulu di TEST 2
- Token belum tersimpan

---

### ✅ **TEST 4: Get Profile**

**Endpoint:** `GET {{base_url}}/profile`

**Langkah:**
1. Expand folder **Profile**
2. Klik **Get Profile**
3. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nama_pengguna": "Test Siswa",
    "username": "testsiswa",
    "role": "siswa",
    "created_at": "2025-11-05T10:30:00.000000Z",
    "updated_at": "2025-11-05T10:30:00.000000Z"
  }
}
```

---

### ✅ **TEST 5: Update Profile**

**Endpoint:** `PUT {{base_url}}/profile`

**Langkah:**
1. Klik **Update Profile (Name & Username)** di folder Profile
2. Tab **Body** → **raw** → **JSON**
3. Edit data:
   ```json
   {
     "nama_pengguna": "Test Siswa Edited",
     "username": "testsiswa_edited"
   }
   ```
4. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "message": "Profile berhasil diupdate",
  "data": {
    "id": 1,
    "nama_pengguna": "Test Siswa Edited",
    "username": "testsiswa_edited",
    "role": "siswa"
  }
}
```

---

### ✅ **TEST 6: Get Homepage**

**Endpoint:** `GET {{base_url}}/homepage`

**Langkah:**
1. Expand folder **Homepage**
2. Klik **Get Homepage Data**
3. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "data": {
    "stats": {
      "total_pengaduan": 0,
      "diajukan": 0,
      "diproses": 0,
      "selesai": 0,
      "ditolak": 0
    },
    "latest_pengaduan": []
  }
}
```

**📝 Note:** Angka 0 karena belum ada pengaduan. Nanti akan berubah setelah create pengaduan.

---

### ✅ **TEST 7: Get List Lokasi**

**Endpoint:** `GET {{base_url}}/lokasi`

**Langkah:**
1. Expand folder **Master Data**
2. Klik **Get Lokasi**
3. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
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

**📝 Note:** Copy salah satu `id_lokasi` untuk test berikutnya (misalnya: 1)

---

### ✅ **TEST 8: Get List Barang by Lokasi**

**Endpoint:** `GET {{base_url}}/barang?id_lokasi=1`

**Langkah:**
1. Klik **Get Barang by Lokasi** di folder Master Data
2. Lihat tab **Params**, ada:
   ```
   KEY: id_lokasi
   VALUE: 1
   ```
3. Ganti VALUE sesuai id_lokasi yang ada
4. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
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

**📝 Note:** Copy salah satu `id_barang` untuk test berikutnya

---

### ✅ **TEST 9: Create Pengaduan (TANPA FOTO)**

**Endpoint:** `POST {{base_url}}/pengaduan`

**Langkah:**
1. Expand folder **Pengaduan**
2. Klik **Create Pengaduan (Normal)**
3. **PENTING:** Tab **Body** → pilih **form-data**
4. Isi data (ganti sesuai id_lokasi dan id_barang yang ada):
   ```
   KEY: id_lokasi     | VALUE: 1
   KEY: id_barang     | VALUE: 1
   KEY: keluhan       | VALUE: AC rusak tidak dingin
   ```
5. **UNCHECKLIST** (disable) field `foto` dulu
6. **Klik SEND**

**Response yang diharapkan (Status: 201 Created):**
```json
{
  "success": true,
  "message": "Pengaduan berhasil dibuat",
  "data": {
    "id": 1,
    "status": "diajukan"
  }
}
```

---

### ✅ **TEST 10: Create Pengaduan (DENGAN FOTO)**

**Endpoint:** `POST {{base_url}}/pengaduan`

**Langkah:**
1. Siapkan foto/gambar (format JPG/PNG, max 2MB)
2. Klik **Create Pengaduan (Normal)** di folder Pengaduan
3. Tab **Body** → **form-data**
4. Isi data:
   ```
   KEY: id_lokasi     | VALUE: 1
   KEY: id_barang     | VALUE: 2
   KEY: keluhan       | VALUE: Kipas rusak berisik
   KEY: foto          | TYPE: File | [Select File] → pilih gambar
   ```
5. **CHECKLIST** (enable) field `foto`
6. Klik **Select Files** pada field foto
7. Pilih gambar dari komputer Anda
8. **Klik SEND**

**Response yang diharapkan (Status: 201 Created):**
```json
{
  "success": true,
  "message": "Pengaduan berhasil dibuat",
  "data": {
    "id": 2,
    "status": "diajukan"
  }
}
```

**✅ Cara cek foto berhasil diupload:**
- Buka folder `C:\laragon\www\pengaduan-sarpas\public\uploads`
- Akan ada file gambar baru dengan nama timestamp

---

### ✅ **TEST 11: Create Pengaduan (TEMPORARY ITEM)**

**Endpoint:** `POST {{base_url}}/pengaduan`

**Langkah:**
1. Klik **Create Pengaduan (Temporary Item)** di folder Pengaduan
2. Tab **Body** → **form-data**
3. Data:
   ```
   KEY: id_lokasi                    | VALUE: 1
   KEY: is_temporary_item            | VALUE: true
   KEY: temporary_item_name          | VALUE: Whiteboard Baru
   KEY: temporary_item_description   | VALUE: Whiteboard untuk kelas
   KEY: keluhan                      | VALUE: Butuh whiteboard baru
   ```
4. **Klik SEND**

**Response yang diharapkan (Status: 201 Created):**
```json
{
  "success": true,
  "message": "Pengaduan berhasil dibuat",
  "data": {
    "id": 3,
    "status": "diajukan"
  }
}
```

**📝 Note:** 
- Item request akan masuk ke database table `item_requests` dengan status "pending"
- Admin bisa approve/reject dari dashboard

---

### ✅ **TEST 12: Get History Pengaduan (ALL)**

**Endpoint:** `GET {{base_url}}/pengaduan/history?status=all`

**Langkah:**
1. Klik **Get History (All)** di folder Pengaduan
2. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 3,
      "lokasi": "Kelas 10A",
      "barang": "Whiteboard Baru",
      "keluhan": "Butuh whiteboard baru",
      "status": "diajukan",
      "is_temporary_item": true,
      "catatan_petugas": null,
      "tanggal": "05 Nov 2025 14:30",
      "foto_url": null
    },
    {
      "id": 2,
      "lokasi": "Kelas 10A",
      "barang": "Kipas Angin",
      "keluhan": "Kipas rusak berisik",
      "status": "diajukan",
      "is_temporary_item": false,
      "catatan_petugas": null,
      "tanggal": "05 Nov 2025 14:25",
      "foto_url": "http://localhost/pengaduan-sarpas/public/uploads/1699187890.jpg"
    },
    {
      "id": 1,
      "lokasi": "Kelas 10A",
      "barang": "AC",
      "keluhan": "AC rusak tidak dingin",
      "status": "diajukan",
      "is_temporary_item": false,
      "catatan_petugas": null,
      "tanggal": "05 Nov 2025 14:20",
      "foto_url": null
    }
  ]
}
```

---

### ✅ **TEST 13: Get History Pengaduan (BY STATUS)**

**Endpoint:** `GET {{base_url}}/pengaduan/history?status=diajukan`

**Langkah:**
1. Klik **Get History (By Status)** di folder Pengaduan
2. Di tab **Params**, ganti VALUE sesuai keinginan:
   - `all` = semua
   - `diajukan` = yang pending
   - `diproses` = yang sedang dikerjakan
   - `selesai` = yang sudah selesai
   - `ditolak` = yang ditolak
3. **Klik SEND**

---

### ✅ **TEST 14: Get Detail Pengaduan**

**Endpoint:** `GET {{base_url}}/pengaduan/{id}`

**Langkah:**
1. Klik **Get Detail Pengaduan** di folder Pengaduan
2. Ganti angka `1` di URL dengan ID pengaduan yang ada
   - Misalnya: `{{base_url}}/pengaduan/2`
3. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 2,
    "lokasi": "Kelas 10A",
    "barang": "Kipas Angin",
    "keluhan": "Kipas rusak berisik",
    "status": "diajukan",
    "is_temporary_item": false,
    "temporary_item_description": null,
    "catatan_petugas": null,
    "tanggal": "05 Nov 2025 14:25",
    "foto_url": "http://localhost/pengaduan-sarpas/public/uploads/1699187890.jpg"
  }
}
```

**⚠️ Jika error 404:**
- ID pengaduan tidak ada
- Ganti dengan ID yang valid

---

### ✅ **TEST 15: Logout**

**Endpoint:** `POST {{base_url}}/logout`

**Langkah:**
1. Klik **Logout** di folder Auth
2. **Klik SEND**

**Response yang diharapkan (Status: 200 OK):**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

**📝 Note:** Token akan dihapus dari server. Kalau mau test lagi, login ulang.

---

## 🐛 TROUBLESHOOTING

### ❌ Error: "Could not get any response"
**Penyebab:** Server Laravel tidak running

**Solusi:**
```bash
cd C:\laragon\www\pengaduan-sarpas
php artisan serve
```

### ❌ Error: 401 Unauthorized
**Penyebab:** Belum login atau token expired

**Solusi:**
1. Login dulu (TEST 2)
2. Token akan auto-save
3. Coba request lagi

### ❌ Error: 404 Not Found
**Penyebab:** Endpoint salah atau routes belum terdaftar

**Solusi:**
```bash
php artisan route:list --path=api
```
Cek apakah endpoint ada di list.

### ❌ Error: 422 Validation Error
**Penyebab:** Data yang dikirim tidak sesuai validasi

**Solusi:**
- Baca response body untuk tahu field mana yang error
- Contoh: `"username sudah digunakan"` → ganti username

### ❌ Error: 500 Internal Server Error
**Penyebab:** Error di server Laravel

**Solusi:**
1. Buka file: `C:\laragon\www\pengaduan-sarpas\storage\logs\laravel.log`
2. Scroll ke paling bawah untuk lihat error terbaru
3. Fix error sesuai log

### ❌ Foto tidak bisa diupload
**Penyebab:** Ukuran terlalu besar atau format salah

**Solusi:**
- Max size: 2MB
- Format: JPG, JPEG, PNG
- Pastikan folder `public/uploads` writable

---

## ✅ CHECKLIST TESTING

Centang setelah berhasil:

- [ ] ✅ Register user baru
- [ ] ✅ Login
- [ ] ✅ Get Me
- [ ] ✅ Get Profile
- [ ] ✅ Update Profile
- [ ] ✅ Get Homepage
- [ ] ✅ Get Lokasi
- [ ] ✅ Get Barang by Lokasi
- [ ] ✅ Create Pengaduan (tanpa foto)
- [ ] ✅ Create Pengaduan (dengan foto)
- [ ] ✅ Create Pengaduan (temporary item)
- [ ] ✅ Get History (all)
- [ ] ✅ Get History (by status)
- [ ] ✅ Get Detail Pengaduan
- [ ] ✅ Logout

---

## 📸 CARA UPLOAD FOTO DI POSTMAN

1. Di tab **Body**, pilih **form-data**
2. Pada field `foto`:
   - Hover mouse ke kolom VALUE
   - Dropdown akan muncul: **Text** atau **File**
   - Pilih **File**
3. Klik **Select Files**
4. Pilih gambar dari komputer
5. Pastikan field `foto` di-checklist (enabled)
6. Send request

---

## 🎯 TIPS

1. **Simpan Token:** Setelah login, token otomatis tersimpan di `{{token}}`
2. **Test Berurutan:** Ikuti urutan TEST 1-15 untuk hasil konsisten
3. **Copy ID:** Simpan id_lokasi dan id_barang untuk create pengaduan
4. **Check Response:** Selalu baca response untuk memastikan success: true
5. **Status Code:** 200/201 = success, 401 = unauthorized, 422 = validation error

---

## 🚀 NEXT STEPS

Setelah semua test berhasil:
1. ✅ **API sudah ready untuk Flutter**
2. 📱 **Mulai develop Flutter app**
3. 📖 **Baca:** `FLUTTER_INTEGRATION_GUIDE.md`
4. 🔧 **Setup Flutter project & dependencies**
5. 💻 **Implement screens & API integration**

---

**🎉 Selamat Testing! Semoga Lancar! 🚀**
