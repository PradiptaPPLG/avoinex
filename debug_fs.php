<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$flashSales = \App\Models\FlashSale::all()->toArray();
file_put_contents('debug_fs.txt', json_encode($flashSales, JSON_PRETTY_PRINT));
