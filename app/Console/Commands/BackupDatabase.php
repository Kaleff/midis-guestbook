<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backupdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to a file';

    /**
     * Execute the console command.
     */
     public function handle()
    {
        $this->info('Starting database backup...');

        // Get database configuration
        $dbName = Config::get('database.connections.pgsql.database');
        $dbUser = Config::get('database.connections.pgsql.username');
        $dbPassword = Config::get('database.connections.pgsql.password');
        $dbHost = Config::get('database.connections.pgsql.host');
        $dbPort = Config::get('database.connections.pgsql.port', '5432');

        // Create backup directory if it doesn't exist
        $backupPath = storage_path('app/backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Generate backup filename with timestamp
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $filename = "{$dbName}_{$timestamp}.sql";
        $filePath = "{$backupPath}/{$filename}";

        // Set up environment variables for pg_dump
        $env = [
            'PGPASSWORD' => $dbPassword,
        ];

        // Build pg_dump command
        $command = [
            'pg_dump',
            '--host=' . $dbHost,
            '--port=' . $dbPort,
            '--username=' . $dbUser,
            '--format=c', // Custom format (compressed)
            '--file=' . $filePath,
            $dbName
        ];

        // Execute the backup process
        $process = new Process($command, null, $env);
        $process->setTimeout(3600); // 1 hour timeout

        try {
            $this->info('Executing backup command...');
            $process->mustRun();
            $this->info("Database backup completed successfully: {$filename}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Database backup failed: " . $e->getMessage());
            return 1;
        }
    }
}
