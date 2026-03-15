<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Airport;
use App\Models\Airline;
use App\Models\AircraftManufacturer;
use App\Models\Aircraft;
use App\Models\Seat;
use App\Models\Schedule;
use App\Models\AircraftInstance;
use App\Models\FlightInstance;
use App\Models\FlightSeatPrice;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\AirportSeeder::class,
        ]);

        // 1. Countries
        Country::firstOrCreate(['country_code' => 'ID'], [
            'country_name' => 'Indonesia',
            'continent' => 'Asia'
        ]);
        Country::firstOrCreate(['country_code' => 'SG'], [
            'country_name' => 'Singapore',
            'continent' => 'Asia'
        ]);
        Country::firstOrCreate(['country_code' => 'MY'], [
            'country_name' => 'Malaysia',
            'continent' => 'Asia'
        ]);
        Country::firstOrCreate(['country_code' => 'US'], [
            'country_name' => 'United States',
            'continent' => 'North America'
        ]);
        Country::firstOrCreate(['country_code' => 'FR'], [
            'country_name' => 'France',
            'continent' => 'Europe'
        ]);

        // 2. Airports (Delegated to AirportSeeder)

        // 4. Airlines
        $this->call([
            \Database\Seeders\AirlineSeeder::class,
        ]);

        // 5. Aircraft Manufacturers
        $manufacturers = [
            ['name' => 'Boeing', 'country_code' => 'US', 'country_name' => 'United States', 'continent' => 'North America'],
            ['name' => 'Airbus', 'country_code' => 'FR', 'country_name' => 'France', 'continent' => 'Europe'],
            ['name' => 'Embraer', 'country_code' => 'BR', 'country_name' => 'Brazil', 'continent' => 'South America'],
            ['name' => 'Bombardier', 'country_code' => 'CA', 'country_name' => 'Canada', 'continent' => 'North America'],
            ['name' => 'ATR', 'country_code' => 'FR', 'country_name' => 'France', 'continent' => 'Europe'],
            ['name' => 'COMAC', 'country_code' => 'CN', 'country_name' => 'China', 'continent' => 'Asia'],
            ['name' => 'Dassault Aviation', 'country_code' => 'FR', 'country_name' => 'France', 'continent' => 'Europe'],
        ];

        foreach ($manufacturers as $m) {
            Country::firstOrCreate(['country_code' => $m['country_code']], [
                'country_name' => $m['country_name'],
                'continent' => $m['continent']
            ]);
            
            AircraftManufacturer::firstOrCreate(['name' => $m['name']], [
                'country_code' => $m['country_code']
            ]);
        }

        // 6. Aircrafts
        $aircraft = Aircraft::first();
        if (!$aircraft) {
            $aircraft = Aircraft::create([
                'aircraft_model' => 'Boeing 737-800',
                'manufacturer_id' => 1,
                'total_seats' => 180,
                'economy_seats' => 162,
                'business_seats' => 18
            ]);
        }

        // Pastikan aircraft_id ada
        $aircraftId = $aircraft->aircraft_id;

        // 7. Generate Seats via Seeder
        $this->call([
            \Database\Seeders\SeatGeneratorSeeder::class,
        ]);

        // 8. Schedules
        $schedule = Schedule::firstOrCreate([
            'flight_number' => 'GA-201',
            'departure_time_gmt' => '08:00:00'
        ], [
            'airline_code' => 'GA',
            'origin_iata_code' => 'CGK',
            'destination_iata_code' => 'DPS',
            'arrival_time_gmt' => '10:30:00',
            'duration_minutes' => 150,
            'base_price_usd' => 150.00,
            'effective_from' => now(),
            'effective_to' => now()->addYear()
        ]);

        // 9. Aircraft Instance
        $aircraftInstance = AircraftInstance::first();
        if (!$aircraftInstance) {
            $aircraftInstance = AircraftInstance::create([
                'registration_number' => 'PK-GAA',
                'aircraft_id' => $aircraftId
            ]);
        }

        // 10. Flight Instance
        $flightInstance = FlightInstance::firstOrCreate([
            'schedule_id' => $schedule->schedule_id,
            'flight_date' => now()->addDay()
        ], [
            'aircraft_instance_id' => $aircraftInstance->aircraft_instance_id
        ]);

        // 11. Flight Seat Prices
        $seats = Seat::where('aircraft_id', $aircraft->aircraft_id)->get();
        foreach ($seats as $seat) {
            FlightSeatPrice::firstOrCreate([
                'flight_instance_id' => $flightInstance->flight_instance_id,
                'seat_id' => $seat->seat_id
            ], [
                'price_usd' => 150.00,
                'is_available' => true
            ]);
        }

        $this->command->info('✅ Database seeded successfully!');

        $this->call([
            \Database\Seeders\AdminSeeder::class,
            \Database\Seeders\FlightDataSeeder::class,
        ]);
    }
}