<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\AircraftManufacturer;
use App\Models\Seat;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    public function index()
    {
        $aircraft = Aircraft::with('manufacturer')->paginate(20);
        return view('admin.aircraft.index', compact('aircraft'));
    }

    public function create()
    {
        $manufacturers = AircraftManufacturer::all();
        return view('admin.aircraft.create', compact('manufacturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|unique:aircrafts',
            'model' => 'required',
            'manufacturer' => 'required',
            'seat_columns' => 'required|integer|min:2|max:12',
            'seat_rows' => 'required|integer|min:5|max:80',
            'business_rows' => 'required|integer|min:0|max:20',
            'preferred_zone_enabled' => 'nullable|boolean',
            'preferred_zone_start_row' => 'nullable|integer|min:1',
            'preferred_zone_end_row' => 'nullable|integer|min:1',
        ]);

        $totalSeats = $validated['seat_columns'] * $validated['seat_rows'];

        $aircraft = Aircraft::create([
            'registration_number' => $validated['registration_number'],
            'aircraft_model' => $validated['model'],
            'manufacturer_id' => $validated['manufacturer'],
            'seat_columns' => $validated['seat_columns'],
            'seat_rows' => $validated['seat_rows'],
            'total_seats' => $totalSeats,
            'business_rows' => $validated['business_rows'],
            'business_seats' => $validated['seat_columns'] * $validated['business_rows'],
            'preferred_zone_enabled' => $request->boolean('preferred_zone_enabled'),
            'preferred_zone_start_row' => $validated['preferred_zone_start_row'] ?? null,
            'preferred_zone_end_row' => $validated['preferred_zone_end_row'] ?? null,
        ]);

        // Calculate economy seats
        $economyStartRow = $aircraft->economy_start_row;
        $economyRows = $validated['seat_rows'] - $economyStartRow + 1;
        $aircraft->update(['economy_seats' => $validated['seat_columns'] * max(0, $economyRows)]);

        // Auto-create an aircraft instance so it can be immediately assigned to flights
        \App\Models\AircraftInstance::firstOrCreate([
            'aircraft_id' => $aircraft->aircraft_id,
            'registration_number' => $aircraft->registration_number,
        ]);

        // Auto-generate seat records
        $this->generateSeats($aircraft);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft created successfully with ' . $totalSeats . ' seats generated.');
    }

    public function edit($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        $manufacturers = AircraftManufacturer::all();
        return view('admin.aircraft.edit', compact('aircraft', 'manufacturers'));
    }

    public function update(Request $request, $id)
    {
        $aircraft = Aircraft::findOrFail($id);

        $validated = $request->validate([
            'registration_number' => 'required|unique:aircrafts,registration_number,' . $id . ',aircraft_id',
            'model' => 'required',
            'manufacturer' => 'required',
            'seat_columns' => 'required|integer|min:2|max:12',
            'seat_rows' => 'required|integer|min:5|max:80',
            'business_rows' => 'required|integer|min:0|max:20',
            'preferred_zone_enabled' => 'nullable|boolean',
            'preferred_zone_start_row' => 'nullable|integer|min:1',
            'preferred_zone_end_row' => 'nullable|integer|min:1',
        ]);

        $totalSeats = $validated['seat_columns'] * $validated['seat_rows'];

        $aircraft->update([
            'registration_number' => $validated['registration_number'],
            'aircraft_model' => $validated['model'],
            'manufacturer_id' => $validated['manufacturer'],
            'seat_columns' => $validated['seat_columns'],
            'seat_rows' => $validated['seat_rows'],
            'total_seats' => $totalSeats,
            'business_rows' => $validated['business_rows'],
            'business_seats' => $validated['seat_columns'] * $validated['business_rows'],
            'preferred_zone_enabled' => $request->boolean('preferred_zone_enabled'),
            'preferred_zone_start_row' => $validated['preferred_zone_start_row'] ?? null,
            'preferred_zone_end_row' => $validated['preferred_zone_end_row'] ?? null,
        ]);

        // Calculate economy seats
        $economyStartRow = $aircraft->economy_start_row;
        $economyRows = $validated['seat_rows'] - $economyStartRow + 1;
        $aircraft->update(['economy_seats' => $validated['seat_columns'] * max(0, $economyRows)]);

        // Ensure an aircraft instance exists and is updated
        \App\Models\AircraftInstance::updateOrCreate(
        ['aircraft_id' => $aircraft->aircraft_id],
        ['registration_number' => $aircraft->registration_number]
        );

        // Re-generate seat records
        $this->generateSeats($aircraft);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft updated successfully.');
    }

    public function destroy($id)
    {
        Aircraft::findOrFail($id)->delete();

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft deleted successfully');
    }

    /**
     * Auto-generate Seat records for an aircraft based on its configuration.
     */
    private function generateSeats(Aircraft $aircraft)
    {
        // Delete existing seats
        Seat::where('aircraft_id', $aircraft->aircraft_id)->delete();

        $seats = [];
        $letters = $aircraft->seat_letters;
        $totalCols = count($letters);

        for ($row = 1; $row <= $aircraft->seat_rows; $row++) {
            // Determine class
            if ($row <= $aircraft->business_rows) {
                $seatClass = 'business';
            }
            else {
                $seatClass = 'economy';
            }

            foreach ($letters as $idx => $letter) {
                // Determine seat type
                if ($idx === 0 || $idx === $totalCols - 1) {
                    $seatType = 'window';
                }
                elseif ($totalCols >= 4 && ($idx === intdiv($totalCols, 2) - 1 || $idx === intdiv($totalCols, 2))) {
                    $seatType = 'aisle';
                }
                else {
                    $seatType = 'middle';
                }

                $seats[] = [
                    'aircraft_id' => $aircraft->aircraft_id,
                    'seat_number' => $row . $letter,
                    'seat_class' => $seatClass,
                    'seat_type' => $seatType,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert in batches
        foreach (array_chunk($seats, 100) as $chunk) {
            Seat::insert($chunk);
        }

        // Sync flight seat prices for all flights using this aircraft
        $this->syncFlightSeatPrices($aircraft);
    }

    /**
     * Regenerate FlightSeatPrice records for all flights using this aircraft.
     * This ensures the booking seat map stays in sync when seats change.
     */
    private function syncFlightSeatPrices(Aircraft $aircraft)
    {
        // Get all aircraft instances for this aircraft
        $aircraftInstances = \App\Models\AircraftInstance::where('aircraft_id', $aircraft->aircraft_id)->get();

        foreach ($aircraftInstances as $instance) {
            // Get all flight instances using this aircraft instance
            $flights = \App\Models\FlightInstance::where('aircraft_instance_id', $instance->aircraft_instance_id)->get();

            foreach ($flights as $flight) {
                // Delete old seat prices that are NOT booked
                \App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
                    ->whereDoesntHave('bookingSeats')
                    ->forceDelete();

                // Get current seats
                $seats = Seat::where('aircraft_id', $aircraft->aircraft_id)
                    ->where('is_active', 1)
                    ->get();

                foreach ($seats as $seat) {
                    // Skip if already exists
                    $exists = \App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
                        ->where('seat_id', $seat->seat_id)
                        ->exists();
                    if ($exists)
                        continue;

                    // Pricing based on class + preferred zone
                    $row = (int)preg_replace('/[^0-9]/', '', $seat->seat_number);
                    if ($seat->seat_class == 'business') {
                        $price = 250.00;
                    }
                    elseif ($aircraft->preferred_zone_enabled
                    && $row >= ($aircraft->preferred_zone_start_row ?? 0)
                    && $row <= ($aircraft->preferred_zone_end_row ?? 0)) {
                        $price = 180.00;
                    }
                    else {
                        $price = 150.00;
                    }

                    \App\Models\FlightSeatPrice::create([
                        'flight_instance_id' => $flight->flight_instance_id,
                        'seat_id' => $seat->seat_id,
                        'price_usd' => $price,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}
