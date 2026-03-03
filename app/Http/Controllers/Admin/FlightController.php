<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlightInstance;
use App\Models\Schedule;
use App\Models\AircraftInstance;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        $flights = FlightInstance::with(['schedule', 'aircraftInstance.aircraft'])->paginate(20);
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
            'flight_date' => 'required|date',
        ]);

        FlightInstance::create($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight created successfully');
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
            'flight_date' => 'required|date',
        ]);

        $flight->update($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight updated successfully');
    }

    public function destroy($id)
    {
        FlightInstance::findOrFail($id)->delete();

        return redirect()->route('admin.flights.index')
            ->with('success', 'Flight hidden (soft deleted) successfully');
    }
}
