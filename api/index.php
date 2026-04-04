<?php

// Force Debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Manually ensure autoload exists
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
    die("Error: vendor/autoload.php not found. Did composer install run correctly?");
}
require $autoload;

// 2. Prepare Storage in /tmp
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

// 3. Set Overrides
putenv('APP_DEBUG=true');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('SESSION_DRIVER=cookie');
putenv('LOG_CHANNEL=stderr');

// 4. Boostrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Handle Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
