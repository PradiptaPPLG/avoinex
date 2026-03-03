<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\AircraftManufacturer;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    public function index()
    {
        $aircraft = Aircraft::paginate(20);
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
            'total_seats' => 'required|integer'
        ]);

        Aircraft::create([
            'registration_number' => $validated['registration_number'],
            'aircraft_model' => $validated['model'],
            'manufacturer_id' => $validated['manufacturer'],
            'total_seats' => $validated['total_seats']
        ]);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft created successfully');
    }

    public function edit($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        return view('admin.aircraft.edit', compact('aircraft'));
    }

    public function update(Request $request, $id)
    {
        $aircraft = Aircraft::findOrFail($id);

        $validated = $request->validate([
            'registration_number' => 'required|unique:aircrafts,registration_number,' . $id . ',aircraft_id',
            'model' => 'required',
            'manufacturer' => 'required',
            'total_seats' => 'required|integer'
        ]);

        $aircraft->update([
            'registration_number' => $validated['registration_number'],
            'aircraft_model' => $validated['model'],
            'manufacturer_id' => $validated['manufacturer'],
            'total_seats' => $validated['total_seats']
        ]);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft updated successfully');
    }

    public function destroy($id)
    {
        Aircraft::findOrFail($id)->delete();

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Aircraft deleted successfully');
    }
}
