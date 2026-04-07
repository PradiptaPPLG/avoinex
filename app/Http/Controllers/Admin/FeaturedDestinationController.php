<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FeaturedDestination;
use App\Models\Airport;
use Illuminate\Support\Facades\Storage;

class FeaturedDestinationController extends Controller
{
    public function index()
    {
        $destinations = FeaturedDestination::orderBy('sort_order')->get();
        return view('admin.featured_destinations.index', compact('destinations'));
    }

    public function create()
    {
        $airports = Airport::orderBy('city')->get();
        return view('admin.featured_destinations.create', compact('airports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'origin_iata' => 'required|string|max:10',
            'destination_iata' => 'required|string|max:10',
            'starting_price_idr' => 'required|numeric|min:0',
            'date_range' => 'required|string|max:50',
            'sort_order' => 'integer'
        ]);

        $exchangeRate = config('app.usd_to_idr', 15000);
        $validated['starting_price_usd'] = round($validated['starting_price_idr'] / $exchangeRate, 2);
        unset($validated['starting_price_idr']);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/destinations'), $imageName);
            $validated['image_path'] = 'images/destinations/' . $imageName;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        FeaturedDestination::create($validated);

        return redirect()->route('admin.featured_destinations.index')->with('success', 'Featured destination created successfully.');
    }

    public function edit(FeaturedDestination $featuredDestination)
    {
        $airports = Airport::orderBy('city')->get();
        return view('admin.featured_destinations.edit', compact('featuredDestination', 'airports'));
    }

    public function update(Request $request, FeaturedDestination $featuredDestination)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'origin_iata' => 'required|string|max:10',
            'destination_iata' => 'required|string|max:10',
            'starting_price_idr' => 'required|numeric|min:0',
            'date_range' => 'required|string|max:50',
            'sort_order' => 'integer'
        ]);

        $exchangeRate = config('app.usd_to_idr', 15000);
        $validated['starting_price_usd'] = round($validated['starting_price_idr'] / $exchangeRate, 2);
        unset($validated['starting_price_idr']);

        if ($request->hasFile('image')) {
            if ($featuredDestination->image_path && file_exists(public_path($featuredDestination->image_path))) {
                unlink(public_path($featuredDestination->image_path));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/destinations'), $imageName);
            $validated['image_path'] = 'images/destinations/' . $imageName;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $request->sort_order ?? 0;

        $featuredDestination->update($validated);

        return redirect()->route('admin.featured_destinations.index')->with('success', 'Featured destination updated successfully.');
    }

    public function destroy(FeaturedDestination $featuredDestination)
    {
        if ($featuredDestination->image_path && file_exists(public_path($featuredDestination->image_path))) {
            unlink(public_path($featuredDestination->image_path));
        }

        $featuredDestination->delete();

        return redirect()->route('admin.featured_destinations.index')->with('success', 'Featured destination deleted successfully.');
    }
}
