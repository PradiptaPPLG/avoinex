<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use App\Models\Country;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::with('country')->where('is_active', true)->paginate(20);
        return view('admin.airlines.index', compact('airlines'));
    }

    public function create()
    {
        $countries = Country::where('is_active', true)->orderBy('country_name')->get();
        return view('admin.airlines.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'airline_code' => 'required|max:10|unique:airlines,airline_code',
            'airline_name' => 'required|max:255',
            'country_code' => 'required|exists:countries,country_code',
            'website' => 'nullable|url|max:255',
            'contact_phone' => 'nullable|max:30',
        ]);

        Airline::create($validated);

        return redirect()->route('admin.airlines.index')
            ->with('success', 'Airline created successfully.');
    }

    public function edit($id)
    {
        $airline = Airline::findOrFail($id);
        $countries = Country::where('is_active', true)->orderBy('country_name')->get();
        return view('admin.airlines.edit', compact('airline', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $airline = Airline::findOrFail($id);

        $validated = $request->validate([
            'airline_code' => 'required|max:10|unique:airlines,airline_code,' . $id . ',airline_id',
            'airline_name' => 'required|max:255',
            'country_code' => 'required|exists:countries,country_code',
            'website' => 'nullable|url|max:255',
            'contact_phone' => 'nullable|max:30',
        ]);

        $airline->update($validated);

        return redirect()->route('admin.airlines.index')
            ->with('success', 'Airline updated successfully.');
    }

    public function destroy($id)
    {
        $airline = Airline::findOrFail($id);
        $airline->update(['is_active' => false]);

        return redirect()->route('admin.airlines.index')
            ->with('success', 'Airline deleted successfully.');
    }
}
