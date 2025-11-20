# 🔍 BUKTI IMPLEMENTASI PASSIVE FEATURES DI CODE

Fitur-fitur yang **BENAR-BENAR DITERAPKAN** di project kita.

---

## 1️⃣ COMMIT & ROLLBACK (LARAVEL CODE)

### 📍 **LOKASI:**
**File:** `app/Http/Controllers/AdminController.php`  
**Baris:** 517-548  
**Function:** `approveItemRequest()`

### 📝 **CODE ASLI:**

```php
public function approveItemRequest($id)
{
    $itemRequest = ItemRequest::findOrFail($id);
    
    if ($itemRequest->status != 'pending') {
        return redirect()->back()->with('error', 'Item request sudah diproses sebelumnya.');
    }

    try {
        DB::beginTransaction();  // 👈 MULAI TRANSACTION

        // Operasi 1: Check if lokasi exists, if not create it
        $lokasi = Lokasi::where('nama_lokasi', $itemRequest->nama_lokasi)->first();
        if (!$lokasi) {
            Lokasi::create([
                'nama_lokasi' => $itemRequest->nama_lokasi,
                'deskripsi' => 'Lokasi dari item request',
                'aktif' => true,
            ]);
        }

        // Operasi 2: Create new Barang
        Barang::create([
            'nama_lokasi' => $itemRequest->nama_lokasi,
            'nama_barang' => $itemRequest->nama_barang,
            'deskripsi' => $itemRequest->deskripsi,
            'aktif' => true,
        ]);

        // Operasi 3: Update item request status
        $itemRequest->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'review_note' => 'Item telah disetujui dan ditambahkan ke daftar barang.',
        ]);

        DB::commit();  // 👈 SIMPAN PERMANEN!

        return redirect()->back()->with('success', 'Item request berhasil disetujui dan ditambahkan ke daftar barang.');
        
    } catch (\Exception $e) {
        DB::rollBack();  // 👈 BATAL SEMUA JIKA ERROR!
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
```

### 🎯 **PENJELASAN:**

**Skenario:** Admin approve permintaan barang baru dari user

**Flow:**
1. **Cek lokasi ada atau tidak**
2. **Jika tidak ada → buat lokasi baru**
3. **Buat barang baru**
4. **Update status item_request jadi 'approved'**

**Kenapa Pakai Transaction?**
- ❌ Kalau lokasi berhasil dibuat, tapi barang GAGAL → **ROLLBACK!**
- ❌ Kalau barang berhasil dibuat, tapi update status GAGAL → **ROLLBACK!**
- ✅ Kalau SEMUA SUKSES → **COMMIT!**

**Tanpa Transaction:**
```
❌ Lokasi sudah dibuat
❌ Barang gagal dibuat
❌ Status tidak terupdate
❌ Database jadi BERANTAKAN! (ada lokasi tapi tidak ada barangnya)
```

**Dengan Transaction:**
```
✅ Semua operasi SUKSES → Data tersimpan
❌ Ada 1 yang GAGAL → Semua dibatalkan, database tetap bersih!
```

---

### 🧪 **CARA TEST:**

#### **Test 1: Semua Sukses (COMMIT)**
1. Login sebagai **admin** (admin/admin123)
2. Buka: `http://127.0.0.1:8000/admin/item-requests`
3. Klik **"Approve"** pada request yang pending
4. Cek database:

```sql
-- Cek lokasi bertambah
SELECT * FROM lokasi ORDER BY created_at DESC LIMIT 1;

-- Cek barang bertambah
SELECT * FROM barang ORDER BY created_at DESC LIMIT 1;

-- Cek status berubah
SELECT * FROM item_requests WHERE status = 'approved' ORDER BY updated_at DESC LIMIT 1;
```

✅ **Hasil:** Semua data tersimpan! (COMMIT berhasil)

---

#### **Test 2: Ada Error (ROLLBACK)**

**Cara Simulasi Error:**
1. Buka database, hapus kolom di tabel `barang` sementara
2. Approve item request
3. Error akan terjadi saat create barang
4. Cek database:

```sql
-- Cek lokasi (seharusnya TIDAK bertambah karena ROLLBACK)
SELECT * FROM lokasi ORDER BY created_at DESC LIMIT 1;
```

✅ **Hasil:** Lokasi TIDAK tersimpan meskipun sudah dibuat! (ROLLBACK berhasil)

**Note:** Jangan lupa kembalikan struktur tabel setelah test!

---

## 2️⃣ TRIGGERS (MySQL DATABASE)

### 📍 **LOKASI:**
**File:** `database/sql/triggers.sql`  
**Database:** Sudah terinstall di MySQL

**Triggers TIDAK ADA di code Laravel karena dihandle langsung oleh MySQL!**

### ✅ **8 TRIGGERS YANG AKTIF:**

