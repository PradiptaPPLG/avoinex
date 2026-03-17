<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $airports = Airport::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('city', 'like', "%{$query}%")
                  ->orWhere('airport_name', 'like', "%{$query}%")
                  ->orWhere('iata_code', 'like', "%{$query}%");
            })
            ->select('iata_code as code', 'city', 'airport_name as name')
            ->limit(10)
            ->get();

        return response()->json($airports);
    }
}
