ALTER TABLE pengaduans MODIFY status ENUM('diajukan','diproses','disetujui','ditolak','selesai') NOT NULL DEFAULT 'diajukan';
