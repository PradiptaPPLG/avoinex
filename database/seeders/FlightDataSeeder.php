<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlightInstance;
use App\Models\Schedule;
use App\Models\Airport;
use App\Models\FlightSeatPrice;
use App\Models\Seat;
use Carbon\Carbon;

class FlightDataSeeder extends Seeder
{
    public function run()
    {
        // Create demo flights for the next 7 days
        $schedules = Schedule::all();
        $aircraftInstanceId = 1; // PK-GAA
        
        $today = Carbon::today();
        
        foreach ($schedules as $schedule) {
            for ($i = 0; $i < 7; $i++) {
                $flightDate = $today->copy()->addDays($i);
                
                // Create flight instance
                $flight = FlightInstance::create([
                    'schedule_id' => $schedule->schedule_id,
                    'aircraft_instance_id' => $aircraftInstanceId,
                    'flight_date' => $flightDate,
                    'flight_status_id' => 1, // Scheduled
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Create seat prices for this flight
                $seats = Seat::where('aircraft_id', 1)->get();
                foreach ($seats as $seat) {
                    $price = $seat->seat_class == 'business' ? 250.00 : 150.00;
                    
                    FlightSeatPrice::create([
                        'flight_instance_id' => $flight->flight_instance_id,
                        'seat_id' => $seat->seat_id,
                        'price_usd' => $price,
                        'currency' => 'USD',
                        'is_available' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
        
        $this->command->info('Demo flight data created successfully!');
    }
}