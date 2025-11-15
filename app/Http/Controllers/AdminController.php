<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function generalReport()
    {
        $data = Rental::orderBy('created_at', 'desc')->with('car', 'user')->get();
        return view('admin.general-report', compact('data'));
    }

    public function confirmRental($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->is_confirmed = true;
        $rental->save();

        return redirect()->back()->with('success', 'Rental dikonfirmasi berhasil.');
    }

    public function addCarPage()
    {
        return view('admin.add-car');
    }

    public function addCar(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'transmission' => 'required|in:automatic,manual',
            'baggage' => 'required|integer|min:0',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|string',
            'color' => 'required|string',
            'driver' => 'required|boolean',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);


        // Handle image uploads if needed
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');
                $imagePaths[] = $path;
            }
            $validated['images'] = json_encode($imagePaths);
        }

        // Save the car to the database
        Car::create([
            'name' => $validated['name'],
            'price_per_day' => $validated['price'],
            'transmission' => $validated['transmission'],
            'baggage' => $validated['baggage'],
            'seats' => $validated['seats'],
            'fuel_type' => $validated['fuel_type'],
            'color' => $validated['color'],
            'driver' => $validated['driver'],
            'images' => $validated['images'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan mobil.');
    }
}