| No | Trigger | Event | Tabel | Fungsi |
|----|---------|-------|-------|--------|
| 1 | trg_before_insert_pengaduan | BEFORE INSERT | pengaduans | Validasi & set defaults |
| 2 | trg_before_update_pengaduan | BEFORE UPDATE | pengaduans | Auto update timestamps |
| 3 | trg_after_update_status_pengaduan | AFTER UPDATE | pengaduans | Log perubahan status |
| 4 | trg_after_delete_pengaduan | AFTER DELETE | pengaduans | Backup data terhapus |
| 5 | trg_after_insert_pengaduan_counter | AFTER INSERT | pengaduans | Increment counter |
| 6 | trg_after_delete_pengaduan_counter | AFTER DELETE | pengaduans | Decrement counter |
| 7 | trg_before_insert_item_request | BEFORE INSERT | item_requests | Validasi item request |
| 8 | trg_before_insert_user | BEFORE INSERT | user | Validasi user baru |

---

### 🧪 **CARA TEST TRIGGERS:**

#### **Test 1: Trigger Log Status**

**Di Laravel:**
1. Login sebagai **petugas** (petugas/petugas123)
2. Buka pengaduan
3. Update status dari "diajukan" → "diproses"
4. Cek di phpMyAdmin:

```sql
SELECT * FROM pengaduan_status_log ORDER BY changed_at DESC LIMIT 5;
```

**Output:**
```
+----+--------------+-------------+-------------+------------+---------------------+
| id | pengaduan_id | status_lama | status_baru | changed_by | changed_at          |
+----+--------------+-------------+-------------+------------+---------------------+
|  1 |            6 | diajukan    | diproses    |          3 | 2025-11-20 11:22:44 |
+----+--------------+-------------+-------------+------------+---------------------+
```

✅ **TERBUKTI! Trigger otomatis log perubahan!**

---

#### **Test 2: Trigger Counter**

**Di Laravel:**
1. Login sebagai **siswa** (siswa/siswa123)
2. Buat pengaduan baru via form
3. Cek di phpMyAdmin:

```sql
SELECT * FROM user_pengaduan_counter WHERE user_id = 5;
```

**Output:**
```
+---------+-----------------+---------------------+
| user_id | total_pengaduan | last_pengaduan_at   |
+---------+-----------------+---------------------+
|       5 |               5 | 2025-11-20 11:35:00 |
+---------+-----------------+---------------------+
```

✅ **TERBUKTI! Counter otomatis +1 setiap kali user buat pengaduan!**

---

#### **Test 3: Trigger Validasi**

**Via phpMyAdmin (karena Laravel punya validasi sendiri):**

```sql
-- Coba insert dengan detail < 10 karakter
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Lab', 'PC', 'Rusak');
```

**Output:**
```
ERROR 1644 (45000): Detail laporan harus minimal 10 karakter
```

✅ **TERBUKTI! Trigger reject data invalid!**

---

## 📊 SUMMARY

### **COMMIT & ROLLBACK:**
- ✅ **Lokasi di Code:** `AdminController.php` line 517-548
- ✅ **Function:** `approveItemRequest()`
- ✅ **Total Operasi:** 3 operasi (create lokasi, create barang, update status)
- ✅ **Fungsi:** Jika salah satu gagal, semua dibatalkan

### **TRIGGERS:**
- ✅ **Total:** 8 triggers
- ✅ **Lokasi:** Database MySQL (bukan di code Laravel)
- ✅ **File SQL:** `database/sql/triggers.sql`
- ✅ **Jalan Otomatis:** Ya, tanpa perlu code Laravel
- ✅ **Support Tables:** 
  - `pengaduan_status_log` (log perubahan)
  - `pengaduan_deleted_log` (backup data)
  - `user_pengaduan_counter` (counter real-time)

---

## 🎯 CARA DEMO KE PENGAWAS

### **1. Tunjukkan Code Laravel (COMMIT/ROLLBACK):**
```
Buka: app/Http/Controllers/AdminController.php
Line: 517-548
Highlight: DB::beginTransaction(), DB::commit(), DB::rollBack()
```

### **2. Test Live di Browser:**
```
1. Login admin: admin/admin123
2. Approve item request
3. Show database sebelum & sesudah
4. Jelasin: "Kalau gagal di tengah, semua dibatalkan otomatis"
```

### **3. Tunjukkan Triggers di phpMyAdmin:**
```
1. Buka http://localhost/phpmyadmin
2. Database: pengaduan_sarpas
3. Tab "Triggers" → Ada 8 triggers!
4. Klik salah satu → Show code
```

### **4. Test Trigger Live:**
```
1. Update status pengaduan di browser
2. Buka phpMyAdmin → table pengaduan_status_log
3. Show: "Lihat pak/bu, otomatis tercatat!"
```

---

## ✨ KESIMPULAN

**✅ COMMIT & ROLLBACK:**
- Ada di Laravel code: `AdminController.php`
- Digunakan untuk approve item request
- 3 operasi dilindungi transaction

**✅ TRIGGERS:**
- 8 triggers aktif di MySQL
- Tidak perlu code Laravel (otomatis jalan)
- Untuk logging, validasi, dan counter

**Semua sudah LIVE dan BERFUNGSI! 🚀**
