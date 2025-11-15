<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman laporan umum (general report)
     * Berisi semua data rental/pesanan dari semua user
     */
    public function generalReport()
    {
        // Ambil semua rental dengan relasi car dan user (eager loading)
        // Urutkan dari yang terbaru
        $data = Rental::orderBy('created_at', 'desc')->with('car', 'user')->get();
        return view('admin.general-report', compact('data'));
    }

    /**
     * Konfirmasi pembayaran rental oleh admin
     * Update field is_confirmed menjadi true
     */
    public function confirmRental($id)
    {
        // Cari rental berdasarkan ID, throw 404 jika tidak ditemukan
        $rental = Rental::findOrFail($id);

        // Set konfirmasi menjadi true (pembayaran disetujui)
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
