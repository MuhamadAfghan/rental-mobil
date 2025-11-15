<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pemesanan | S4B Rent Car</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #dc2626;
        }

        .booking-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .booking-info p {
            margin: 5px 0;
        }

        .status-badges {
            text-align: center;
            margin: 15px 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 10px;
            color: white;
            margin: 0 5px;
        }

        .badge-success {
            background-color: #4ade80;
        }

        .badge-warning {
            background-color: #6b7280;
        }

        .content {
            margin-top: 20px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .detail-row {
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: bold;
            color: #000;
        }

        .detail-value {
            color: #555;
        }

        .total-section {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }

        .total-price {
            font-size: 20px;
            font-weight: bold;
            color: #dc2626;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .grid {
            display: table;
            width: 100%;
        }

        .grid-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }
    </style>
</head>

<body>

    {{--
        Helper Functions PHP untuk PDF
        Functions yang sama dengan receipt.blade.php tapi untuk PDF
    --}}
    @php
        /**
         * Format angka menjadi format Rupiah untuk PDF
         */
        function formatRupiah($number)
        {
            return 'Rp ' . number_format($number, 0, ',', '.');
        }

        /**
         * Menghitung jumlah hari sewa
         */
        function calculateDays($pickupDate, $returnDate)
        {
            $pickup = new DateTime($pickupDate);
            $return = new DateTime($returnDate);
            return $pickup->diff($return)->days ?: 1;
        }

        // Kalkulasi untuk ditampilkan di PDF
        $sewaHari = calculateDays($order->pickup_date, $order->return_date);
        $hasDriver = $order->car->driver == 1;
    @endphp

    <div class="header">
        <h1>S4B RENT CAR</h1>
        <p>STRUK PEMESANAN MOBIL</p>
    </div>

    <div class="booking-info">
        <p style="font-size: 14px; font-weight: bold;">Booking ID: {{ $order->so_number }}</p>
        <p>Tanggal Transaksi: {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i') }}</p>
        <div class="status-badges">
            <span class="badge badge-success">Berhasil</span>
            <span class="badge badge-warning">Menunggu konfirmasi admin</span>
        </div>
    </div>

    <div class="content">
        <div class="grid">
            <div class="grid-col">
                <div class="section">
                    <div class="section-title">Data Pemesan</div>
                    <div class="detail-row">
                        <div class="detail-label">Username</div>
                        <div class="detail-value">{{ $order->user->username }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $order->user->email }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">No. Telepon</div>
                        <div class="detail-value">{{ $order->user->phone_number ?? '-' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tgl Transaksi</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid-col">
                <div class="section">
                    <div class="section-title">Detail Pesanan</div>
                    <div class="detail-row">
                        <div class="detail-label">Mobil Dipesan</div>
                        <div class="detail-value">{{ $order->car->name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Lokasi Pengambilan</div>
                        <div class="detail-value">{{ $order->pickup_location }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Sewa</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}
                            ({{ \Carbon\Carbon::parse($order->pickup_time)->format('h:i A') }})
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Kembali</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($order->return_date)->format('d M Y') }}
                            ({{ \Carbon\Carbon::parse($order->return_time)->format('h:i A') }})
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Supir</div>
                        <div class="detail-value" style="color: {{ $hasDriver ? '#16a34a' : '#dc2626' }}">
                            {{ $hasDriver ? 'Ya' : 'Tidak' }}
                        </div>
                    </div>

                    <div class="total-section">
                        <div class="detail-label" style="font-size: 14px;">Total Harga Akhir</div>
                        <div style="font-size: 10px; color: #666;">({{ $sewaHari }} Hari)</div>
                        <div class="total-price">{{ formatRupiah($order->total_price) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan S4B Rent Car</p>
        <p>Untuk informasi lebih lanjut, silakan hubungi customer service kami</p>
    </div>

</body>

</html>
