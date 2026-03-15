<?php
$heroFlashSales = App\Models\FlashSale::with([
    'flightInstance.schedule.originAirport',
    'flightInstance.schedule.destinationAirport',
    'flightInstance.schedule.airline'
])->active()->get();

dump("Count: " . $heroFlashSales->count());
foreach($heroFlashSales as $sale) {
    dump("ID: " . $sale->id);
    dump("FlightInstance: " . ($sale->flightInstance !== null ? 'OK' : 'NULL'));
    if ($sale->flightInstance) {
        dump("Schedule: " . ($sale->flightInstance->schedule !== null ? 'OK' : 'NULL'));
    }
}
