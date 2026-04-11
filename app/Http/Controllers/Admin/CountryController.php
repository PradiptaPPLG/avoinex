<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::where('is_active', true)->paginate(20);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_code' => 'required|size:2|unique:countries,country_code',
            'country_name' => 'required|max:100',
            'phone_code' => 'nullable|max:10',
            'continent' => 'nullable|max:50',
        ]);

        Country::create($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country created successfully.');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'country_code' => 'required|size:2|unique:countries,country_code,' . $id . ',country_id',
            'country_name' => 'required|max:100',
            'phone_code' => 'nullable|max:10',
            'continent' => 'nullable|max:50',
        ]);

        $country->update($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country updated successfully.');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $country->update(['is_active' => false]);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country deleted successfully.');
    }

    public function bulkDelete(\Illuminate\Http\Request $request)
    {
        $ids = $request->ids;
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $item = \App\Models\Country::find($id);
                if ($item) {
                    $item->update(['is_active' => false]);
                }
            }
        }
        return redirect()->back()->with('success', count($ids ?? []) . ' items deleted successfully.');
    }
}
