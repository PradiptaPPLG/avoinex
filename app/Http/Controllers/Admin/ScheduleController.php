<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Airport;
use App\Models\Airline;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['originAirport', 'destinationAirport', 'airline'])->where('is_active', true)->paginate(20);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $airports = Airport::all();
        $airlines = Airline::all();
        return view('admin.schedules.create', compact('airports', 'airlines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required',
            'airline_code' => 'required|exists:airlines,airline_code',
            'origin_iata_code' => 'required|exists:airports,iata_code',
            'destination_iata_code' => 'required|exists:airports,iata_code',
            'departure_time_gmt' => 'required',
            'arrival_time_gmt' => 'required',
            'duration_minutes' => 'required|integer',
            'base_price_usd' => 'required|numeric',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from'
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $airports = Airport::all();
        $airlines = Airline::all();
        return view('admin.schedules.edit', compact('schedule', 'airports', 'airlines'));
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'flight_number' => 'required',
            'airline_code' => 'required|exists:airlines,airline_code',
            'origin_iata_code' => 'required|exists:airports,iata_code',
            'destination_iata_code' => 'required|exists:airports,iata_code',
            'departure_time_gmt' => 'required',
            'arrival_time_gmt' => 'required',
            'duration_minutes' => 'required|integer',
            'base_price_usd' => 'required|numeric',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from'
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['is_active' => false]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
