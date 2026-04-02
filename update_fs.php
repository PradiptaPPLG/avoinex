<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\FlashSale::where('id', 3)->update(['end_time' => now()->addDays(5)]);
\App\Models\FlashSale::where('id', 4)->update(['end_time' => now()->addDays(5)]);
\App\Models\FlashSale::where('id', 5)->update(['end_time' => now()->addDays(5)]);

echo "Updated Flash Sales to be active in the future.\n";
