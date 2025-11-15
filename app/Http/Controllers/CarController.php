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

    /**
     * Menyimpan data mobil baru ke database
     * Menangani upload multiple images dan menyimpannya dalam format JSON
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        // images.* artinya validasi berlaku untuk setiap file dalam array images
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'transmission' => 'required|in:automatic,manual', // hanya menerima 2 nilai ini
            'baggage' => 'required|integer|min:0',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|string',
            'color' => 'required|string',
            'driver' => 'required|boolean', // 0 atau 1
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048' // max 2MB per gambar
        ]);


        // Proses upload gambar jika ada file yang di-upload
        if ($request->hasFile('images')) {
            $imagePaths = [];
            // Loop setiap gambar yang di-upload
            foreach ($request->file('images') as $image) {
                // Simpan gambar ke storage/app/public/cars
                // Laravel akan generate nama file unik otomatis
                $path = $image->store('cars', 'public');
                $imagePaths[] = $path; // Simpan path ke array
            }
            // Convert array path menjadi JSON string untuk disimpan di database
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
     * Menangani update data mobil termasuk replace gambar lama dengan yang baru
     */
    public function update(Request $request, Car $car)
    {
        // Validasi input, images nullable karena tidak wajib upload gambar baru
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

        // Ambil gambar yang sudah ada di database
        // json_decode() mengubah JSON string menjadi array PHP
        $existingImages = json_decode($car->images, true) ?? [];

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $index => $image) {
                if ($image) {
                    // Hapus gambar lama dari storage jika ada
                    if (isset($existingImages[$index])) {
                        Storage::disk('public')->delete($existingImages[$index]);
                    }

                    // Upload gambar baru
                    $path = $image->store('cars', 'public');
                    $imagePaths[$index] = $path;
                } else {
                    // Pertahankan gambar lama jika tidak ada gambar baru
                    if (isset($existingImages[$index])) {
                        $imagePaths[$index] = $existingImages[$index];
                    }
                }
            }

            // Merge dengan gambar existing yang tidak di-replace
            foreach ($existingImages as $index => $path) {
                if (!isset($imagePaths[$index])) {
                    $imagePaths[$index] = $path;
                }
            }

            // Convert ke JSON dan reset index array (0,1,2,...)
            $validated['images'] = json_encode(array_values($imagePaths));
        } else {
            // Jika tidak ada upload gambar baru, gunakan gambar lama
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
     * Menghapus mobil dari database dan semua gambar terkait dari storage
     */
    public function destroy(Car $car)
    {
        // Hapus semua gambar dari storage terlebih dahulu
        $images = json_decode($car->images, true) ?? [];
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        // Hapus record mobil dari database
        $car->delete();

        return redirect('/admin/car-list')->with('success', 'Berhasil menghapus mobil.');
    }
}
