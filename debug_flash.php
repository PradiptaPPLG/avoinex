<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\FlashSale;
use App\Models\FlightInstance;

$out = "";

$out .= "=== FLASH SALES ===\n";
$sales = FlashSale::active()->get();
foreach ($sales as $s) {
    $out .= "id={$s->id} fid={$s->flight_id} type={$s->discount_type} val={$s->discount_value} sold={$s->seats_sold}/{$s->max_seats}\n";
}

$out .= "\n=== HOME FLIGHTS ===\n";
$flights = FlightInstance::with(['flashSale','schedule.originAirport','schedule.destinationAirport'])
    ->where('flight_date', '>=', now()->toDateString())
    ->where('is_active', true)
    ->orderBy('flight_date')
    ->take(10)
    ->get();

foreach ($flights as $f) {
    $orig = $f->schedule->originAirport->iata_code ?? '?';
    $dest = $f->schedule->destinationAirport->iata_code ?? '?';
    $activeFS = $f->flashSale()->active()->first();
    $status = $activeFS ? "YES id={$activeFS->id}" : "NO";
    $out .= "fid={$f->flight_instance_id} {$orig}-{$dest} flash={$status}\n";
}

file_put_contents(__DIR__ . '/debug_output.txt', $out);
echo "Done. Check debug_output.txt\n";
