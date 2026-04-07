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
        $aircraft = Aircraft::with('manufacturer')->where('is_active', true)->paginate(20);
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
            'preferred_zone_start_row' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('preferred_zone_enabled') && $value <= $request->input('business_rows')) {
                        $fail('Preferred zone start row must be greater than business rows.');
                    }
                }
            ],
            'preferred_zone_end_row' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('preferred_zone_enabled')) {
                        if ($value > $request->input('seat_rows')) {
                            $fail('Preferred zone end row must be <= total rows.');
                        }
                        if ($value < $request->input('preferred_zone_start_row')) {
                            $fail('Preferred zone end row must be >= start row.');
                        }
                    }
                }
            ],
            'baggage_capacity_kg' => 'required|integer|min:0',
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
            'baggage_capacity_kg' => $validated['baggage_capacity_kg'],
            'has_meal' => $request->boolean('has_meal'),
            'has_wifi' => $request->boolean('has_wifi'),
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
            'preferred_zone_start_row' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('preferred_zone_enabled') && $value <= $request->input('business_rows')) {
                        $fail('Preferred zone start row must be greater than business rows.');
                    }
                }
            ],
            'preferred_zone_end_row' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('preferred_zone_enabled')) {
                        if ($value > $request->input('seat_rows')) {
                            $fail('Preferred zone end row must be <= total rows.');
                        }
                        if ($value < $request->input('preferred_zone_start_row')) {
                            $fail('Preferred zone end row must be >= start row.');
                        }
                    }
                }
            ],
            'baggage_capacity_kg' => 'required|integer|min:0',
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
            'baggage_capacity_kg' => $validated['baggage_capacity_kg'],
            'has_meal' => $request->boolean('has_meal'),
            'has_wifi' => $request->boolean('has_wifi'),
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
        $aircraft = Aircraft::findOrFail($id);
        $aircraft->update(['is_active' => false]);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft deleted successfully.');
    }

    /**
     * Auto-generate Seat records for an aircraft based on its configuration.
     */
    private function generateSeats(Aircraft $aircraft)
    {
        $existingSeats = Seat::where('aircraft_id', $aircraft->aircraft_id)->get()->keyBy('seat_number');
        $validSeatIds = [];
        $seatsToInsert = [];
        $letters = $aircraft->seat_letters;
        $totalCols = count($letters);

        for ($row = 1; $row <= $aircraft->seat_rows; $row++) {
            // Determine class
            if ($row <= $aircraft->business_rows) {
                $seatClass = 'business';
            }
            elseif ($aircraft->preferred_zone_enabled && 
                    $row >= $aircraft->preferred_zone_start_row && 
                    $row <= $aircraft->preferred_zone_end_row) {
                $seatClass = 'preferred';
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

                $seatNumber = $row . $letter;

                if ($existingSeats->has($seatNumber)) {
                    $seat = $existingSeats->get($seatNumber);
                    $seat->update([
                        'seat_class' => $seatClass,
                        'seat_type' => $seatType,
                        'is_active' => true,
                    ]);
                    $validSeatIds[] = $seat->seat_id;
                } else {
                    $seatsToInsert[] = [
                        'aircraft_id' => $aircraft->aircraft_id,
                        'seat_number' => $seatNumber,
                        'seat_class' => $seatClass,
                        'seat_type' => $seatType,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert in batches
        foreach (array_chunk($seatsToInsert, 100) as $chunk) {
            Seat::insert($chunk);
        }

        // Deactivate seats that are no longer in this configuration
        if (count($validSeatIds) > 0) {
            Seat::where('aircraft_id', $aircraft->aircraft_id)
                ->whereNotIn('seat_id', $validSeatIds)
                ->update(['is_active' => false]);
        } else {
            Seat::where('aircraft_id', $aircraft->aircraft_id)
                ->update(['is_active' => false]);
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
                    // Pricing based on class + preferred zone
                    $row = (int)preg_replace('/[^0-9]/', '', $seat->seat_number);
                    if ($seat->seat_class == 'business') {
                        $price = 250.00;
                    }
                    elseif ($seat->seat_class == 'preferred' || ($aircraft->preferred_zone_enabled
                    && $row >= ($aircraft->preferred_zone_start_row ?? 0)
                    && $row <= ($aircraft->preferred_zone_end_row ?? 0))) {
                        $price = 180.00;
                    }
                    else {
                        $price = 150.00;
                    }

                    // Update if already exists, else create
                    $existingPrice = \App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
                        ->where('seat_id', $seat->seat_id)
                        ->first();
                        
                    if ($existingPrice) {
                        // Only update if not booked (optional: can leave booked prices unchanged or forcefully update them)
                        // It's safer to just update the price
                        $existingPrice->update(['price_usd' => $price, 'is_available' => $existingPrice->is_available]);
                    } else {
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
}
