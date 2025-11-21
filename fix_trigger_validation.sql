-- Drop trigger yang terlalu strict
DROP TRIGGER IF EXISTS trg_before_update_pengaduan;

-- Buat trigger baru yang hanya update timestamp, tanpa validasi strict
DELIMITER $$

CREATE TRIGGER trg_before_update_pengaduan
BEFORE UPDATE ON pengaduans
FOR EACH ROW
BEGIN
    -- Auto update timestamp saja
    SET NEW.updated_at = CURRENT_TIMESTAMP;
END$$

DELIMITER ;
