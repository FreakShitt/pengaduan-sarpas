SELECT COLUMN_TYPE FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'pengaduan-sarpas' 
AND TABLE_NAME = 'pengaduans' 
AND COLUMN_NAME = 'status';
