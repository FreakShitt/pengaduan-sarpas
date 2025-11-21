-- Update pengaduan_status_log ENUM untuk mendukung 'diproses'
ALTER TABLE pengaduan_status_log MODIFY status_lama ENUM('diajukan','diproses','disetujui','ditolak','selesai') NULL;
ALTER TABLE pengaduan_status_log MODIFY status_baru ENUM('diajukan','diproses','disetujui','ditolak','selesai') NOT NULL;

-- Update trigger untuk mendukung 'diproses'
DROP TRIGGER IF EXISTS trg_before_update_pengaduan;

DELIMITER $$

CREATE TRIGGER trg_before_update_pengaduan
BEFORE UPDATE ON pengaduans
FOR EACH ROW
BEGIN
    -- Auto update timestamp
    SET NEW.updated_at = CURRENT_TIMESTAMP;
    
    -- Validasi status transition (allow diproses)
    IF OLD.status = 'selesai' AND NEW.status != 'selesai' THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Tidak dapat mengubah status pengaduan yang sudah selesai';
    END IF;
END$$

DELIMITER ;
