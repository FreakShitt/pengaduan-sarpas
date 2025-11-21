# Database Backup System

## Overview
Sistem backup database otomatis dan manual untuk aplikasi Pengaduan Sarpas.

## Features

### 1. **Automatic Backup** 
- ✅ Backup otomatis setiap hari pukul 02:00 WIB
- ✅ Menggunakan cron job di server
- ✅ Menyimpan log di `storage/logs/backup.log`
- ✅ Auto cleanup backup lama (>30 hari)

### 2. **Manual Backup**
- ✅ Backup sekali klik dari dashboard admin
- ✅ Akses via menu: **Admin → Backup**
- ✅ Format file: `backup_YYYY-MM-DD_HHMMSS.sql`

### 3. **Backup Management**
- ✅ Lihat semua file backup
- ✅ Download backup
- ✅ Hapus backup yang tidak diperlukan
- ✅ Informasi ukuran file dan tanggal

## Technical Details

### Command
```bash
php artisan backup:database
php artisan backup:database --name=custom_backup
```

### Files
- **Command**: `app/Console/Commands/BackupDatabase.php`
- **Controller**: `app/Http/Controllers/AdminController.php` (methods: backups, createBackup, downloadBackup, deleteBackup)
- **View**: `resources/views/admin/backups/index.blade.php`
- **Routes**: `routes/web.php` (admin.backups.*)
- **Cron**: Setup via `setup_backup_cron.sh`

### Storage
- **Location**: `storage/app/backups/`
- **Retention**: 30 days (auto cleanup)
- **Format**: SQL dump with stored procedures, triggers, and events

### Schedule (Cron)
```cron
0 2 * * * cd /var/www/pengaduan-sarpas && /usr/bin/php artisan backup:database >> /var/www/pengaduan-sarpas/storage/logs/backup.log 2>&1
```

## Usage

### Admin Dashboard
1. Login sebagai **Admin**
2. Klik menu **Backup** di navigation bar
3. Klik tombol **"BUAT BACKUP SEKARANG"** untuk backup manual
4. Daftar backup akan muncul dengan opsi:
   - **Download** - Unduh file backup
   - **Hapus** - Hapus backup yang tidak diperlukan

### Via CLI (Server)
```bash
# Manual backup
sudo -u www-data php artisan backup:database

# Custom name
sudo -u www-data php artisan backup:database --name=before_update

# Check cron status
sudo crontab -u www-data -l

# View backup log
tail -f storage/logs/backup.log
```

## Setup on New Server

1. **Clone repository**
2. **Pull latest code**
3. **Run setup script**:
```bash
sudo bash setup_backup_cron.sh
```

4. **Verify cron**:
```bash
sudo crontab -u www-data -l
```

5. **Test manual backup**:
```bash
sudo -u www-data php artisan backup:database
```

## Backup Content
- All tables with data
- Stored procedures (5 procedures)
- Functions (8 functions)
- Triggers (8 triggers)  
- Views (10 views)
- Events

## Restore Backup
```bash
# Via MySQL
mysql -u sarpas_user -p pengaduan-sarpas < storage/app/backups/backup_2025-11-21_105852.sql

# Via Laravel (if needed)
cd /var/www/pengaduan-sarpas
sudo -u www-data bash -c "mysql -u sarpas_user -pSarpas2024! pengaduan-sarpas < storage/app/backups/FILENAME.sql"
```

## Monitoring
- Check logs: `storage/logs/backup.log`
- Check files: `ls -lh storage/app/backups/`
- Check cron: `sudo crontab -u www-data -l`

## Notes
- Backup dijalankan sebagai user `www-data` (sama dengan PHP-FPM)
- File backup bisa besar jika data banyak
- Disarankan backup manual sebelum update besar
- Backup lama otomatis dihapus setelah 30 hari
