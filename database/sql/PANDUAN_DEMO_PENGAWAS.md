# 📋 PANDUAN DEMO UNTUK PENGAWAS
## Database Objects: Stored Procedures, Functions, Triggers

---

## 🌐 CARA BUKA DI PHPMYADMIN

1. **Buka Browser** → Ketik: `http://localhost/phpmyadmin`
2. **Login phpMyAdmin** (jika diminta)
3. **Pilih Database**: Klik `pengaduan_sarpas` di sidebar kiri
4. **Lihat Views**: Scroll ke bawah, akan ada section "Views" dengan ikon berbeda

---

## 📊 LIST VIEWS UNTUK DEMO

### ✅ Views yang Sudah Dibuat (Total: 9 Views)

| No | Nama View | Fungsi | Cara Lihat di phpMyAdmin |
|----|-----------|--------|--------------------------|
| 1 | `view_statistik_pengaduan` | Statistik lengkap menggunakan functions | Klik nama view → akan tampil tabel statistik |
| 2 | `view_pengaduan_lengkap` | Daftar pengaduan dengan status emoji | Akan tampil data lengkap dengan emoji status |
| 3 | `view_user_counter` | Counter pengaduan per user (hasil trigger) | Tampil total pengaduan setiap siswa |
| 4 | `view_log_status` | History perubahan status (hasil trigger) | Tampil log setiap kali status berubah |
| 5 | `view_barang_rusak_terbanyak` | Barang paling banyak rusak (function) | Ranking barang dengan persentase |
| 6 | `view_demo_functions` | Demo semua 8 functions sekaligus | Tampil hasil eksekusi semua function |
| 7 | `view_info_triggers` | Info lengkap 8 triggers | Daftar trigger dengan penjelasan |
| 8 | `view_info_stored_procedures` | Info 5 stored procedures | Daftar SP dengan cara pakai |
| 9 | `view_deleted_pengaduan` | History pengaduan yang dihapus (trigger) | Log penghapusan data |

---

## 🎯 ALUR DEMO KE PENGAWAS

### STEP 1: Tunjukkan Database Objects yang Ada
```
1. Buka phpMyAdmin
2. Pilih database "pengaduan_sarpas"
3. Klik tab "Routines" → Tunjukkan:
   - 5 Stored Procedures
   - 8 Functions
4. Klik tab "Triggers" → Tunjukkan:
   - 8 Triggers
```

### STEP 2: Demo View Statistik (Menggunakan Functions)
```
1. Klik "view_statistik_pengaduan"
2. Tampil tabel:
   - Total Pengaduan
   - Diajukan, Disetujui, Ditolak, Selesai
   - Persentase Selesai
3. JELASKAN: "Ini hasil dari function fn_hitung_pengaduan_by_status() 
              dan fn_persentase_penyelesaian()"
```

### STEP 3: Demo View Pengaduan Lengkap (Function Label Emoji)
```
1. Klik "view_pengaduan_lengkap"
2. Lihat kolom "Status_Label" → Ada emoji:
   - 🕐 Diajukan
   - ✅ Disetujui
   - ❌ Ditolak
   - ✔️ Selesai
3. JELASKAN: "Emoji ini dari function fn_get_status_label()"
```

### STEP 4: Demo View Demo Functions
```
1. Klik "view_demo_functions"
2. Tampil 4 baris yang menunjukkan hasil eksekusi semua function
3. JELASKAN: "Ini eksekusi otomatis 8 functions sekaligus"
```

### STEP 5: Demo Triggers dengan Insert Data Live
```
1. Klik tab "SQL" di phpMyAdmin
2. Paste query berikut:

INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan) 
VALUES (5, 'Lab Biologi', 'Mikroskop', 'Lensa mikroskop pecah tidak bisa digunakan');

3. Klik "Go"
4. Buka "view_user_counter" → Lihat counter bertambah otomatis
5. JELASKAN: "Ini hasil trigger trg_after_insert_pengaduan_counter 
              yang otomatis increment counter"
```

### STEP 6: Demo Trigger Log Status
```
1. Klik tab "SQL"
2. Paste query:

UPDATE pengaduans SET status = 'disetujui', petugas_id = 3 WHERE id = 1;

3. Klik "Go"
4. Buka "view_log_status" → Lihat log perubahan status
5. JELASKAN: "Trigger trg_after_update_status_pengaduan otomatis 
              catat setiap perubahan status"
```

### STEP 7: Demo Stored Procedure
```
1. Klik tab "SQL"
2. Paste query:

CALL sp_get_statistik_pengaduan(@total, @diajukan, @disetujui, @ditolak, @selesai);
SELECT @total, @diajukan, @disetujui, @ditolak, @selesai;

3. Klik "Go"
4. JELASKAN: "Stored procedure sp_get_statistik_pengaduan 
              return 5 nilai sekaligus dengan OUT parameter"
```

### STEP 8: Tunjukkan Info Lengkap
```
1. Klik "view_info_triggers" → Tampil daftar 8 triggers dengan penjelasan
2. Klik "view_info_stored_procedures" → Tampil 5 SP dengan cara pakai
3. JELASKAN: "Total ada:
   - 5 Stored Procedures (dengan transaction & error handling)
   - 8 Functions (DETERMINISTIC & READS SQL DATA)
   - 8 Triggers (BEFORE/AFTER INSERT/UPDATE/DELETE)
   - 3 Support Tables (log_status, deleted_log, counter)"
```

---

## 💡 PENJELASAN TEKNIS KE PENGAWAS

