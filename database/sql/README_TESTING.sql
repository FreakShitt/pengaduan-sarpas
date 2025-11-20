-- ============================================
-- CARA INSTALL DAN TEST
-- Database Objects: Stored Procedures, Functions, Triggers
-- ============================================

-- STEP 1: Install semua database objects
-- Jalankan file-file berikut secara berurutan:

-- 1. Install Stored Procedures
SOURCE database/sql/stored_procedures.sql;

-- 2. Install Functions
SOURCE database/sql/functions.sql;

-- 3. Install Triggers
SOURCE database/sql/triggers.sql;

-- ============================================
-- TESTING STORED PROCEDURES
-- ============================================

-- Test 1: Tambah Pengaduan Baru
CALL sp_tambah_pengaduan(
    5,                              -- user_id
    'Ruang Kelas 1A',              -- lokasi
    'Kursi',                       -- barang
    'Kursi patah kaki nya, tidak bisa diduduki',  -- detail_laporan
    0,                             -- is_temporary_item
    @new_id                        -- output pengaduan_id
);
SELECT @new_id as pengaduan_id_baru;

-- Test 2: Update Status Pengaduan
CALL sp_update_status_pengaduan(
    1,                             -- pengaduan_id
    'disetujui',                   -- status baru
    3,                             -- petugas_id
    'Akan segera ditangani'        -- catatan_petugas
);

-- Test 3: Get Statistik Pengaduan
CALL sp_get_statistik_pengaduan(@total, @diajukan, @disetujui, @ditolak, @selesai);
SELECT 
    @total as total_pengaduan,
    @diajukan as diajukan,
    @disetujui as disetujui,
    @ditolak as ditolak,
    @selesai as selesai;

-- Test 4: Get Pengaduan by User
CALL sp_get_pengaduan_by_user(5);

-- ============================================
-- TESTING FUNCTIONS
-- ============================================

-- Test 1: Hitung Pengaduan by Status
SELECT 
    fn_hitung_pengaduan_by_status('diajukan') as total_diajukan,
    fn_hitung_pengaduan_by_status('disetujui') as total_disetujui,
    fn_hitung_pengaduan_by_status('ditolak') as total_ditolak,
    fn_hitung_pengaduan_by_status('selesai') as total_selesai;

-- Test 2: Get Status Label
SELECT 
    id,
    lokasi,
    barang,
    status,
    fn_get_status_label(status) as status_label
FROM pengaduans
LIMIT 5;

-- Test 3: Persentase Penyelesaian
SELECT 
    CONCAT(fn_persentase_penyelesaian(), '%') as persentase_selesai;

-- Test 4: Cek User adalah Petugas
SELECT 
    id,
    nama_pengguna,
    role,
    fn_is_petugas(id) as is_petugas
FROM user
LIMIT 5;

-- Test 5: Total Pengaduan per User
SELECT 
    id,
    nama_pengguna,
    fn_total_pengaduan_user(id) as total_pengaduan
FROM user
WHERE role = 'siswa';

-- Test 6: Hari Sejak Pengaduan
SELECT 
    id,
    lokasi,
    barang,
    created_at,
    fn_hari_sejak_pengaduan(id) as hari_berlalu
FROM pengaduans
ORDER BY created_at DESC
LIMIT 5;

-- Test 7: Barang Paling Banyak Rusak
SELECT fn_barang_paling_banyak_rusak() as barang_terbanyak_rusak;

-- Test 8: Validasi Username
SELECT 
    'admin' as username,
    fn_validasi_username('admin') as valid
UNION ALL
SELECT 'ab', fn_validasi_username('ab')
UNION ALL
SELECT 'user_123', fn_validasi_username('user_123');

-- ============================================
-- TESTING TRIGGERS
-- ============================================

-- Test 1: Trigger Log Status (akan otomatis berjalan saat update)
-- Update status pengaduan
UPDATE pengaduans 
SET status = 'disetujui', petugas_id = 3
WHERE id = 1;

-- Cek log perubahan status
SELECT * FROM pengaduan_status_log ORDER BY changed_at DESC LIMIT 5;

-- Test 2: Trigger Validasi Insert (akan error jika detail < 10 karakter)
-- Ini akan ERROR:
-- INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
-- VALUES (5, 'Test', 'Test', 'Short');

