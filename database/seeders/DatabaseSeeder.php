<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Airport;
use App\Models\FlightStatus;
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

        // 2. Airports
        Airport::firstOrCreate(['iata_code' => 'CGK'], [
            'airport_name' => 'Soekarno-Hatta International Airport',
            'city' => 'Jakarta',
            'country_code' => 'ID'
        ]);
        Airport::firstOrCreate(['iata_code' => 'DPS'], [
            'airport_name' => 'Ngurah Rai International Airport',
            'city' => 'Denpasar',
            'country_code' => 'ID'
        ]);
        Airport::firstOrCreate(['iata_code' => 'SIN'], [
            'airport_name' => 'Changi Airport',
            'city' => 'Singapore',
            'country_code' => 'SG'
        ]);
        Airport::firstOrCreate(['iata_code' => 'KUL'], [
            'airport_name' => 'Kuala Lumpur International Airport',
            'city' => 'Kuala Lumpur',
            'country_code' => 'MY'
        ]);

        // 3. Flight Statuses
        FlightStatus::firstOrCreate(['name' => 'Scheduled']);
        FlightStatus::firstOrCreate(['name' => 'Boarding']);
        FlightStatus::firstOrCreate(['name' => 'Departed']);
        FlightStatus::firstOrCreate(['name' => 'Arrived']);
        FlightStatus::firstOrCreate(['name' => 'Cancelled']);

        // 4. Airlines
        Airline::firstOrCreate(['airline_code' => 'GA'], [
            'airline_name' => 'Garuda Indonesia',
            'country_code' => 'ID'
        ]);
        Airline::firstOrCreate(['airline_code' => 'QZ'], [
            'airline_name' => 'AirAsia',
            'country_code' => 'MY'
        ]);

        // 5. Aircraft Manufacturers
        AircraftManufacturer::firstOrCreate(['name' => 'Boeing'], [
            'country_code' => 'US'
        ]);
        AircraftManufacturer::firstOrCreate(['name' => 'Airbus'], [
            'country_code' => 'FR'
        ]);

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

        // 7. Seats
        for ($i = 1; $i <= 10; $i++) {
            Seat::firstOrCreate([
                'aircraft_id' => $aircraftId,
                'seat_number' => $i . 'A'
            ], [
                'seat_class' => 'economy',
                'seat_type' => 'window',
                'is_active' => true
            ]);
        }

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
            'aircraft_instance_id' => $aircraftInstance->aircraft_instance_id,
            'flight_status_id' => 1
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
            FlightDataSeeder::class,
            AdminSeeder::class,
        ]);
    }
}