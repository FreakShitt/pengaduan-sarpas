<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database {--name=}';
    protected $description = 'Backup database to storage/app/backups';

    public function handle()
    {
        try {
            $this->info('Starting database backup...');
            
            // Create backups directory if not exists
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // Generate filename
            $filename = $this->option('name') 
                ? $this->option('name') . '.sql'
                : 'backup_' . Carbon::now()->format('Y-m-d_His') . '.sql';
            
            $filepath = $backupPath . '/' . $filename;

            // Get database credentials
            $host = config('database.connections.mysql.host');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $port = config('database.connections.mysql.port', 3306);

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers --events %s',
                $host,
                $port,
                $username,
                $password,
                $database
            );

            // Execute backup
            $fullCommand = $command . ' > ' . $filepath . ' 2>&1';
            exec($fullCommand, $output, $returnVar);

            if ($returnVar !== 0) {
                $this->error('Backup failed!');
                $this->error('Output: ' . implode("\n", $output));
                return 1;
            }

            // Check if file was created and has content
            if (!file_exists($filepath) || filesize($filepath) === 0) {
                $this->error('Backup file is empty or was not created!');
                return 1;
            }

            $filesize = $this->formatBytes(filesize($filepath));
            $this->info("Backup completed successfully!");
            $this->info("File: {$filename}");
            $this->info("Size: {$filesize}");
            $this->info("Path: {$filepath}");

            // Clean old backups (keep last 30 days)
            $this->cleanOldBackups();

            return 0;

        } catch (\Exception $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            return 1;
        }
    }

    private function cleanOldBackups()
    {
        $backupPath = storage_path('app/backups');
        $files = glob($backupPath . '/backup_*.sql');
        
        foreach ($files as $file) {
            if (filemtime($file) < strtotime('-30 days')) {
                unlink($file);
                $this->info('Deleted old backup: ' . basename($file));
            }
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
