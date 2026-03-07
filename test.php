<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $flights = App\Models\FlightInstance::with(['aircraftInstance.aircraft', 'schedule'])->get();

    // We can instantiate FlightController to cleanly regenerate seats
    $controller = app()->make(App\Http\Controllers\Admin\FlightController::class);

    // PHP doesn't let us easily call a private method without reflection,
    // so we'll just write the logic here quickly:

    foreach ($flights as $flight) {
        if ($flight->schedule->flight_number == 'GA-509') {
            $aircraftInstance = App\Models\AircraftInstance::with('aircraft')->find($flight->aircraft_instance_id);
            if (!$aircraftInstance || !$aircraftInstance->aircraft)
                continue;
            $aircraft = $aircraftInstance->aircraft;

            // Delete old unbooked seat prices
            App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
                ->whereDoesntHave('bookingSeats')
                ->forceDelete();

            $seats = App\Models\Seat::where('aircraft_id', $aircraft->aircraft_id)
                ->where('is_active', 1)
                ->get();

            $added = 0;
            foreach ($seats as $seat) {
                // Skip if already exists
                $exists = App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
                    ->where('seat_id', $seat->seat_id)
                    ->exists();
                if ($exists)
                    continue;

                $price = $seat->seat_class == 'business' ? 250.00 : 150.00;
                App\Models\FlightSeatPrice::create([
                    'flight_instance_id' => $flight->flight_instance_id,
                    'seat_id' => $seat->seat_id,
                    'price_usd' => $price,
                    'is_available' => true,
                ]);
                $added++;
            }
            echo "Flight {$flight->flight_instance_id}: Added {$added} seats to match aircraft layout.\n";
        }
    }
}
catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}
