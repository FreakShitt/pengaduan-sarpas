# 🤖 PASSIVE FEATURES - README

Database objects yang bekerja **OTOMATIS** tanpa perlu dipanggil manual.

---

## 📋 DAFTAR ISI
1. [COMMIT & ROLLBACK](#commit--rollback)
2. [TRIGGERS](#triggers)
3. [CARA MEMBUKTIKAN](#cara-membuktikan)

---

## 1️⃣ COMMIT & ROLLBACK

### 📍 **Lokasi di Code:**
File: `database/sql/stored_procedures.sql`

### **A. COMMIT (Simpan Permanen)**

**Contoh di SP #1 (sp_tambah_pengaduan):**
```sql
BEGIN
    START TRANSACTION;
    
    INSERT INTO pengaduans (...) VALUES (...);
    
    COMMIT;  👈 SIMPAN PERMANEN!
END
```

**Kapan dipanggil?**
- ✅ Otomatis dipanggil jika **SEMUA operasi BERHASIL**
- ✅ Data tersimpan permanen ke database

---

**Contoh di SP #3 (sp_approve_item_request):**
```sql
BEGIN
    START TRANSACTION;
    
    -- Operasi 1: Cek lokasi
    SELECT COUNT(*) INTO v_lokasi_exists...
    
    -- Operasi 2: Insert lokasi jika perlu
    IF v_lokasi_exists = 0 THEN
        INSERT INTO lokasi...
    END IF;
    
    -- Operasi 3: Insert barang
    INSERT INTO barang...
    
    -- Operasi 4: Update item request
    UPDATE item_requests...
    
    COMMIT;  👈 SEMUA 4 OPERASI DISIMPAN SEKALIGUS!
END
```

**Keuntungan:**
- ✅ Data konsisten (semua atau tidak sama sekali)
- ✅ Tidak ada data setengah jadi

---

### **B. ROLLBACK (Batal/Undo)**

**Contoh di SP #1 (sp_tambah_pengaduan):**
```sql
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION  👈 Tangkap ERROR
    BEGIN
        ROLLBACK;  👈 BATALKAN SEMUA!
        SET p_pengaduan_id = 0;
    END;
    
    START TRANSACTION;
    
    INSERT INTO pengaduans (...) VALUES (...);
    
    COMMIT;
END
```

**Kapan dipanggil?**
- ❌ Otomatis dipanggil jika terjadi **ERROR**
- ❌ Semua perubahan dibatalkan (seperti Ctrl+Z)

---

**Contoh Kasus ROLLBACK:**
```sql
START TRANSACTION;

INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Lab', 'PC', 'PC rusak');  ✅ Berhasil

INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (999, 'Lab', 'AC', 'AC rusak');  ❌ ERROR! user_id 999 tidak ada

-- Otomatis ROLLBACK!
-- INSERT pertama yang tadi BERHASIL juga DIBATALKAN!
-- Database kembali seperti sebelum START TRANSACTION
```

**Keuntungan:**
- ✅ Data integrity terjaga
- ✅ Tidak ada data rusak/corrupt
- ✅ Automatic error handling

---

### **📊 Diagram COMMIT vs ROLLBACK:**

```
SCENARIO 1 - SEMUA SUKSES:
START TRANSACTION
    ↓
INSERT pengaduans  ✅
    ↓
INSERT log         ✅
    ↓
UPDATE counter     ✅
    ↓
COMMIT  ✅ → Data tersimpan permanen!
```

```
SCENARIO 2 - ADA ERROR:
START TRANSACTION
    ↓
INSERT pengaduans  ✅
    ↓
INSERT log         ✅
    ↓
UPDATE counter     ❌ ERROR!
    ↓
ROLLBACK  ❌ → Semua dibatalkan! Database kembali seperti semula
```

---

## 2️⃣ TRIGGERS

### 📍 **Lokasi di Code:**
File: `database/sql/triggers.sql`

**Total: 8 Triggers**

### **A. BEFORE INSERT/UPDATE (Validasi & Default Values)**

#### **1. trg_before_insert_pengaduan**
```sql
CREATE TRIGGER trg_before_insert_pengaduan
BEFORE INSERT ON pengaduans
FOR EACH ROW
BEGIN
    -- Validasi: detail minimal 10 karakter
    IF LENGTH(NEW.detail_laporan) < 10 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Detail laporan harus minimal 10 karakter';
    END IF;
    
    -- Set default status
    IF NEW.status IS NULL THEN
        SET NEW.status = 'diajukan';
    END IF;
    
    -- Set timestamps
    SET NEW.created_at = NOW();
    SET NEW.updated_at = NOW();
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** sebelum INSERT ke tabel `pengaduans`
- 🤖 Tidak perlu dipanggil manual!

**Contoh:**
```sql
-- Ini akan ERROR otomatis!
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Lab', 'PC', 'Rusak');  ❌ ERROR! < 10 karakter

-- Ini akan SUKSES otomatis!
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Lab', 'PC', 'PC tidak bisa nyala sama sekali');  ✅
-- Status otomatis = 'diajukan'
-- created_at & updated_at otomatis = NOW()
```

---

#### **2. trg_before_update_pengaduan**
```sql
CREATE TRIGGER trg_before_update_pengaduan
BEFORE UPDATE ON pengaduans
FOR EACH ROW
BEGIN
    SET NEW.updated_at = NOW();
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** sebelum UPDATE tabel `pengaduans`

**Contoh:**
```sql
UPDATE pengaduans SET lokasi = 'Lab Baru' WHERE id = 1;
-- Otomatis updated_at = NOW()! 🕐
```

---

#### **3. trg_before_insert_item_request**
```sql
CREATE TRIGGER trg_before_insert_item_request
BEFORE INSERT ON item_requests
FOR EACH ROW
BEGIN
    -- Validasi nama barang tidak boleh kosong
    IF LENGTH(TRIM(NEW.nama_barang)) = 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Nama barang tidak boleh kosong';
    END IF;
    
    -- Set default
    IF NEW.status IS NULL THEN
        SET NEW.status = 'pending';
    END IF;
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** sebelum INSERT ke tabel `item_requests`

---

#### **4. trg_before_insert_user**
```sql
CREATE TRIGGER trg_before_insert_user
BEFORE INSERT ON user
FOR EACH ROW
BEGIN
    -- Validasi role
    IF NEW.role NOT IN ('siswa', 'petugas', 'admin') THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Role harus: siswa, petugas, atau admin';
    END IF;
    
    -- Validasi username
    IF LENGTH(NEW.username) < 3 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Username harus minimal 3 karakter';
    END IF;
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** sebelum INSERT ke tabel `user`

---

### **B. AFTER INSERT/UPDATE/DELETE (Logging & Counter)**

#### **5. trg_after_update_status_pengaduan**
```sql
CREATE TRIGGER trg_after_update_status_pengaduan
AFTER UPDATE ON pengaduans
FOR EACH ROW
BEGIN
    IF OLD.status != NEW.status THEN
        INSERT INTO pengaduan_status_log (
            pengaduan_id,
            status_lama,
            status_baru,
            changed_by,
            changed_at
        )
        VALUES (
            NEW.id,
            OLD.status,
            NEW.status,
            NEW.petugas_id,
            NOW()
        );
    END IF;
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** setelah UPDATE tabel `pengaduans`
- 🤖 Hanya jika status berubah

**Contoh:**
```sql
UPDATE pengaduans SET status = 'diproses' WHERE id = 1;

-- Otomatis INSERT ke pengaduan_status_log:
-- pengaduan_id: 1
-- status_lama: 'diajukan'
-- status_baru: 'diproses'
-- changed_at: 2025-11-20 10:30:00
```

**Tabel Target:** `pengaduan_status_log`

---

#### **6. trg_after_delete_pengaduan**
```sql
CREATE TRIGGER trg_after_delete_pengaduan
AFTER DELETE ON pengaduans
FOR EACH ROW
BEGIN
    INSERT INTO pengaduan_deleted_log (
        pengaduan_id,
        user_id,
        lokasi,
        barang,
        status,
        deleted_at
    )
    VALUES (
        OLD.id,
        OLD.user_id,
        OLD.lokasi,
        OLD.barang,
        OLD.status,
        NOW()
    );
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** setelah DELETE dari tabel `pengaduans`

**Contoh:**
```sql
DELETE FROM pengaduans WHERE id = 10;

-- Otomatis BACKUP data ke pengaduan_deleted_log sebelum dihapus!
-- Bisa di-restore jika perlu! 💾
```

**Tabel Target:** `pengaduan_deleted_log`

---

#### **7. trg_after_insert_pengaduan_counter**
```sql
CREATE TRIGGER trg_after_insert_pengaduan_counter
AFTER INSERT ON pengaduans
FOR EACH ROW
BEGIN
    INSERT INTO user_pengaduan_counter (user_id, total_pengaduan, last_pengaduan_at)
    VALUES (NEW.user_id, 1, NOW())
    ON DUPLICATE KEY UPDATE 
        total_pengaduan = total_pengaduan + 1,
        last_pengaduan_at = NOW();
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** setelah INSERT ke tabel `pengaduans`

**Contoh:**
```sql
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Lab', 'PC', 'PC tidak bisa nyala');

-- Otomatis UPDATE counter:
-- user_id 5: total_pengaduan += 1
```

**Tabel Target:** `user_pengaduan_counter`

---

#### **8. trg_after_delete_pengaduan_counter**
```sql
CREATE TRIGGER trg_after_delete_pengaduan_counter
AFTER DELETE ON pengaduans
FOR EACH ROW
BEGIN
    UPDATE user_pengaduan_counter
    SET total_pengaduan = total_pengaduan - 1
    WHERE user_id = OLD.user_id;
END
```

**Kapan jalan?**
- 🤖 **OTOMATIS** setelah DELETE dari tabel `pengaduans`

**Contoh:**
```sql
DELETE FROM pengaduans WHERE id = 10;

-- Otomatis UPDATE counter:
-- user_id tersebut: total_pengaduan -= 1
```

**Tabel Target:** `user_pengaduan_counter`

---

## 3️⃣ CARA MEMBUKTIKAN

### **📍 A. Bukti COMMIT & ROLLBACK**

#### **Via phpMyAdmin:**
1. Buka `http://localhost/phpmyadmin`
2. Pilih database `pengaduan_sarpas`
3. Klik tab **"Routines"**
4. Klik salah satu Stored Procedure (contoh: `sp_tambah_pengaduan`)
5. Lihat kodenya → ada **START TRANSACTION**, **COMMIT**, **ROLLBACK**

#### **Via File:**
- Buka file: `database/sql/stored_procedures.sql`
- Semua 5 SP punya COMMIT & ROLLBACK
- Baris 24: `START TRANSACTION;`
- Baris 47: `COMMIT;`
- Baris 19: `ROLLBACK;` (dalam error handler)

---

### **📍 B. Bukti TRIGGERS Ada & Aktif**

#### **1. Lihat di phpMyAdmin:**
```
http://localhost/phpmyadmin
→ Pilih database: pengaduan_sarpas
→ Klik tab "Triggers"
→ Akan tampil 8 triggers!
```

#### **2. Query di SQL:**
```sql
-- Cek semua triggers
SELECT TRIGGER_NAME, EVENT_MANIPULATION, EVENT_OBJECT_TABLE 
FROM information_schema.triggers 
WHERE trigger_schema='pengaduan_sarpas';
```

**Output:**
```
+------------------------------------+--------+---------------+
| TRIGGER_NAME                       | Event  | Table         |
+------------------------------------+--------+---------------+
| trg_before_insert_pengaduan        | INSERT | pengaduans    |
| trg_before_update_pengaduan        | UPDATE | pengaduans    |
| trg_after_update_status_pengaduan  | UPDATE | pengaduans    |
| trg_after_delete_pengaduan         | DELETE | pengaduans    |
| trg_after_insert_pengaduan_counter | INSERT | pengaduans    |
| trg_after_delete_pengaduan_counter | DELETE | pengaduans    |
| trg_before_insert_item_request     | INSERT | item_requests |
| trg_before_insert_user             | INSERT | user          |
+------------------------------------+--------+---------------+
```

---

### **📍 C. Bukti TRIGGERS Bekerja**

#### **Test 1: Trigger Log Status**
```sql
-- Update status pengaduan
UPDATE pengaduans 
SET status = 'selesai', petugas_id = 3 
WHERE id = 6;

-- Cek log otomatis tercatat!
SELECT * FROM pengaduan_status_log 
WHERE pengaduan_id = 6 
ORDER BY changed_at DESC;
```

**Output:**
```
+----+--------------+-------------+-------------+------------+---------------------+
| id | pengaduan_id | status_lama | status_baru | changed_by | changed_at          |
+----+--------------+-------------+-------------+------------+---------------------+
|  2 |            6 | diproses    | selesai     |          3 | 2025-11-20 11:30:00 |
|  1 |            6 | diajukan    | diproses    |          3 | 2025-11-20 11:22:44 |
+----+--------------+-------------+-------------+------------+---------------------+
```
✅ **TERBUKTI! Trigger otomatis log setiap perubahan status!**

---

#### **Test 2: Trigger Counter**
```sql
-- Insert pengaduan baru
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Perpustakaan', 'Meja', 'Meja goyang tidak stabil');

-- Cek counter otomatis bertambah!
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
✅ **TERBUKTI! Trigger otomatis increment counter!**

---

#### **Test 3: Trigger Validasi**
```sql
-- Coba insert dengan detail < 10 karakter
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Lab', 'PC', 'Rusak');
```

**Output:**
```
ERROR 1644 (45000): Detail laporan harus minimal 10 karakter
```
✅ **TERBUKTI! Trigger otomatis validasi & reject data invalid!**

---

#### **Test 4: Trigger Deleted Log**
```sql
-- Hapus pengaduan
DELETE FROM pengaduans WHERE id = 10;

-- Cek data tersimpan di log!
SELECT * FROM pengaduan_deleted_log 
ORDER BY deleted_at DESC 
LIMIT 1;
```

**Output:**
```
+----+--------------+---------+---------+--------+---------+---------------------+
| id | pengaduan_id | user_id | lokasi  | barang | status  | deleted_at          |
+----+--------------+---------+---------+--------+---------+---------------------+
|  1 |           10 |       5 | Lab     | PC     | diajukan| 2025-11-20 11:40:00 |
+----+--------------+---------+---------+--------+---------+---------------------+
```
✅ **TERBUKTI! Trigger otomatis backup sebelum delete!**

---

## 📊 SUMMARY

### **COMMIT & ROLLBACK:**
- ✅ **Lokasi:** Semua 5 Stored Procedures
- ✅ **Cara Lihat:** Buka `stored_procedures.sql` atau phpMyAdmin > Routines
- ✅ **Jalan Otomatis:** Ya, saat SP dipanggil
- ✅ **Fungsi:** Data consistency & error handling

### **TRIGGERS:**
- ✅ **Total:** 8 Triggers
- ✅ **Lokasi:** File `triggers.sql` & phpMyAdmin > tab Triggers
- ✅ **Jalan Otomatis:** Ya, saat INSERT/UPDATE/DELETE
- ✅ **Fungsi:** Validasi, logging, counter, backup

### **Support Tables:**
- ✅ `pengaduan_status_log` - Log perubahan status
- ✅ `pengaduan_deleted_log` - Backup data terhapus
- ✅ `user_pengaduan_counter` - Counter real-time per user

---

## 🎯 KESIMPULAN

**Semua Passive Features SUDAH AKTIF!**

1. **COMMIT** → Menyimpan data permanen jika sukses
2. **ROLLBACK** → Membatalkan data jika ada error
3. **8 TRIGGERS** → Bekerja otomatis untuk validasi, logging, dan counter

**Tidak perlu dipanggil manual, semuanya OTOMATIS!** 🤖✨