-- Ini akan BERHASIL:
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Ruang Lab', 'Komputer', 'Komputer tidak bisa nyala, sudah dicoba restart');

-- Test 3: Counter Pengaduan per User
-- Insert pengaduan baru akan otomatis update counter
INSERT INTO pengaduans (user_id, lokasi, barang, detail_laporan)
VALUES (5, 'Perpustakaan', 'Meja', 'Meja goyang tidak stabil');

-- Cek counter
SELECT * FROM user_pengaduan_counter WHERE user_id = 5;

-- Test 4: Log Penghapusan
-- Hapus pengaduan (akan tersimpan di log)
DELETE FROM pengaduans WHERE id = 999;  -- Ganti dengan ID yang ada

-- Cek log penghapusan
SELECT * FROM pengaduan_deleted_log ORDER BY deleted_at DESC LIMIT 5;

-- ============================================
-- QUERY GABUNGAN (Menggunakan Stored Procedure & Function)
-- ============================================

-- Dashboard Statistics dengan Function
SELECT 
    'Total Pengaduan' as keterangan,
    fn_hitung_pengaduan_by_status('diajukan') + 
    fn_hitung_pengaduan_by_status('disetujui') + 
    fn_hitung_pengaduan_by_status('ditolak') + 
    fn_hitung_pengaduan_by_status('selesai') as jumlah
UNION ALL
SELECT 'Diajukan', fn_hitung_pengaduan_by_status('diajukan')
UNION ALL
SELECT 'Disetujui', fn_hitung_pengaduan_by_status('disetujui')
UNION ALL
SELECT 'Ditolak', fn_hitung_pengaduan_by_status('ditolak')
UNION ALL
SELECT 'Selesai', fn_hitung_pengaduan_by_status('selesai')
UNION ALL
SELECT 'Persentase Selesai', fn_persentase_penyelesaian();

-- Laporan Lengkap dengan Status Label dan Hari Berlalu
SELECT 
    p.id,
    p.lokasi,
    p.barang,
    fn_get_status_label(p.status) as status_label,
    fn_hari_sejak_pengaduan(p.id) as hari_berlalu,
    u.nama_pengguna as pengadu,
    fn_total_pengaduan_user(p.user_id) as total_pengaduan_user
FROM pengaduans p
JOIN user u ON p.user_id = u.id
ORDER BY p.created_at DESC
LIMIT 10;

-- ============================================
-- UNINSTALL (Jika ingin menghapus semua)
-- ============================================

-- Drop Triggers
DROP TRIGGER IF EXISTS trg_after_update_status_pengaduan;
DROP TRIGGER IF EXISTS trg_before_insert_pengaduan;
DROP TRIGGER IF EXISTS trg_before_update_pengaduan;
DROP TRIGGER IF EXISTS trg_after_delete_pengaduan;
DROP TRIGGER IF EXISTS trg_before_insert_item_request;
DROP TRIGGER IF EXISTS trg_after_insert_pengaduan_counter;
DROP TRIGGER IF EXISTS trg_after_delete_pengaduan_counter;
DROP TRIGGER IF EXISTS trg_before_insert_user;

-- Drop Functions
DROP FUNCTION IF EXISTS fn_hitung_pengaduan_by_status;
DROP FUNCTION IF EXISTS fn_get_status_label;
DROP FUNCTION IF EXISTS fn_persentase_penyelesaian;
DROP FUNCTION IF EXISTS fn_is_petugas;
DROP FUNCTION IF EXISTS fn_total_pengaduan_user;
DROP FUNCTION IF EXISTS fn_hari_sejak_pengaduan;
DROP FUNCTION IF EXISTS fn_barang_paling_banyak_rusak;
DROP FUNCTION IF EXISTS fn_validasi_username;

-- Drop Stored Procedures
DROP PROCEDURE IF EXISTS sp_tambah_pengaduan;
DROP PROCEDURE IF EXISTS sp_update_status_pengaduan;
DROP PROCEDURE IF EXISTS sp_approve_item_request;
DROP PROCEDURE IF EXISTS sp_get_statistik_pengaduan;
DROP PROCEDURE IF EXISTS sp_get_pengaduan_by_user;

-- Drop Tables
DROP TABLE IF EXISTS pengaduan_status_log;
DROP TABLE IF EXISTS pengaduan_deleted_log;
DROP TABLE IF EXISTS user_pengaduan_counter;
