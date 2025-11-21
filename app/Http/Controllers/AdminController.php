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
     * Update status rental oleh admin
     * Mengubah rental_status untuk tracking progress penyewaan
     */
    public function updateRentalStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $request->validate([
            'rental_status' => 'required|in:pending,ongoing,completed,cancelled'
        ]);

        $rental->rental_status = $request->rental_status;
        $rental->save();

        // Jika status completed atau cancelled, kembalikan ketersediaan mobil
        if ($request->rental_status === 'completed' || $request->rental_status === 'cancelled') {
            $rental->car->update(['is_available' => true]);
        } else {
            // Set mobil menjadi tidak tersedia untuk status lain
            $rental->car->update(['is_available' => false]);
        }

        return redirect()->back()->with('success', 'Status rental berhasil diupdate.');
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
            'images' => $validated['images'] ?? null,
            'is_available' => true, // Mobil baru otomatis tersedia
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan mobil.');
    }
}
