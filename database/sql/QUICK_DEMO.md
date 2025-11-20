# 🚀 QUICK START - DEMO KE PENGAWAS

## 📍 Buka phpMyAdmin
1. Browser → `http://localhost/phpmyadmin`
2. Klik database: **pengaduan_sarpas**

---

## ✅ TOP 5 VIEWS UNTUK DEMO (KLIK LANGSUNG!)

### 1️⃣ view_quick_summary
**Tunjukkan ini PERTAMA!**
- Total semua objects: 5 SP + 8 Functions + 8 Triggers + 10 Views + 3 Tables
- Screenshot ini untuk bukti database objects lengkap

### 2️⃣ view_statistik_pengaduan  
**Demo Functions**
- Statistik otomatis dari functions
- Total, Diajukan, Disetujui, Ditolak, Selesai
- Persentase penyelesaian

### 3️⃣ view_demo_functions
**Demo 8 Functions Sekaligus**
- Eksekusi otomatis semua functions
- Tunjukkan hasil calculations, validations, dll

### 4️⃣ view_info_triggers
**Info 8 Triggers**
- Daftar lengkap triggers dengan penjelasan
- BEFORE/AFTER INSERT/UPDATE/DELETE

### 5️⃣ view_info_stored_procedures
**Info 5 Stored Procedures**
- Daftar SP dengan cara pakai
- Transaction & error handling

---

## 🔥 DEMO LIVE (Optional - Jika Diminta)

### Demo Trigger Live:
```sql
-- 1. Insert pengaduan baru
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan) 
VALUES (5, 'Perpustakaan', 'AC', 'AC tidak dingin sudah lama tidak service');

-- 2. Cek counter otomatis bertambah
SELECT * FROM view_user_counter WHERE User_ID = 5;

-- 3. Update status
UPDATE pengaduans SET status = 'disetujui', petugas_id = 3 WHERE id = 1;

-- 4. Cek log perubahan
SELECT * FROM view_log_status LIMIT 5;
```

### Demo Stored Procedure:
```sql
-- Get statistik dengan OUT parameters
CALL sp_get_statistik_pengaduan(@t, @d1, @d2, @d3, @s);
SELECT @t as Total, @d1 as Diajukan, @d2 as Disetujui, @d3 as Ditolak, @s as Selesai;
```

---

## 📊 YANG HARUS DITUNJUKKAN:

### ✅ Tab "Routines" (di phpMyAdmin)
- 5 Stored Procedures
- 8 Functions
- Klik salah satu → lihat kode SQL lengkap

### ✅ Tab "Triggers"  
- 8 Triggers
- Klik salah satu → lihat kode SQL lengkap

### ✅ Tab "Structure" → scroll Views
- 10 Views
- Klik untuk lihat data

### ✅ 3 Support Tables:
- pengaduan_status_log
- pengaduan_deleted_log  
- user_pengaduan_counter

---

## 🎯 CHECKLIST DEMO

- [ ] Buka phpMyAdmin
- [ ] Pilih database pengaduan_sarpas
- [ ] Klik **view_quick_summary** → Screenshot!
- [ ] Klik **view_statistik_pengaduan** → Screenshot!
- [ ] Klik **view_demo_functions** → Screenshot!
- [ ] Klik tab **Routines** → Screenshot (5 SP + 8 Functions)!
- [ ] Klik tab **Triggers** → Screenshot (8 Triggers)!
- [ ] DONE! ✅

---

## 📸 5 SCREENSHOT WAJIB:

1. ✅ **view_quick_summary** → Summary total objects
2. ✅ **view_statistik_pengaduan** → Hasil functions
3. ✅ **view_demo_functions** → Demo 8 functions
4. ✅ Tab **Routines** → 5 SP + 8 Functions
5. ✅ Tab **Triggers** → 8 Triggers

---

## 💯 NILAI TAMBAH:

- **Transaction**: Ada di stored_procedures.sql (BEGIN/COMMIT/ROLLBACK)
- **Error Handling**: SQLEXCEPTION & SIGNAL SQLSTATE
- **Data Integrity**: Foreign Keys with CASCADE
- **Automation**: 8 Triggers yang otomatis jalan
- **Logging**: Auto log perubahan status & penghapusan
- **Counter**: Real-time counter per user

---

## 🏆 TOTAL DATABASE OBJECTS: **34 OBJECTS**
- 5 Stored Procedures
- 8 Functions  
- 8 Triggers
- 10 Views
- 3 Support Tables

**SIAP PRESENTASI! 🚀**
