-- ============================================
-- VIEWS untuk Demo ke Pengawas
-- View ini akan muncul di phpMyAdmin seperti tabel biasa
-- ============================================

USE pengaduan_sarpas;

-- 1. VIEW: Statistik Pengaduan (menggunakan functions)
DROP VIEW IF EXISTS view_statistik_pengaduan;

CREATE VIEW view_statistik_pengaduan AS
SELECT 
    'Total Pengaduan' as Keterangan,
    (fn_hitung_pengaduan_by_status('diajukan') + 
     fn_hitung_pengaduan_by_status('disetujui') + 
     fn_hitung_pengaduan_by_status('ditolak') + 
     fn_hitung_pengaduan_by_status('selesai')) as Jumlah
UNION ALL
SELECT 'Diajukan', fn_hitung_pengaduan_by_status('diajukan')
UNION ALL
SELECT 'Disetujui', fn_hitung_pengaduan_by_status('disetujui')
UNION ALL
SELECT 'Ditolak', fn_hitung_pengaduan_by_status('ditolak')
UNION ALL
SELECT 'Selesai', fn_hitung_pengaduan_by_status('selesai')
UNION ALL
SELECT 'Persentase Selesai (%)', fn_persentase_penyelesaian();

-- 2. VIEW: Pengaduan dengan Status Label (menggunakan function)
DROP VIEW IF EXISTS view_pengaduan_lengkap;

CREATE VIEW view_pengaduan_lengkap AS
SELECT 
    p.id as ID_Pengaduan,
    u.nama_pengguna as Nama_Pengadu,
    p.lokasi as Lokasi,
    p.barang as Barang,
    LEFT(p.detail_laporan, 50) as Detail_Laporan,
    fn_get_status_label(p.status) as Status_Label,
    fn_hari_sejak_pengaduan(p.id) as Hari_Berlalu,
    COALESCE(pet.nama_pengguna, '-') as Nama_Petugas,
    p.created_at as Tanggal_Dibuat
FROM pengaduans p
JOIN user u ON p.user_id = u.id
LEFT JOIN user pet ON p.petugas_id = pet.id
ORDER BY p.created_at DESC;

-- 3. VIEW: Counter Pengaduan Per User
DROP VIEW IF EXISTS view_user_counter;

CREATE VIEW view_user_counter AS
SELECT 
    u.id as User_ID,
    u.nama_pengguna as Nama_Pengguna,
    u.role as Role,
    COALESCE(c.total_pengaduan, 0) as Total_Pengaduan,
    c.last_pengaduan_at as Pengaduan_Terakhir,
    fn_is_petugas(u.id) as Adalah_Petugas
FROM user u
LEFT JOIN user_pengaduan_counter c ON u.id = c.user_id
WHERE u.role = 'siswa'
ORDER BY c.total_pengaduan DESC;

-- 4. VIEW: Log Perubahan Status
DROP VIEW IF EXISTS view_log_status;

CREATE VIEW view_log_status AS
SELECT 
    l.id as Log_ID,
    l.pengaduan_id as ID_Pengaduan,
    p.lokasi as Lokasi,
    p.barang as Barang,
    fn_get_status_label(l.status_lama) as Status_Lama,
    fn_get_status_label(l.status_baru) as Status_Baru,
    COALESCE(u.nama_pengguna, '-') as Diubah_Oleh,
    l.changed_at as Waktu_Perubahan
FROM pengaduan_status_log l
JOIN pengaduans p ON l.pengaduan_id = p.id
LEFT JOIN user u ON l.changed_by = u.id
ORDER BY l.changed_at DESC;

-- 5. VIEW: Barang Paling Banyak Rusak
DROP VIEW IF EXISTS view_barang_rusak_terbanyak;

CREATE VIEW view_barang_rusak_terbanyak AS
SELECT 
    barang as Nama_Barang,
    COUNT(*) as Jumlah_Laporan,
    CONCAT(ROUND((COUNT(*) * 100.0) / (SELECT COUNT(*) FROM pengaduans), 2), '%') as Persentase
FROM pengaduans
GROUP BY barang
ORDER BY COUNT(*) DESC;

-- 6. VIEW: Demo Semua Functions
DROP VIEW IF EXISTS view_demo_functions;

CREATE VIEW view_demo_functions AS
SELECT 
    CAST('fn_hitung_pengaduan_by_status' AS CHAR(255)) as Nama_Function,
    CAST('Hitung total pengaduan berdasarkan status' AS CHAR(255)) as Deskripsi,
    CAST(CONCAT('Diajukan: ', fn_hitung_pengaduan_by_status('diajukan'), 
           ', Disetujui: ', fn_hitung_pengaduan_by_status('disetujui'),
           ', Ditolak: ', fn_hitung_pengaduan_by_status('ditolak'),
           ', Selesai: ', fn_hitung_pengaduan_by_status('selesai')) AS CHAR(255)) as Hasil
