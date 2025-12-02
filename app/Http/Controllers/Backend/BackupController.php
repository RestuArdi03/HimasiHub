<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Create a new backup (database + attachments) and downloads it.
     */
    public function create()
    {
        if (! Gate::allows('access-backup')) {
            return back()->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $filename = 'HimasiHub-Backup-' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath  = storage_path("app/backups/$filename");

        // Ensure backup directory exists
        File::ensureDirectoryExists(dirname($zipPath));

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            Log::error('Failed to create zip archive for backup at ' . $zipPath);
            return back()->with('error', 'Gagal membuat file backup (zip).');
        }

        // 1. Dump database to a temporary file
        $dbFile = storage_path('app/backups/db-backup.sql');
        $this->dumpDatabase($dbFile);
        $zip->addFile($dbFile, 'db-backup.sql');

        // 2. Add public storage folder
        $storagePath = storage_path('app/public');
        if (File::isDirectory($storagePath)) {
            $this->addFolderToZip($storagePath, $zip, 'storage');
        }

        $zip->close();

        // Clean up temporary SQL dump
        File::delete($dbFile);

        Log::info('Backup created successfully: ' . $filename);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Restore database from a backup file.
     */
    public function restore(Request $request)
    {
        if (! Gate::allows('access-backup')) {
            return back()->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $request->validate([
            'backup_file' => 'required|file|mimes:zip',
        ]);

        try {
            $file = $request->file('backup_file');
            $zip  = new ZipArchive;

            if ($zip->open($file->getRealPath()) !== TRUE) {
                return back()->with('error', 'Gagal membuka file backup.');
            }

            Artisan::call('down'); // Put application into maintenance mode

            $extractPath = storage_path('app/restore-temp');
            File::ensureDirectoryExists($extractPath);
            $zip->extractTo($extractPath);
            $zip->close();

            // 1. Restore database
            $dbFile = $extractPath . '/db-backup.sql';
            if (file_exists($dbFile)) {
                $this->restoreDatabase($dbFile);
            }

            // 2. Restore public storage
            $restoredStoragePath = $extractPath . '/storage';
            if (is_dir($restoredStoragePath)) {
                $targetPath = storage_path('app/public');
                File::deleteDirectory($targetPath, true); // Clear old public storage, preserve the directory itself
                File::copyDirectory($restoredStoragePath, $targetPath); // Copy new ones
            }

            // Cleanup
            File::deleteDirectory($extractPath);

            Artisan::call('up'); // Bring application back online

            Log::info('Backup restored successfully.');
            return back()->with('success', 'Backup berhasil dipulihkan. Seluruh data telah diganti.');

        } catch (\Exception $e) {
            Artisan::call('up'); // Ensure application is back online if restore fails
            Log::error('Restore failed: ' . $e->getMessage());
            // Clean up temp directory if it exists
            if (isset($extractPath) && File::isDirectory($extractPath)) {
                File::deleteDirectory($extractPath);
            }
            return back()->with('error', 'Gagal memulihkan backup. Silakan cek log untuk detail.');
        }
    }

    private function dumpDatabase($outputFile)
    {
        $connection = config('database.connections.mysql');
        // Pastikan tidak ada password kosong yang menyebabkan error
        $password = $connection['password'] ? sprintf('--password=%s', escapeshellarg($connection['password'])) : '';
        $command = sprintf(
            'mysqldump --user=%s %s --host=%s %s > %s',
            escapeshellarg($connection['username']),
            $password,
            escapeshellarg($connection['host']),
            escapeshellarg($connection['database']),
            escapeshellarg($outputFile)
        );
        exec($command);
    }

    private function restoreDatabase($inputFile)
    {
        $connection = config('database.connections.mysql');
        // Pastikan tidak ada password kosong yang menyebabkan error
        $password = $connection['password'] ? sprintf('--password=%s', escapeshellarg($connection['password'])) : '';
        $command = sprintf(
            'mysql --user=%s %s --host=%s %s < %s',
            escapeshellarg($connection['username']),
            $password,
            escapeshellarg($connection['host']),
            escapeshellarg($connection['database']),
            escapeshellarg($inputFile)
        );
        exec($command);
    }

    private function addFolderToZip($folder, ZipArchive $zip, $zipFolder)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                $relativePath = $zipFolder . '/' . substr($filePath, strlen($folder) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
}