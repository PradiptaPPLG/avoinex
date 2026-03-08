<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlightInstance;
use App\Models\Schedule;
use App\Models\AircraftInstance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlightController extends Controller
{
    public function index()
    {
        $flights = FlightInstance::with(['schedule', 'aircraftInstance.aircraft'])->where('is_active', true)->paginate(20);
        return view('admin.flights.index', compact('flights'));
    }

    public function create()
    {
        $schedules = Schedule::all();
        $aircraftInstances = AircraftInstance::with('aircraft')->get();
        return view('admin.flights.create', compact('schedules', 'aircraftInstances'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'aircraft_instance_id' => 'required|exists:aircraft_instances,aircraft_instance_id',
            'flight_date' => [
                'required',
                'date',
                Rule::unique('flight_instances')->where(function ($query) use ($request) {
            return $query->where('schedule_id', $request->schedule_id)
            ->whereNull('deleted_at');
        }),
            ],
        ], [
            'flight_date.unique' => 'A flight with this schedule already exists on the selected date.',
        ]);

        $flight = FlightInstance::create($validated);

        // Auto-generate seat prices for this flight
        $this->generateFlightSeatPrices($flight);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight created successfully with seat prices generated.');
    }

    public function edit($id)
    {
        $flight = FlightInstance::findOrFail($id);
        $schedules = Schedule::all();
        $aircraftInstances = AircraftInstance::with('aircraft')->get();
        return view('admin.flights.edit', compact('flight', 'schedules', 'aircraftInstances'));
    }

    public function update(Request $request, $id)
    {
        $flight = FlightInstance::findOrFail($id);

        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'aircraft_instance_id' => 'required|exists:aircraft_instances,aircraft_instance_id',
            'flight_date' => [
                'required',
                'date',
                Rule::unique('flight_instances')->where(function ($query) use ($request) {
            return $query->where('schedule_id', $request->schedule_id)
            ->whereNull('deleted_at');
        })->ignore($id, 'flight_instance_id'),
            ],
        ], [
            'flight_date.unique' => 'A flight with this schedule already exists on the selected date.',
        ]);

        $oldAircraftInstanceId = $flight->aircraft_instance_id;
        $flight->update($validated);

        // Regenerate seat prices to sync any changes in the aircraft's seating layout or pricing rules
        $this->generateFlightSeatPrices($flight);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight updated successfully.');
    }

    public function destroy($id)
    {
        $flight = FlightInstance::findOrFail($id);
        $flight->update(['is_active' => false]);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight deleted successfully.');
    }

    /**
     * Auto-generate FlightSeatPrice records for a flight.
     * Links the flight to the aircraft's seat records with default pricing.
     */
    private function generateFlightSeatPrices(FlightInstance $flight)
    {
        $aircraftInstance = AircraftInstance::with('aircraft')->find($flight->aircraft_instance_id);
        if (!$aircraftInstance || !$aircraftInstance->aircraft)
            return;

        $aircraft = $aircraftInstance->aircraft;

        // Get all seats for this aircraft
        $seats = \App\Models\Seat::where('aircraft_id', $aircraft->aircraft_id)
            ->where('is_active', 1)
            ->get();

        if ($seats->isEmpty())
            return;

        // Delete old seat prices that are not booked
        \App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
            ->whereDoesntHave('bookingSeats')
            ->forceDelete();

        foreach ($seats as $seat) {
            // Skip if already exists (booked seat)
            $exists = \App\Models\FlightSeatPrice::where('flight_instance_id', $flight->flight_instance_id)
                ->where('seat_id', $seat->seat_id)
                ->exists();
            if ($exists)
                continue;

            // Default pricing based on seat class + preferred zone
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
