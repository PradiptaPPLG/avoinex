<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlightInstance;
use App\Models\Schedule;
use App\Models\FlightSeatPrice;
use App\Models\Seat;
use App\Models\AircraftInstance;
use Carbon\Carbon;

class FlightDataSeeder extends Seeder
{
    public function run()
    {
        $schedules = Schedule::all();
        $today = Carbon::today();

        foreach ($schedules as $schedule) {

            // Ambil aircraft instance yang terkait schedule
            $aircraftInstance = AircraftInstance::first();
            if (!$aircraftInstance) {
                continue;
            }

            for ($i = 0; $i < 7; $i++) {

                $flightDate = $today->copy()->addDays($i);

                // FIX: Prevent duplicate using firstOrCreate
                // when using soft deletes, search among trashed as well so
                // we can bring back a hidden flight instead of creating a
                // duplicate record
                $flight = FlightInstance::withTrashed()->firstOrCreate(
                [
                    'schedule_id' => $schedule->schedule_id,
                    'flight_date' => $flightDate,
                ],
                [
                    'aircraft_instance_id' => $aircraftInstance->aircraft_instance_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
                );

                if ($flight->trashed()) {
                    $flight->restore();
                }

                // Ambil aircraft_id dari aircraft instance
                $aircraftId = $aircraftInstance->aircraft_id;

                $seats = Seat::where('aircraft_id', $aircraftId)->get();

                foreach ($seats as $seat) {

                    $price = $seat->seat_class == 'business' ? 250.00 : 150.00;

                    // FIX: Prevent duplicate seat price
                    $seatPrice = FlightSeatPrice::withTrashed()->firstOrCreate(
                    [
                        'flight_instance_id' => $flight->flight_instance_id,
                        'seat_id' => $seat->seat_id,
                    ],
                    [
                        'price_usd' => $price,
                        'currency' => 'USD',
                        'is_available' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                    );

                    if ($seatPrice->trashed()) {
                        $seatPrice->restore();
                    }
                }
            }
        }

        $this->command->info('Demo flight data created successfully!');
    }
}
