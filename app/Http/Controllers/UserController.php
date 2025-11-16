<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan user
     * Mengambil semua data rental milik user yang sedang login
     * Data diurutkan dari yang terbaru (descending)
     */
    public function history()
    {
        // Ambil semua rental berdasarkan user_id yang sedang login
        // ->with('car') untuk eager loading data mobil (menghindari N+1 query problem)
        $orderHistory = Rental::where('user_id', auth()->id())->with('car')->orderBy('created_at', 'desc')->get();
        return view('user.history', compact('orderHistory'));
    }

    /**
     * Menampilkan halaman form pemesanan mobil
     * Parameter $car otomatis di-inject oleh Laravel (Route Model Binding)
     */
    public function order(Car $car)
    {
        return view('order', compact('car'));
    }

    /**
     * Menyimpan data pesanan mobil ke database
     * Menghitung total harga berdasarkan jumlah hari sewa
     * Generate nomor SO (Sales Order) otomatis
     */
    public function storeOrder(Request $request, Car $car)
    {
        // Validasi input dari form pemesanan
        $request->validate([
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:pickup_date', // tanggal kembali harus >= tanggal ambil
            'pickup_location' => 'required|string|max:255',

            'pickup_time' => 'required',
            'return_time' => 'required',
            'with_driver' => 'required|boolean',
        ]);

        // Hitung total harga: harga per hari × jumlah hari sewa
        // strtotime() mengubah tanggal menjadi timestamp (detik)
        // Dibagi (60*60*24) untuk mengubah detik menjadi hari
        // +1 karena minimal sewa 1 hari
        $rentalDays = ((strtotime($request->return_date) - strtotime($request->pickup_date)) / (60 * 60 * 24)) + 1;
        $total_price = $car->price_per_day * $rentalDays;

        if ($request->with_driver == '1') {
            // Tambah biaya supir tetap 100.000 per hari
            $total_price += 100000 * $rentalDays;
        }

        // Generate nomor SO unik, contoh: SO6748A3B2F1E9D
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
            'with_driver' => $request->with_driver,
        ]);

        // Logic untuk menyimpan pesanan akan ditambahkan di sini
        return redirect()->to('/user/history')->with('success', 'Pesanan berhasil dibuat!, silakan lanjutkan ke pembayaran.');
    }

    /**
     * Menampilkan halaman profil user
     * Data user diambil otomatis dari auth()->user()
     */
    public function profile()
    {
        return view('user.profile');
    }

    /**
     * Mengupdate data profil user
     * Validasi unique untuk username dan email dengan pengecualian user yang sedang login
     */
    public function updateProfile(Request $request)
    {
        // Validasi input
        // unique:users,username,' . auth()->id() artinya username harus unik kecuali untuk user ini sendiri
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

    /**
     * Mengubah password user
     * Memvalidasi password lama sebelum mengubah ke password baru
     */
    public function changePassword(Request $request)
    {
        // Validasi input
        // confirmed artinya harus ada field new_password_confirmation yang nilainya sama
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Cek apakah password lama yang diinput sesuai dengan password di database
        // Hash::check() membandingkan password plain text dengan password yang sudah di-hash
        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password lama tidak sesuai!']);
        }

        auth()->user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Memproses pembayaran rental
     * Update status dari 'unpaid' menjadi 'paid'
     * Menampilkan halaman struk setelah pembayaran
     */
    public function payRental(Rental $rental)
    {
        // Security check: pastikan rental milik user yang sedang login
        // Mencegah user lain membayar pesanan orang lain
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized'); // HTTP 403 Forbidden
        }

        // Update status menjadi paid (menunggu konfirmasi admin)
        $rental->update(['status' => 'paid']);

        $order = $rental;

        return view('receipt', compact('order'));

        // return redirect()->back()->with('success', 'Pembayaran berhasil! Menunggu konfirmasi admin.');
    }

    /**
     * Membatalkan pesanan rental
     * Hanya bisa membatalkan jika status masih 'unpaid'
     */
    public function cancelRental(Rental $rental)
    {
        // Security check: pastikan rental milik user yang sedang login
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Business logic: hanya pesanan yang belum dibayar yang bisa dibatalkan
        if ($rental->status !== 'unpaid') {
            return redirect()->back()->withErrors(['error' => 'Pesanan tidak dapat dibatalkan!']);
        }

        // Update status menjadi cancelled (tidak benar-benar dihapus dari database)
        $rental->status = 'cancelled';
        $rental->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan!');
    }

    /**
     * Download struk pemesanan dalam format PDF
     * Menggunakan library DomPDF untuk generate PDF dari view Blade
     */
    public function downloadReceipt(Rental $rental)
    {
        // Security check: pastikan rental milik user yang sedang login
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $order = $rental;
        // Generate PDF dari view 'receipt-pdf.blade.php'
        $pdf = Pdf::loadView('receipt-pdf', compact('order'));

        // Download PDF dengan nama file dinamis berdasarkan SO number
        return $pdf->download('struk-' . $order->so_number . '.pdf');
    }
}
