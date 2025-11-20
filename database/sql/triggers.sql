-- ============================================
-- TRIGGERS untuk Sistem Pengaduan Sarpas
-- ============================================

USE pengaduan_sarpas;

-- 1. Trigger: Log Perubahan Status Pengaduan (AFTER UPDATE)
DROP TABLE IF EXISTS pengaduan_status_log;

CREATE TABLE pengaduan_status_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengaduan_id BIGINT UNSIGNED NOT NULL,
    status_lama ENUM('diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'),
    status_baru ENUM('diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'),
    changed_by BIGINT UNSIGNED,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pengaduan_id) REFERENCES pengaduans(id) ON DELETE CASCADE
) ENGINE=InnoDB;

DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_update_status_pengaduan$$

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
END$$

DELIMITER ;

-- 2. Trigger: Validasi Sebelum Insert Pengaduan (BEFORE INSERT)
DELIMITER $$

DROP TRIGGER IF EXISTS trg_before_insert_pengaduan$$

CREATE TRIGGER trg_before_insert_pengaduan
BEFORE INSERT ON pengaduans
FOR EACH ROW
BEGIN
    -- Validasi detail laporan minimal 10 karakter
    IF LENGTH(NEW.detail_laporan) < 10 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Detail laporan harus minimal 10 karakter';
    END IF;
    
    -- Set default status jika kosong
    IF NEW.status IS NULL THEN
        SET NEW.status = 'diajukan';
    END IF;
    
    -- Set timestamps
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
    
    IF NEW.updated_at IS NULL THEN
        SET NEW.updated_at = NOW();
    END IF;
END$$

DELIMITER ;

-- 3. Trigger: Auto Update timestamp updated_at (BEFORE UPDATE)
DELIMITER $$

DROP TRIGGER IF EXISTS trg_before_update_pengaduan$$

CREATE TRIGGER trg_before_update_pengaduan
BEFORE UPDATE ON pengaduans
FOR EACH ROW
BEGIN
    SET NEW.updated_at = NOW();
END$$

DELIMITER ;

-- 4. Trigger: Log Penghapusan Pengaduan (AFTER DELETE)
DROP TABLE IF EXISTS pengaduan_deleted_log;

CREATE TABLE pengaduan_deleted_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengaduan_id BIGINT UNSIGNED,
    user_id BIGINT UNSIGNED,
    lokasi VARCHAR(255),
    barang VARCHAR(255),
    status VARCHAR(50),
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_delete_pengaduan$$

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
END$$

DELIMITER ;

-- 5. Trigger: Validasi Item Request (BEFORE INSERT)
DELIMITER $$

DROP TRIGGER IF EXISTS trg_before_insert_item_request$$

CREATE TRIGGER trg_before_insert_item_request
BEFORE INSERT ON item_requests
FOR EACH ROW
BEGIN
    -- Validasi nama barang tidak boleh kosong
    IF LENGTH(TRIM(NEW.nama_barang)) = 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Nama barang tidak boleh kosong';
    END IF;
    
    -- Set default status
    IF NEW.status IS NULL THEN
        SET NEW.status = 'pending';
    END IF;
    
    -- Set timestamps
    IF NEW.created_at IS NULL THEN
        SET NEW.created_at = NOW();
    END IF;
    
    IF NEW.updated_at IS NULL THEN
        SET NEW.updated_at = NOW();
    END IF;
END$$

DELIMITER ;

-- 6. Trigger: Counter Pengaduan per User (AFTER INSERT)
DROP TABLE IF EXISTS user_pengaduan_counter;

CREATE TABLE user_pengaduan_counter (
    user_id BIGINT UNSIGNED PRIMARY KEY,
    total_pengaduan INT DEFAULT 0,
    last_pengaduan_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB;

DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_insert_pengaduan_counter$$

CREATE TRIGGER trg_after_insert_pengaduan_counter
AFTER INSERT ON pengaduans
FOR EACH ROW
BEGIN
    INSERT INTO user_pengaduan_counter (user_id, total_pengaduan, last_pengaduan_at)
    VALUES (NEW.user_id, 1, NOW())
    ON DUPLICATE KEY UPDATE 
        total_pengaduan = total_pengaduan + 1,
        last_pengaduan_at = NOW();
END$$

DELIMITER ;

-- 7. Trigger: Decrement Counter saat Pengaduan Dihapus (AFTER DELETE)
DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_delete_pengaduan_counter$$

CREATE TRIGGER trg_after_delete_pengaduan_counter
AFTER DELETE ON pengaduans
FOR EACH ROW
BEGIN
    UPDATE user_pengaduan_counter
    SET total_pengaduan = total_pengaduan - 1
    WHERE user_id = OLD.user_id;
END$$

DELIMITER ;

-- 8. Trigger: Validasi User Role sebelum Insert User (BEFORE INSERT)
DELIMITER $$

DROP TRIGGER IF EXISTS trg_before_insert_user$$

CREATE TRIGGER trg_before_insert_user
BEFORE INSERT ON user
FOR EACH ROW
BEGIN
    -- Validasi role harus salah satu dari: siswa, petugas, admin
    IF NEW.role NOT IN ('siswa', 'petugas', 'admin') THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Role harus salah satu dari: siswa, petugas, admin';
    END IF;
    
    -- Validasi username minimal 3 karakter
    IF LENGTH(NEW.username) < 3 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Username harus minimal 3 karakter';
    END IF;
END$$

DELIMITER ;
