<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::with('country')->where('is_active', true)->paginate(20);
        return view('admin.airports.index', compact('airports'));
    }

    public function create()
    {
        $countries = Country::where('is_active', true)->orderBy('country_name')->get();
        return view('admin.airports.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'iata_code' => 'required|size:3|unique:airports,iata_code',
            'airport_name' => 'required|max:255',
            'city' => 'required|max:100',
            'country_code' => 'required|exists:countries,country_code',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        Airport::create($validated);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Airport created successfully.');
    }

    public function edit($id)
    {
        $airport = Airport::findOrFail($id);
        $countries = Country::where('is_active', true)->orderBy('country_name')->get();
        return view('admin.airports.edit', compact('airport', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $airport = Airport::findOrFail($id);

        $validated = $request->validate([
            'iata_code' => 'required|size:3|unique:airports,iata_code,' . $id . ',airport_id',
            'airport_name' => 'required|max:255',
            'city' => 'required|max:100',
            'country_code' => 'required|exists:countries,country_code',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        $airport->update($validated);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Airport updated successfully.');
    }

    public function destroy($id)
    {
        $airport = Airport::findOrFail($id);
        $airport->update(['is_active' => false]);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Airport deleted successfully.');
    }
}