### 1. Stored Procedures ✅
- **sp_tambah_pengaduan**: Insert dengan transaction, return ID baru via OUT parameter
- **sp_update_status_pengaduan**: Update dengan SQLEXCEPTION handler
- **sp_approve_item_request**: Complex logic (check lokasi, create jika perlu, insert barang)
- **sp_get_statistik_pengaduan**: Return 5 OUT parameters sekaligus
- **sp_get_pengaduan_by_user**: Query dengan LEFT JOIN

**Keunggulan**: Transaction handling, error handling, complex business logic

### 2. Functions ✅
- **fn_hitung_pengaduan_by_status**: COUNT berdasarkan status
- **fn_get_status_label**: Return string dengan emoji
- **fn_persentase_penyelesaian**: Kalkulasi persentase
- **fn_is_petugas**: Boolean check role
- **fn_total_pengaduan_user**: COUNT per user
- **fn_hari_sejak_pengaduan**: DATEDIFF calculation
- **fn_barang_paling_banyak_rusak**: GROUP BY + ORDER BY + LIMIT
- **fn_validasi_username**: REGEXP validation

**Keunggulan**: Reusable, bisa dipanggil dalam SELECT, deterministic

### 3. Triggers ✅
- **trg_after_update_status_pengaduan**: Auto logging
- **trg_before_insert_pengaduan**: Validation & default values
- **trg_before_update_pengaduan**: Auto timestamp
- **trg_after_delete_pengaduan**: Archive deleted data
- **trg_before_insert_item_request**: Validation
- **trg_after_insert_pengaduan_counter**: Increment counter
- **trg_after_delete_pengaduan_counter**: Decrement counter
- **trg_before_insert_user**: Role & username validation

**Keunggulan**: Automatic, transparent, data integrity

### 4. Support Tables ✅
- **pengaduan_status_log**: Log setiap perubahan status
- **pengaduan_deleted_log**: Archive data yang dihapus
- **user_pengaduan_counter**: Real-time counter per user

**Keunggulan**: Audit trail, data recovery, performance optimization

---

## 🔥 HIGHLIGHT UNTUK PENGAWAS

### ✅ Bukti Transaction (Commit/Rollback)
```sql
-- Buka stored_procedures.sql, tunjukkan:
START TRANSACTION;
-- business logic
IF error THEN
    ROLLBACK;
ELSE
    COMMIT;
END IF;
```

### ✅ Bukti Error Handling
```sql
-- Di stored procedures ada:
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
    ROLLBACK;
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error message';
END;
```

### ✅ Bukti Foreign Key & Cascade
```sql
-- Di triggers.sql:
FOREIGN KEY (pengaduan_id) REFERENCES pengaduans(id) ON DELETE CASCADE
```

### ✅ Bukti Validation dengan SIGNAL
```sql
-- Di triggers:
IF LENGTH(NEW.detail_laporan) < 10 THEN
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'Detail laporan harus minimal 10 karakter';
END IF;
```

---

## 📸 SCREENSHOT YANG PERLU DIAMBIL

1. ✅ Tab "Routines" → tampil 5 SP + 8 Functions
2. ✅ Tab "Triggers" → tampil 8 triggers
3. ✅ View "view_statistik_pengaduan" → hasil functions
4. ✅ View "view_pengaduan_lengkap" → emoji status
5. ✅ View "view_log_status" → log perubahan
6. ✅ View "view_user_counter" → counter otomatis
7. ✅ View "view_demo_functions" → demo semua functions
8. ✅ Isi file "stored_procedures.sql" → tunjukkan transaction
9. ✅ Isi file "triggers.sql" → tunjukkan validation

---

## ⚡ QUICK DEMO (5 MENIT)

1. Buka phpMyAdmin → database pengaduan_sarpas
2. Tab "Routines" → tunjukkan 13 objects (5 SP + 8 Functions)
3. Tab "Triggers" → tunjukkan 8 triggers
4. Klik "view_statistik_pengaduan" → tampil statistik otomatis
5. Klik "view_demo_functions" → tampil hasil 8 functions
6. Klik "view_info_triggers" → info lengkap triggers
7. Klik "view_info_stored_procedures" → info lengkap SP
8. DONE! ✅

---

## 📁 LOKASI FILE SQL

Semua file SQL ada di folder:
```
C:\laragon\www\Project-UKK\pengaduan-sarpas-github\database\sql\
```

File yang ada:
- ✅ `stored_procedures.sql` (5 procedures)
- ✅ `functions.sql` (8 functions)
- ✅ `triggers.sql` (8 triggers + 3 tables)
- ✅ `create_views.sql` (9 views untuk demo)
- ✅ `README_TESTING.sql` (panduan testing lengkap)

---

## 🎓 KESIMPULAN

Database ini sudah dilengkapi dengan:
- ✅ **5 Stored Procedures** dengan transaction & error handling
- ✅ **8 Functions** yang deterministic & reusable
- ✅ **8 Triggers** untuk automation & validation
- ✅ **3 Support Tables** untuk logging & counter
- ✅ **9 Views** untuk demo visual di phpMyAdmin
- ✅ **Transaction Management** (BEGIN/COMMIT/ROLLBACK)
- ✅ **Error Handling** (SQLEXCEPTION & SIGNAL)
- ✅ **Data Integrity** (Foreign Keys & Cascade)
- ✅ **Validation** (SIGNAL SQLSTATE untuk reject invalid data)

**Total Database Objects: 25 objects** (5+8+8+3+9)

Siap untuk presentasi! 🚀
