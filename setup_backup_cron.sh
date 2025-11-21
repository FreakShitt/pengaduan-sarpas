#!/bin/bash

# Setup automatic database backup cron job for Laravel application
# This script will configure daily backups at 2 AM

echo "Setting up automatic database backup..."

# Add cron job for www-data user (Laravel runs as www-data)
(crontab -u www-data -l 2>/dev/null; echo "0 2 * * * cd /var/www/pengaduan-sarpas && /usr/bin/php artisan backup:database >> /var/www/pengaduan-sarpas/storage/logs/backup.log 2>&1") | crontab -u www-data -

echo "Cron job installed successfully!"
echo ""
echo "Backup schedule: Daily at 02:00 AM"
echo "Backup location: /var/www/pengaduan-sarpas/storage/app/backups/"
echo "Log file: /var/www/pengaduan-sarpas/storage/logs/backup.log"
echo ""
echo "Current crontab for www-data user:"
crontab -u www-data -l
