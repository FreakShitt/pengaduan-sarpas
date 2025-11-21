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
            $dumpCommand = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers --events %s',
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database)
            );

            // Execute backup and save to file
            $output = shell_exec($dumpCommand . ' 2>&1');

            if ($output === null) {
                $this->error('Backup failed: shell_exec returned null');
                return 1;
            }

            // Write output to file
            $written = file_put_contents($filepath, $output);

            if ($written === false) {
                $this->error('Failed to write backup file!');
                return 1;
            }

            // Check if output looks like an error
            if (stripos($output, 'error') !== false || stripos($output, 'failed') !== false) {
                $this->error('Backup may have failed!');
                $this->error('Output: ' . substr($output, 0, 500));
                
                // Don't return error if file was created
                if (!file_exists($filepath) || filesize($filepath) < 100) {
                    return 1;
                }
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
