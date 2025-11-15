<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function history()
    {
        $orderHistory = Rental::where('user_id', auth()->id())->with('car')->orderBy('created_at', 'desc')->get();
        return view('user.history', compact('orderHistory'));
    }

    public function order(Car $car)
    {
        return view('order', compact('car'));
    }

    public function storeOrder(Request $request, Car $car)
    {
        $request->validate([
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'pickup_location' => 'required|string|max:255',

            'pickup_time' => 'required',
            'return_time' => 'required',
        ]);

        $total_price = $car->price_per_day * ((strtotime($request->return_date) - strtotime($request->pickup_date)) / (60 * 60 * 24) + 1);
        $so_number = 'SO' . strtoupper(uniqid());

        Rental::create([
            'user_id' => auth()->id(),
            'so_number' => $so_number,
            'car_id' => $car->id,
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            'pickup_time' => $request->pickup_time,
            'return_time' => $request->return_time,
            'pickup_location' => $request->pickup_location,
            'total_price' => $total_price,
            'status' => 'unpaid',
        ]);

        // Logic untuk menyimpan pesanan akan ditambahkan di sini
        return redirect()->to('/user/history')->with('success', 'Pesanan berhasil dibuat!, silakan lanjutkan ke pembayaran.');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        auth()->user()->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai!']);
        }

        auth()->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }

    public function payRental(Rental $rental)
    {
        // Pastikan rental milik user yang sedang login
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Update status menjadi paid
        $rental->update(['status' => 'paid']);

        $order = $rental;

        return view('receipt', compact('order'));

        // return redirect()->back()->with('success', 'Pembayaran berhasil! Menunggu konfirmasi admin.');
    }

    public function cancelRental(Rental $rental)
    {
        // Pastikan rental milik user yang sedang login
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Hanya bisa cancel jika status unpaid
        if ($rental->status !== 'unpaid') {
            return redirect()->back()->withErrors(['error' => 'Pesanan tidak dapat dibatalkan!']);
        }

        // Hapus rental
        $rental->status = 'cancelled';
        $rental->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan!');
    }

    public function downloadReceipt(Rental $rental)
    {
        // Pastikan rental milik user yang sedang login
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order = $rental;
        $pdf = Pdf::loadView('receipt-pdf', compact('order'));

        return $pdf->download('struk-' . $order->so_number . '.pdf');
    }
}
