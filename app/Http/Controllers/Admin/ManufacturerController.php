<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AircraftManufacturer;
use App\Models\Country;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = AircraftManufacturer::with('country')->where('is_active', true)->paginate(20);
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function create()
    {
        $countries = Country::where('is_active', true)->orderBy('country_name')->get();
        return view('admin.manufacturers.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'country_code' => 'required|exists:countries,country_code',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        AircraftManufacturer::create($validated);

        return redirect()->route('admin.manufacturers.index')
            ->with('success', 'Manufacturer created successfully.');
    }

    public function edit($id)
    {
        $manufacturer = AircraftManufacturer::findOrFail($id);
        $countries = Country::where('is_active', true)->orderBy('country_name')->get();
        return view('admin.manufacturers.edit', compact('manufacturer', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $manufacturer = AircraftManufacturer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'country_code' => 'required|exists:countries,country_code',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $manufacturer->update($validated);

        return redirect()->route('admin.manufacturers.index')
            ->with('success', 'Manufacturer updated successfully.');
    }

    public function destroy($id)
    {
        $manufacturer = AircraftManufacturer::findOrFail($id);
        $manufacturer->update(['is_active' => false]);

        return redirect()->route('admin.manufacturers.index')
            ->with('success', 'Manufacturer deleted successfully.');
    }

    public function bulkDelete(\Illuminate\Http\Request $request)
    {
        $ids = $request->ids;
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $item = \App\Models\AircraftManufacturer::find($id);
                if ($item) {
                    $item->update(['is_active' => false]);
                }
            }
        }
        return redirect()->back()->with('success', count($ids ?? []) . ' items deleted successfully.');
    }
}
