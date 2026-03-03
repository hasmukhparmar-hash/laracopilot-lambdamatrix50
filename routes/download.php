<?php
/**
 * Add these routes to your routes/web.php for browser-based download
 * Copy and paste the Route::get lines below into your routes/web.php
 */

/*

Route::get('/download-project', function () {
    if (!extension_loaded('zip')) {
        return response('ZIP extension not available on this server.', 500);
    }

    $projectName = 'clinic-society-management';
    $zipFileName = $projectName . '-' . date('Ymd-His') . '.zip';
    $outputPath  = storage_path('app/' . $zipFileName);

    $excludeFolders = ['vendor', 'node_modules', '.git', 'storage/logs', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'bootstrap/cache'];
    $excludeFiles   = ['.env', 'create-zip.php'];

    $zip      = new ZipArchive();
    $rootPath = base_path();

    if ($zip->open($outputPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return response('Cannot create ZIP file.', 500);
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if (!$file->isFile()) continue;
        $filePath     = $file->getRealPath();
        $relativePath = str_replace('\\', '/', substr($filePath, strlen($rootPath) + 1));

        $skip = false;
        foreach ($excludeFiles as $ef) {
            if (basename($relativePath) === $ef) { $skip = true; break; }
        }
        if ($skip) continue;

        foreach ($excludeFolders as $ef) {
            if (strpos($relativePath, $ef . '/') === 0) { $skip = true; break; }
        }
        if ($skip) continue;

        $zip->addFile($filePath, $projectName . '/' . $relativePath);
    }

    if (file_exists(base_path('.env.example'))) {
        $zip->addFile(base_path('.env.example'), $projectName . '/.env');
    }

    $zip->close();

    return response()->download($outputPath, $zipFileName, [
        'Content-Type' => 'application/zip',
    ])->deleteFileAfterSend(true);
});

*/