<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::all();
        return view('admin.car-list', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-car');
    }

    public function store(Request $request)
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

        return redirect()->to('/admin/car-list')->with('success', 'Berhasil menambahkan mobil.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return view('car-detail', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return view('admin.edit-car', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image uploads if new images are provided
        $existingImages = json_decode($car->images, true) ?? [];

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $index => $image) {
                if ($image) {
                    // Delete old image if exists
                    if (isset($existingImages[$index])) {
                        Storage::disk('public')->delete($existingImages[$index]);
                    }

                    $path = $image->store('cars', 'public');
                    $imagePaths[$index] = $path;
                } else {
                    // Keep existing image if no new image uploaded
                    if (isset($existingImages[$index])) {
                        $imagePaths[$index] = $existingImages[$index];
                    }
                }
            }

            // Merge with existing images
            foreach ($existingImages as $index => $path) {
                if (!isset($imagePaths[$index])) {
                    $imagePaths[$index] = $path;
                }
            }

            $validated['images'] = json_encode(array_values($imagePaths));
        } else {
            $validated['images'] = $car->images;
        }

        // Update the car
        $car->update([
            'name' => $validated['name'],
            'price_per_day' => $validated['price'],
            'transmission' => $validated['transmission'],
            'baggage' => $validated['baggage'],
            'seats' => $validated['seats'],
            'fuel_type' => $validated['fuel_type'],
            'color' => $validated['color'],
            'driver' => $validated['driver'],
            'images' => $validated['images'],
        ]);

        return redirect('/admin/car-list')->with('success', 'Berhasil mengupdate mobil.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        // Delete associated images from storage
        $images = json_decode($car->images, true) ?? [];
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        // Delete the car record from the database
        $car->delete();

        return redirect('/admin/car-list')->with('success', 'Berhasil menghapus mobil.');
    }
}