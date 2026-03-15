<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fs = App\Models\FlashSale::with([
    'flightInstance.schedule.originAirport',
    'flightInstance.schedule.destinationAirport',
    'flightInstance.schedule.airline'
])->active()->get();

file_put_contents('test_output.json', json_encode($fs->toArray(), JSON_PRETTY_PRINT));