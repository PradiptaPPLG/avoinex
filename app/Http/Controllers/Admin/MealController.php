<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::orderBy('name')->paginate(10);
        return view('admin.meals.index', compact('meals'));
    }

    public function create()
    {
        return view('admin.meals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_idr' => 'required|numeric|min:0',
            'cropped_image' => 'nullable|string' // base64 encoded image
        ]);

        $meal = new Meal();
        $meal->name = $request->name;
        $meal->description = $request->description;
        
        // Convert IDR to USD for storage
        $exchangeRate = config('app.usd_to_idr', 15000);
        $meal->price_usd = round($request->price_idr / $exchangeRate, 2);
        
        $meal->is_active = $request->has('is_active');

        if ($request->filled('cropped_image')) {
            $meal->image_path = $this->saveBase64Image($request->cropped_image);
        }

        $meal->save();

        return redirect()->route('admin.meals.index')->with('success', 'Meal created successfully.');
    }

    public function edit(Meal $meal)
    {
        return view('admin.meals.edit', compact('meal'));
    }

    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_idr' => 'required|numeric|min:0',
            'cropped_image' => 'nullable|string'
        ]);

        $meal->name = $request->name;
        $meal->description = $request->description;
        
        // Convert IDR to USD for storage
        $exchangeRate = config('app.usd_to_idr', 15000);
        $meal->price_usd = round($request->price_idr / $exchangeRate, 2);
        
        $meal->is_active = $request->has('is_active');

        if ($request->filled('cropped_image')) {
            // Delete old image
            if ($meal->image_path && Storage::disk('public')->exists($meal->image_path)) {
                Storage::disk('public')->delete($meal->image_path);
            }
            $meal->image_path = $this->saveBase64Image($request->cropped_image);
        }

        $meal->save();

        return redirect()->route('admin.meals.index')->with('success', 'Meal updated successfully.');
    }

    public function destroy(Meal $meal)
    {
        if ($meal->image_path && Storage::disk('public')->exists($meal->image_path)) {
            Storage::disk('public')->delete($meal->image_path);
        }
        $meal->delete();

        return redirect()->route('admin.meals.index')->with('success', 'Meal deleted successfully.');
    }

    private function saveBase64Image($base64String)
    {
        try {
            // Extract base64
            $image_parts = explode(";base64,", $base64String);
            if (count($image_parts) < 2) return null;

            $image_type_aux = explode("image/", $image_parts[0]);
            if (count($image_type_aux) < 2) return null;
            
            $image_type = $image_type_aux[1];
            if (!in_array($image_type, ['jpeg', 'png', 'jpg', 'webp'])) {
                $image_type = 'jpg';
            }
            
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'meals/' . Str::random(20) . '.' . $image_type;
            
            // Save using Storage facade
            Storage::disk('public')->put($fileName, $image_base64);

            return $fileName;
        } catch (\Exception $e) {
            return null;
        }
    }
}
