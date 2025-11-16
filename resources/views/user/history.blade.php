<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan | S4B Rent Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        .main-content {
            margin-left: 250px;
        }

        /* CSS untuk kontainer riwayat */
        .history-card {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="sidebar bg-red-600 text-white shadow-xl">
        <div class="border-b border-red-700 p-4">
            <div class="mb-6 flex items-center space-x-3">
                <svg class="h-10 w-10 rounded-full bg-white p-1 text-red-600" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-base font-semibold">{{ auth()->user()->username }}</p>
                    <p class="text-xs text-red-200">USER</p>
                </div>
            </div>
        </div>

        <nav class="space-y-1">
            <a href="/" class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Home
            </a>
            <a href="/user/history"
                class="block border-l-4 border-white bg-red-700 px-4 py-3 text-lg font-medium transition duration-150">
                Riwayat Pesanan
            </a>
            <a href="/user/profile"
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Profil Saya
            </a>
            <a href="/logout"
                class="absolute bottom-0 block w-full px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Logout
            </a>
        </nav>
    </div>

    <div class="main-content mx-auto max-w-4xl px-8 py-8">
        <h1 class="mb-10 text-4xl font-extrabold text-gray-800">Riwayat Pesanan Anda</h1>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @php
            function formatRupiah($number)
            {
                return 'Rp ' . number_format($number, 0, ',', '.');
            }

            function getStatusLabel($status, $isConfirmed)
            {
                if ($status === 'paid' && $isConfirmed) {
                    return ['label' => 'Dikonfirmasi', 'color' => 'text-green-600'];
                } elseif ($status === 'paid' && !$isConfirmed) {
                    return ['label' => 'Menunggu Konfirmasi', 'color' => 'text-blue-600'];
                } elseif ($status === 'unpaid') {
                    return ['label' => 'Menunggu Pembayaran', 'color' => 'text-yellow-600'];
                } elseif ($status === 'cancelled') {
                    return ['label' => 'Dibatalkan', 'color' => 'text-red-600'];
                }
            }

            function calculateDays($pickupDate, $returnDate)
            {
                $pickup = new DateTime($pickupDate);
                $return = new DateTime($returnDate);
                return $pickup->diff($return)->days ?: 1;
            }
        @endphp

        @forelse ($orderHistory as $order)
            @php
                $statusInfo = getStatusLabel($order->status, $order->is_confirmed);
                $sewaHari = calculateDays($order->pickup_date, $order->return_date);
            @endphp

            <div class="history-card">

                <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-4">
                    <p class="text-xl font-bold text-gray-800">Booking ID: #{{ $order->so_number }}</p>
                    <p class="{{ $statusInfo['color'] }} text-sm font-semibold">{{ $statusInfo['label'] }}</p>
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
                            <p class="text-base text-gray-600">{{ auth()->user()->phone_number ?? '-' }}</p>
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
                            <p class="{{ $order->with_driver == 1 ? 'text-green-600' : 'text-red-600' }} text-base">
                                {{ $order->with_driver == 1 ? 'Ya' : 'Tidak' }}
                            </p>
                        </div>

                        <div class="border-t border-gray-300 pt-2">
                            <p class="text-2xl font-bold text-red-600">Total Harga Akhir</p>
                            <p class="text-sm text-gray-500">({{ $sewaHari }} Hari)</p>
                            <p class="text-3xl font-extrabold text-red-700">{{ formatRupiah($order->total_price) }}</p>
                        </div>

                        @if ($order->status === 'unpaid')
                            <div class="flex space-x-4 border-t border-gray-300 pt-4">
                                <form action="/user/rental/{{ $order->id }}/pay" method="POST" class="flex-1">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="w-full rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700">
                                        Bayar Sekarang
                                    </button>
                                </form>
                                <form action="/user/rental/{{ $order->id }}/cancel" method="POST" class="flex-1"
                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if ($order->status == 'paid')
                            <div class="flex gap-2">
                                <button disabled
                                    class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition">
                                    Lunas ✅️
                                </button>
                                <a href="/user/rental/{{ $order->id }}/download-receipt"
                                    class="flex items-center space-x-2 rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white shadow-lg transition hover:bg-blue-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span>Download Struk</span>
                                </a>
                            </div>
                        @endif
                        @if ($order->status == 'cancelled')
                            <button disabled
                                class="w-full rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition">
                                Pesanan Dibatalkan ❌
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-gray-500">
                <p class="text-xl">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ url('/') }}#menu-mobil" class="mt-2 inline-block text-blue-600 hover:underline">Mulai
                    pesan sekarang!</a>
            </div>
        @endforelse

    </div>
</body>

</html>
