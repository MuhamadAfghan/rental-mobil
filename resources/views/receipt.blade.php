<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pemesanan | S4B Rent Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Tambahan (Menggantikan @apply) */
        .btn-disabled {
            background-color: #9ca3af;
            /* bg-gray-400 */
            cursor: not-allowed;
            /* Pastikan hover juga dinonaktifkan di sini */
        }

        .btn-disabled:hover {
            background-color: #9ca3af;
            /* hover:bg-gray-400 */
        }

        #receipt-content {
            background-color: white;
            padding: 2rem;
            /* p-8 */
            border-radius: 0.75rem;
            /* rounded-xl */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            /* shadow-lg */
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100">

    {{--
        Helper Functions PHP untuk formatting dan kalkulasi
        Functions ini bisa digunakan di template Blade
    --}}
    @php
        /**
         * Format angka menjadi format Rupiah
         * @param int $number - Angka yang akan diformat
         * @return string - String dengan format Rupiah (Rp 1.000.000)
         */
        function formatRupiah($number)
        {
            // number_format(angka, desimal, separator desimal, separator ribuan)
            return 'Rp ' . number_format($number, 0, ',', '.');
        }

        /**
         * Mendapatkan label status dan warna badge berdasarkan status pembayaran
         * @param string $status - Status pembayaran (paid/unpaid/cancelled)
         * @param bool $isConfirmed - Apakah sudah dikonfirmasi admin
         * @return array - Array berisi 'label' dan 'color' untuk badge
         */
        function getStatusLabel($status, $isConfirmed)
        {
            // Jika sudah dibayar DAN sudah dikonfirmasi admin
            if ($status === 'paid' && $isConfirmed) {
                return ['label' => 'Dikonfirmasi', 'color' => 'text-green-600'];
            }
            // Jika sudah dibayar tapi belum dikonfirmasi admin
            elseif ($status === 'paid' && !$isConfirmed) {
                return ['label' => 'Menunggu Konfirmasi', 'color' => 'text-blue-600'];
            }
            // Jika belum dibayar
            elseif ($status === 'unpaid') {
                return ['label' => 'Menunggu Pembayaran', 'color' => 'text-yellow-600'];
            }
            // Jika dibatalkan
            elseif ($status === 'cancelled') {
                return ['label' => 'Dibatalkan', 'color' => 'text-red-600'];
            }
        }

        /**
         * Menghitung jumlah hari sewa berdasarkan tanggal pickup dan return
         * @param string $pickupDate - Tanggal pengambilan (format: Y-m-d)
         * @param string $returnDate - Tanggal pengembalian (format: Y-m-d)
         * @return int - Jumlah hari sewa (minimal 1 hari)
         */
        function calculateDays($pickupDate, $returnDate)
        {
            $pickup = new DateTime($pickupDate);
            $return = new DateTime($returnDate);
            // diff() menghitung selisih antara 2 tanggal
            // ?: 1 artinya jika hasilnya 0, return 1 (minimal sewa 1 hari)
            return $pickup->diff($return)->days ?: 1;
        }

        // Hitung jumlah hari sewa
        $sewaHari = calculateDays($order->pickup_date, $order->return_date);

        // Cek apakah mobil menyediakan supir
        $hasDriver = $order->car->driver == 1;
    @endphp

    <div class="mx-auto max-w-4xl px-4 pt-8 sm:px-6 lg:px-8">
        <div class="relative mb-10 flex items-center justify-center">
            <a href="{{ url('/') }}#menu-mobil"
                class="absolute left-0 text-gray-600 transition duration-200 hover:text-red-600">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-4xl font-extrabold text-gray-900">Struk Pemesanan</h1>
        </div>

    </div>

    <div id="receipt-content" class="mb-8">

        <div class="mb-8 text-center">
            <p class="text-xl font-semibold text-gray-800">Booking ID: {{ $order->so_number }}</p>
            <p class="text-sm text-gray-500">Tanggal Transaksi:
                {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i') }}</p>
            <div class="mx-auto mt-3 flex items-center justify-center gap-2">
                <span class="rounded-3xl bg-green-400 px-2 py-1 text-xs text-white">
                    Berhasil
                </span>
                <span class="rounded-3xl bg-gray-600 px-2 py-1 text-xs text-white">
                    Menunggu konfirmasi admin
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 pt-2 lg:grid-cols-2">

            <div class="space-y-6">
                <h2 class="mb-4 border-b pb-2 text-2xl font-bold text-gray-800">Data Pemesan</h2>
                <div>
                    <p class="font-bold text-gray-900">Username</p>
                    <p class="text-base text-gray-600">{{ auth()->user()->username }}</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Email</p>
                    <p class="text-base text-gray-600">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900">No. Telepon</p>
                    <p class="text-base text-gray-600">{{ auth()->user()->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Tgl Transaksi</p>
                    <p class="text-base text-gray-600">
                        {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i') }}</p>
                </div>


            </div>



            <div class="space-y-6">
                <h2 class="mb-4 border-b pb-2 text-2xl font-bold text-gray-800">Detail Pesanan</h2>

                <div>
                    <p class="font-bold text-gray-900">Mobil Dipesan</p>
                    <p class="text-base text-gray-600">{{ $order->car->name }}</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Lokasi Pengambilan</p>
                    <p class="text-base text-gray-600">{{ $order->pickup_location }}</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Tanggal Sewa</p>
                    <p class="text-base text-gray-600">
                        {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}
                        ({{ \Carbon\Carbon::parse($order->pickup_time)->format('h:i A') }})
                    </p>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Tanggal Kembali</p>
                    <p class="text-base text-gray-600">
                        {{ \Carbon\Carbon::parse($order->return_date)->format('d M Y') }}
                        ({{ \Carbon\Carbon::parse($order->return_time)->format('h:i A') }})</p>
                </div>

                <div>
                    <p class="font-bold text-gray-900">Supir</p>
                    <p class="{{ $hasDriver ? 'text-green-600' : 'text-red-600' }} text-base">
                        {{ $hasDriver ? 'Ya' : 'Tidak' }}
                    </p>
                </div>

                <div class="border-t border-gray-300 pt-2">
                    <p class="text-2xl font-bold text-red-600">Total Harga Akhir</p>
                    <p class="text-sm text-gray-500">({{ $sewaHari }} Hari)</p>
                    <p class="text-3xl font-extrabold text-red-700">{{ formatRupiah($order->total_price) }}</p>
                </div>
            </div>
        </div>
        <hr class="mt-6">
        <div class="mt-6 flex justify-center gap-2">
            {{-- back --}}
            <a href="/user/history"
                class="flex items-center space-x-2 rounded-lg bg-gray-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-gray-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>

            <a href="/user/rental/{{ $order->id }}/download-receipt"
                class="flex items-center space-x-2 rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-blue-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span>Download Struk PDF</span>
            </a>
        </div>

    </div>

</body>

</html>
