<?php

// Ensure storage folders exist in /tmp for serverless environment
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
}

// Set environment variables for serverless compatibility
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

require __DIR__ . '/../public/index.php';
