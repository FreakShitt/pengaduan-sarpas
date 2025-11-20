-- ============================================
-- STORED PROCEDURES untuk Sistem Pengaduan Sarpas
-- ============================================

USE pengaduan_sarpas;

-- 1. Stored Procedure: Tambah Pengaduan Baru
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_tambah_pengaduan$$

CREATE PROCEDURE sp_tambah_pengaduan(
    IN p_user_id BIGINT,
    IN p_lokasi VARCHAR(255),
    IN p_barang VARCHAR(255),
    IN p_detail_laporan TEXT,
    IN p_is_temporary_item TINYINT,
    OUT p_pengaduan_id BIGINT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_pengaduan_id = 0;
    END;
    
    START TRANSACTION;
    
    INSERT INTO pengaduans (
        user_id, 
        lokasi, 
        barang, 
        detail_laporan, 
        is_temporary_item,
        status, 
        created_at, 
        updated_at
    )
    VALUES (
        p_user_id,
        p_lokasi,
        p_barang,
        p_detail_laporan,
        p_is_temporary_item,
        'diajukan',
        NOW(),
        NOW()
    );
    
    SET p_pengaduan_id = LAST_INSERT_ID();
    
    COMMIT;
END$$

DELIMITER ;

-- 2. Stored Procedure: Update Status Pengaduan
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_update_status_pengaduan$$

CREATE PROCEDURE sp_update_status_pengaduan(
    IN p_pengaduan_id BIGINT,
    IN p_status ENUM('diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'),
    IN p_petugas_id BIGINT,
    IN p_catatan_petugas TEXT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Gagal update status pengaduan';
    END;
    
    START TRANSACTION;
    
    UPDATE pengaduans 
    SET 
        status = p_status,
        petugas_id = p_petugas_id,
        catatan_petugas = p_catatan_petugas,
        updated_at = NOW()
    WHERE id = p_pengaduan_id;
    
    COMMIT;
END$$

DELIMITER ;

-- 3. Stored Procedure: Approve Item Request
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_approve_item_request$$

CREATE PROCEDURE sp_approve_item_request(
    IN p_item_request_id BIGINT,
    IN p_reviewed_by BIGINT,
    IN p_review_note TEXT
)
BEGIN
    DECLARE v_nama_lokasi VARCHAR(255);
    DECLARE v_nama_barang VARCHAR(255);
    DECLARE v_deskripsi TEXT;
    DECLARE v_lokasi_exists INT;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Gagal approve item request';
    END;
    
    START TRANSACTION;
    
    -- Get item request data
    SELECT nama_lokasi, nama_barang, deskripsi
    INTO v_nama_lokasi, v_nama_barang, v_deskripsi
    FROM item_requests
    WHERE id = p_item_request_id;
    
    -- Check if lokasi exists
    SELECT COUNT(*) INTO v_lokasi_exists
    FROM lokasi
    WHERE nama_lokasi = v_nama_lokasi;
    
    -- Create lokasi if not exists
    IF v_lokasi_exists = 0 THEN
        INSERT INTO lokasi (nama_lokasi, deskripsi, aktif, created_at, updated_at)
        VALUES (v_nama_lokasi, 'Lokasi dari item request', 1, NOW(), NOW());
    END IF;
    
    -- Create barang
    INSERT INTO barang (nama_lokasi, nama_barang, deskripsi, aktif, created_at, updated_at)
    VALUES (v_nama_lokasi, v_nama_barang, v_deskripsi, 1, NOW(), NOW());
    
    -- Update item request status
    UPDATE item_requests
    SET 
        status = 'approved',
        reviewed_by = p_reviewed_by,
        review_note = p_review_note,
        updated_at = NOW()
    WHERE id = p_item_request_id;
    
    COMMIT;
END$$

DELIMITER ;

-- 4. Stored Procedure: Get Statistik Pengaduan
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_get_statistik_pengaduan$$

CREATE PROCEDURE sp_get_statistik_pengaduan(
    OUT p_total INT,
    OUT p_diajukan INT,
    OUT p_disetujui INT,
    OUT p_ditolak INT,
    OUT p_selesai INT
)
BEGIN
    SELECT COUNT(*) INTO p_total FROM pengaduans;
    SELECT COUNT(*) INTO p_diajukan FROM pengaduans WHERE status = 'diajukan';
    SELECT COUNT(*) INTO p_disetujui FROM pengaduans WHERE status = 'disetujui';
    SELECT COUNT(*) INTO p_ditolak FROM pengaduans WHERE status = 'ditolak';
    SELECT COUNT(*) INTO p_selesai FROM pengaduans WHERE status = 'selesai';
END$$

DELIMITER ;

-- 5. Stored Procedure: Get Pengaduan by User
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_get_pengaduan_by_user$$

CREATE PROCEDURE sp_get_pengaduan_by_user(
    IN p_user_id BIGINT
)
BEGIN
    SELECT 
        p.id,
        p.lokasi,
        p.barang,
        p.detail_laporan,
        p.status,
        p.catatan_petugas,
        p.created_at,
        p.updated_at,
        u.nama_pengguna as user_name,
        pt.nama_pengguna as petugas_name
    FROM pengaduans p
    LEFT JOIN user u ON p.user_id = u.id
    LEFT JOIN user pt ON p.petugas_id = pt.id
    WHERE p.user_id = p_user_id
    ORDER BY p.created_at DESC;
END$$

DELIMITER ;
