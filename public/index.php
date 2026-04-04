<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Storage setup for Vercel Serverless
if (isset($_SERVER['VERCEL_URL'])) {
    $storageFolders = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
    ];
    foreach ($storageFolders as $folder) {
        if (!is_dir($folder)) mkdir($folder, 0777, true);
    }

    // Set persistence for serverless session/view
    putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
    putenv('SESSION_DRIVER=cookie');
    putenv('LOG_CHANNEL=stderr');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// If APP_KEY is still missing from getenv(), try to inject it from $_SERVER if Vercel provided it
if (!getenv('APP_KEY') && isset($_SERVER['APP_KEY'])) {
    putenv("APP_KEY=" . $_SERVER['APP_KEY']);
}

$app->handleRequest(Request::capture());
