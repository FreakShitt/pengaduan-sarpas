-- ============================================
-- FUNCTIONS untuk Sistem Pengaduan Sarpas
-- ============================================

USE pengaduan_sarpas;

-- 1. Function: Hitung Total Pengaduan by Status
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_pengaduan_by_status$$

CREATE FUNCTION fn_hitung_pengaduan_by_status(
    p_status ENUM('diajukan', 'disetujui', 'ditolak', 'selesai')
)
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total INT;
    
    SELECT COUNT(*) INTO v_total
    FROM pengaduans
    WHERE status = p_status;
    
    RETURN v_total;
END$$

DELIMITER ;

-- 2. Function: Get Status Label dengan Emoji
DELIMITER $$

DROP FUNCTION IF EXISTS fn_get_status_label$$

CREATE FUNCTION fn_get_status_label(
    p_status VARCHAR(50)
)
RETURNS VARCHAR(100)
DETERMINISTIC
BEGIN
    DECLARE v_label VARCHAR(100);
    
    CASE p_status
        WHEN 'diajukan' THEN SET v_label = '🕐 Diajukan';
        WHEN 'diproses' THEN SET v_label = '⏳ Diproses';
        WHEN 'disetujui' THEN SET v_label = '✅ Disetujui';
        WHEN 'ditolak' THEN SET v_label = '❌ Ditolak';
        WHEN 'selesai' THEN SET v_label = '✔️ Selesai';
        ELSE SET v_label = '❓ Unknown';
    END CASE;
    
    RETURN v_label;
END$$

DELIMITER ;

-- 3. Function: Hitung Persentase Penyelesaian
DELIMITER $$

DROP FUNCTION IF EXISTS fn_persentase_penyelesaian$$

CREATE FUNCTION fn_persentase_penyelesaian()
RETURNS DECIMAL(5,2)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total INT;
    DECLARE v_selesai INT;
    DECLARE v_persentase DECIMAL(5,2);
    
    SELECT COUNT(*) INTO v_total FROM pengaduans;
    SELECT COUNT(*) INTO v_selesai FROM pengaduans WHERE status = 'selesai';
    
    IF v_total = 0 THEN
        SET v_persentase = 0;
    ELSE
        SET v_persentase = (v_selesai / v_total) * 100;
    END IF;
    
    RETURN v_persentase;
END$$

DELIMITER ;

-- 4. Function: Cek Apakah User adalah Petugas
DELIMITER $$

DROP FUNCTION IF EXISTS fn_is_petugas$$

CREATE FUNCTION fn_is_petugas(
    p_user_id BIGINT
)
RETURNS BOOLEAN
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_role VARCHAR(50);
    
    SELECT role INTO v_role
    FROM user
    WHERE id = p_user_id;
    
    RETURN v_role = 'petugas';
END$$

DELIMITER ;

-- 5. Function: Get Total Pengaduan by User
DELIMITER $$

DROP FUNCTION IF EXISTS fn_total_pengaduan_user$$

CREATE FUNCTION fn_total_pengaduan_user(
    p_user_id BIGINT
)
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_total INT;
    
    SELECT COUNT(*) INTO v_total
    FROM pengaduans
    WHERE user_id = p_user_id;
    
    RETURN v_total;
END$$

DELIMITER ;

-- 6. Function: Hitung Hari Sejak Pengaduan
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hari_sejak_pengaduan$$

CREATE FUNCTION fn_hari_sejak_pengaduan(
    p_pengaduan_id BIGINT
)
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_created_at TIMESTAMP;
    DECLARE v_hari INT;
    
    SELECT created_at INTO v_created_at
    FROM pengaduans
    WHERE id = p_pengaduan_id;
    
    SET v_hari = DATEDIFF(NOW(), v_created_at);
    
    RETURN v_hari;
END$$

DELIMITER ;

-- 7. Function: Get Nama Barang Terbanyak Dilaporkan
DELIMITER $$

DROP FUNCTION IF EXISTS fn_barang_paling_banyak_rusak$$

CREATE FUNCTION fn_barang_paling_banyak_rusak()
RETURNS VARCHAR(255)
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE v_barang VARCHAR(255);
    
    SELECT barang INTO v_barang
    FROM pengaduans
    GROUP BY barang
    ORDER BY COUNT(*) DESC
    LIMIT 1;
    
    RETURN IFNULL(v_barang, 'Tidak ada data');
END$$

DELIMITER ;

-- 8. Function: Validasi Username Format
DELIMITER $$

DROP FUNCTION IF EXISTS fn_validasi_username$$

CREATE FUNCTION fn_validasi_username(
    p_username VARCHAR(255)
)
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE v_valid BOOLEAN;
    
    -- Username harus minimal 3 karakter dan hanya huruf, angka, titik, underscore
    IF LENGTH(p_username) >= 3 
       AND p_username REGEXP '^[a-zA-Z0-9._]+$' THEN
        SET v_valid = TRUE;
    ELSE
        SET v_valid = FALSE;
    END IF;
    
    RETURN v_valid;
END$$

DELIMITER ;