UNION ALL
SELECT 
    CAST('fn_persentase_penyelesaian' AS CHAR(255)),
    CAST('Hitung persentase pengaduan yang selesai' AS CHAR(255)),
    CAST(CONCAT(fn_persentase_penyelesaian(), '%') AS CHAR(255))
UNION ALL
SELECT 
    CAST('fn_barang_paling_banyak_rusak' AS CHAR(255)),
    CAST('Ambil nama barang yang paling banyak dilaporkan rusak' AS CHAR(255)),
    CAST(COALESCE(fn_barang_paling_banyak_rusak(), 'Tidak ada data') AS CHAR(255))
UNION ALL
SELECT 
    CAST('fn_validasi_username' AS CHAR(255)),
    CAST('Validasi format username (min 3 karakter)' AS CHAR(255)),
    CAST(CONCAT('admin: ', IF(fn_validasi_username('admin'), 'Valid', 'Tidak Valid'),
           ', ab: ', IF(fn_validasi_username('ab'), 'Valid', 'Tidak Valid')) AS CHAR(255));

-- 7. VIEW: Ringkasan Triggers
DROP VIEW IF EXISTS view_info_triggers;

CREATE VIEW view_info_triggers AS
SELECT 
    'trg_after_update_status_pengaduan' as Nama_Trigger,
    'AFTER UPDATE' as Event,
    'pengaduans' as Tabel,
    'Log setiap perubahan status ke tabel pengaduan_status_log' as Fungsi
UNION ALL
SELECT 
    'trg_before_insert_pengaduan',
    'BEFORE INSERT',
    'pengaduans',
    'Validasi detail_laporan min 10 karakter, set default status'
UNION ALL
SELECT 
    'trg_before_update_pengaduan',
    'BEFORE UPDATE',
    'pengaduans',
    'Auto update timestamp updated_at'
UNION ALL
SELECT 
    'trg_after_delete_pengaduan',
    'AFTER DELETE',
    'pengaduans',
    'Simpan data yang dihapus ke pengaduan_deleted_log'
UNION ALL
SELECT 
    'trg_before_insert_item_request',
    'BEFORE INSERT',
    'item_requests',
    'Validasi nama_barang tidak boleh kosong'
UNION ALL
SELECT 
    'trg_after_insert_pengaduan_counter',
    'AFTER INSERT',
    'pengaduans',
    'Increment counter di user_pengaduan_counter'
UNION ALL
SELECT 
    'trg_after_delete_pengaduan_counter',
    'AFTER DELETE',
    'pengaduans',
    'Decrement counter di user_pengaduan_counter'
UNION ALL
SELECT 
    'trg_before_insert_user',
    'BEFORE INSERT',
    'user',
    'Validasi role dan username min 3 karakter';

-- 8. VIEW: Ringkasan Stored Procedures
DROP VIEW IF EXISTS view_info_stored_procedures;

CREATE VIEW view_info_stored_procedures AS
SELECT 
    'sp_tambah_pengaduan' as Nama_Procedure,
    'INSERT pengaduan baru dengan transaction' as Fungsi,
    'CALL sp_tambah_pengaduan(user_id, lokasi, barang, detail, is_temp, @new_id)' as Cara_Pakai
UNION ALL
SELECT 
    'sp_update_status_pengaduan',
    'UPDATE status pengaduan dengan error handling',
    'CALL sp_update_status_pengaduan(pengaduan_id, status_baru, petugas_id, catatan)'
UNION ALL
SELECT 
    'sp_approve_item_request',
    'Approve permintaan barang (cek/buat lokasi, buat barang, update request)',
    'CALL sp_approve_item_request(request_id, admin_id)'
UNION ALL
SELECT 
    'sp_get_statistik_pengaduan',
    'Get statistik total, diajukan, disetujui, ditolak, selesai',
    'CALL sp_get_statistik_pengaduan(@total, @diajukan, @disetujui, @ditolak, @selesai)'
UNION ALL
SELECT 
    'sp_get_pengaduan_by_user',
    'Query pengaduan berdasarkan user_id dengan JOIN',
    'CALL sp_get_pengaduan_by_user(user_id)';

-- 9. VIEW: History Penghapusan Pengaduan
DROP VIEW IF EXISTS view_deleted_pengaduan;

CREATE VIEW view_deleted_pengaduan AS
SELECT 
    d.id as Log_ID,
    d.pengaduan_id as ID_Pengaduan_Dihapus,
    u.nama_pengguna as Pengadu,
    d.lokasi as Lokasi,
    d.barang as Barang,
    d.status as Status_Terakhir,
    d.deleted_at as Waktu_Dihapus
FROM pengaduan_deleted_log d
LEFT JOIN user u ON d.user_id = u.id
ORDER BY d.deleted_at DESC;

-- Selesai!
-- Semua VIEW sudah dibuat
-- Buka phpMyAdmin di http://localhost/phpmyadmin
-- Pilih database pengaduan_sarpas
-- Views akan muncul dengan ikon berbeda dari tabel
