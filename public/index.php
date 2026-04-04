<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Ensure storage folders exist in /tmp for Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    if (!getenv('APP_KEY') && !isset($_ENV['APP_KEY'])) {
        die("Error: APP_KEY is not defined in Vercel Environment Variables. Please check your Project Settings.");
    }
    $storageFolders = ['/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions', '/tmp/storage/logs'];
    foreach ($storageFolders as $folder) { if (!is_dir($folder)) mkdir($folder, 0777, true); }
    putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
    putenv('SESSION_DRIVER=cookie');
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
