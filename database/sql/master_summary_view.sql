-- ============================================
-- MASTER SUMMARY VIEW - UNTUK SCREENSHOT PENGAWAS
-- View ini menampilkan semua info penting dalam 1 layar
-- ============================================

USE pengaduan_sarpas;

-- View: Master Summary untuk Screenshot
DROP VIEW IF EXISTS view_master_summary;

CREATE VIEW view_master_summary AS
SELECT 
    CAST('A. DATABASE OBJECTS' AS CHAR(255)) as Kategori,
    CAST('==================' AS CHAR(255)) as Detail,
    CAST('' AS CHAR(255)) as Jumlah
UNION ALL
SELECT 
    'A1. Stored Procedures',
    'Transaction & Error Handling',
    '5 items'
UNION ALL
SELECT 
    'A2. Functions',
    'DETERMINISTIC & READS SQL DATA',
    '8 items'
UNION ALL
SELECT 
    'A3. Triggers',
    'BEFORE/AFTER INSERT/UPDATE/DELETE',
    '8 items'
UNION ALL
SELECT 
    'A4. Views',
    'Visual demo di phpMyAdmin',
    '9 items'
UNION ALL
SELECT 
    'A5. Support Tables',
    'Log & Counter tables',
    '3 items'
UNION ALL
SELECT 
    '',
    'TOTAL OBJECTS',
    '33 items'
UNION ALL
SELECT 
    '',
    '',
    ''
UNION ALL
SELECT 
    'B. FEATURES',
    '==================',
    ''
UNION ALL
SELECT 
    'B1. Transaction Management',
    'BEGIN/COMMIT/ROLLBACK',
    'YES'
UNION ALL
SELECT 
    'B2. Error Handling',
    'SQLEXCEPTION & SIGNAL',
    'YES'
UNION ALL
SELECT 
    'B3. Data Integrity',
    'Foreign Keys & CASCADE',
    'YES'
UNION ALL
SELECT 
    'B4. Validation',
    'SIGNAL SQLSTATE',
    'YES'
UNION ALL
SELECT 
    'B5. Auto Logging',
    'Trigger-based logging',
    'YES'
UNION ALL
SELECT 
    'B6. Auto Counter',
    'Real-time counter per user',
    'YES'
UNION ALL
SELECT 
    '',
    '',
    ''
UNION ALL
SELECT 
    'C. STATISTIK LIVE',
    '==================',
    ''
UNION ALL
SELECT 
    'C1. Total Pengaduan',
    'Semua status',
    CAST(COUNT(*) AS CHAR)
FROM pengaduans
UNION ALL
SELECT 
    'C2. Status Diajukan',
    fn_get_status_label('diajukan'),
    CAST(fn_hitung_pengaduan_by_status('diajukan') AS CHAR)
UNION ALL
SELECT 
    'C3. Status Disetujui',
    fn_get_status_label('disetujui'),
    CAST(fn_hitung_pengaduan_by_status('disetujui') AS CHAR)
UNION ALL
SELECT 
    'C4. Status Ditolak',
    fn_get_status_label('ditolak'),
    CAST(fn_hitung_pengaduan_by_status('ditolak') AS CHAR)
UNION ALL
SELECT 
    'C5. Status Selesai',
    fn_get_status_label('selesai'),
    CAST(fn_hitung_pengaduan_by_status('selesai') AS CHAR)
UNION ALL
SELECT 
    'C6. Persentase Selesai',
    'Completion rate',
    CAST(CONCAT(fn_persentase_penyelesaian(), '%') AS CHAR)
UNION ALL
SELECT 
    'C7. Barang Terbanyak Rusak',
    'Most reported item',
    CAST(COALESCE(fn_barang_paling_banyak_rusak(), '-') AS CHAR);
