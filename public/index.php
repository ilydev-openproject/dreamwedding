<?php

/**
 * 🛠 DIAGNOSTIC MODE: Vercel Laravel Session
 */

// Force text mode to see what's happening
header('Content-Type: text/plain');

echo "--- VERCEL DIAGNOSTIC START ---\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Working Directory: " . getcwd() . "\n";
echo "App Key Exists: " . (getenv('APP_KEY') ?: 'NO (Please check Vercel Env Vars)') . "\n";

// Ensure storage folders exist in /tmp
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        if (mkdir($folder, 0777, true)) {
            echo "Created: $folder\n";
        }
    }
}

// Force Serverless Overrides
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('SESSION_DRIVER=cookie');
putenv('APP_DEBUG=true');

echo "--- LOADING LARAVEL ---\n";

// Register the Composer autoloader...
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die("CRITICAL ERROR: vendor/autoload.php not found. Vercel builder failed to run composer.");
}
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../bootstrap/app.php';

echo "Laravel Application Booted.\n";
echo "--- DIAGNOSTIC END ---\n";

// Now try to handle request
$app->handleRequest(Illuminate\Http\Request::capture());
