<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashSale;
use App\Models\FlightInstance;
use Carbon\Carbon;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::with(['flightInstance.schedule.originAirport', 'flightInstance.schedule.destinationAirport', 'flightInstance.schedule.airline'])
            ->orderBy('is_active', 'desc')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.flash_sales.index', compact('flashSales'));
    }

    public function create()
    {
        $flights = FlightInstance::with(['schedule.originAirport', 'schedule.destinationAirport'])
            ->where('flight_date', '>=', now()->toDateString())
            ->where('is_active', true)
            ->doesntHave('flashSale')
            ->get()
            ->map(function($flight) {
                return (object)[
                    'id' => $flight->flight_instance_id,
                    'text' => $flight->flightInstanceCode() . ' | ' . $flight->schedule->originAirport->iata_code . ' -> ' . $flight->schedule->destinationAirport->iata_code . ' (' . $flight->flight_date->format('d M') . ')'
                ];
            });

        return view('admin.flash_sales.create', compact('flights'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_id' => 'required|exists:flight_instances,flight_instance_id|unique:flash_sales,flight_id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_seats' => 'required|integer|min:1',
            'priority' => 'required|integer|min:0',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        FlashSale::create($validated);

        return redirect()->route('admin.flash_sales.index')->with('success', 'Flash Sale created successfully.');
    }

    public function edit($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        
        $flights = FlightInstance::with(['schedule.originAirport', 'schedule.destinationAirport'])
            ->where('flight_date', '>=', now()->toDateString())
            ->where('is_active', true)
            ->get()
            ->map(function($flight) {
                return (object)[
                    'id' => $flight->flight_instance_id,
                    'text' => $flight->flightInstanceCode() . ' | ' . $flight->schedule->originAirport->iata_code . ' -> ' . $flight->schedule->destinationAirport->iata_code . ' (' . $flight->flight_date->format('d M') . ')'
                ];
            });

        return view('admin.flash_sales.edit', compact('flashSale', 'flights'));
    }

    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);

        $validated = $request->validate([
            'flight_id' => 'required|exists:flight_instances,flight_instance_id|unique:flash_sales,flight_id,' . $flashSale->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_seats' => 'required|integer|min:1',
            'priority' => 'required|integer|min:0',
        ]);
        $validated['is_active'] = $request->boolean('is_active');

        $flashSale->update($validated);

        return redirect()->route('admin.flash_sales.index')->with('success', 'Flash Sale updated successfully.');
    }

    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        return redirect()->route('admin.flash_sales.index')->with('success', 'Flash Sale deleted successfully.');
    }

    public function bulkDelete(\Illuminate\Http\Request $request)
    {
        $ids = $request->ids;
        if ($ids && is_array($ids)) {
            foreach ($ids as $id) {
                $item = \App\Models\FlashSale::find($id);
                if ($item) {
                    $item->delete();
                }
            }
        }
        return redirect()->back()->with('success', count($ids ?? []) . ' items deleted successfully.');
    }
}
