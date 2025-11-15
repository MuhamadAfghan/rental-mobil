<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan | S4B Rent Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="mx-auto max-w-4xl px-4 pt-8 sm:px-6 lg:px-8">
        <div class="mb-10 flex items-center justify-between">
            <a href="javascript:history.back()" class="text-gray-600 transition duration-200 hover:text-red-600">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="absolute left-1/2 -translate-x-1/2 transform text-4xl font-extrabold text-gray-900">Pesanan</h1>
            <div class="h-8 w-8"></div>
        </div>

        <form method="POST" action="/order/{{ $car->id }}" class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            @csrf <div class="space-y-8">

                <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-lg">
                    <h2 class="text-3xl font-bold text-gray-800">Data Pribadi</h2>
                    <p class="mb-6 text-sm">*hanya dapat diubah melalui halaman profil</p>

                    <div class="space-y-4 text-lg">

                        <div>
                            <label for="username" class="block font-bold text-gray-900">Username</label>
                            <input type="text" id="username" name="username" value="{{ auth()->user()->username }}"
                                readonly
                                class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="email" class="block font-bold text-gray-900">Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                readonly
                                class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="whatsapp" class="block font-bold text-gray-900">No. Whatsapp</label>
                            <input type="tel" id="whatsapp" name="whatsapp"
                                value="{{ auth()->user()->phone_number }}" readonly placeholder="No whatsappp"
                                class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                        </div>

                    </div>
                </div>

                <button type="submit"
                    class="w-full transform rounded-xl bg-red-600 py-4 font-extrabold text-white shadow-xl transition duration-300 hover:scale-[1.01] hover:bg-red-700">
                    Payment
                </button>

                <div class="flex justify-center space-x-4">
                    <span class="text-xs text-gray-500">DANA</span>
                    <span class="text-xs text-gray-500">OVO</span>
                    <span class="text-xs text-gray-500">Gopay</span>
                    <span class="text-xs text-gray-500">Mandiri</span>
                    <span class="text-xs text-gray-500">VISA</span>
                    <span class="text-xs text-gray-500">Mastercard</span>
                </div>
            </div>

            <div class="rounded-xl border-2 border-blue-500 bg-white p-8 shadow-lg">
                <h2 class="mb-6 text-3xl font-bold text-gray-800">Pesanan</h2>

                <div class="space-y-6 text-lg">

                    <div>
                        <p class="font-bold text-gray-900">Mobil yang dipesan</p>
                        <p class="text-base text-gray-600">{{ $car->name }}</p>
                        <input type="hidden" name="car_name" value="{{ $car->name }}">
                    </div>

                    <div>
                        <label for="pickup_location" class="block font-bold text-gray-900">Lokasi Pick-up</label>
                        <input type="text" id="pickup_location" name="pickup_location" value="" required
                            class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="pickup_date" class="block font-bold text-gray-900">Tanggal Pick-up</label>
                        <input type="date" id="pickup_date" name="pickup_date" value="" required
                            class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="pickup_time" class="block font-bold text-gray-900">Waktu Pick-up</label>
                        <input type="time" id="pickup_time" name="pickup_time" value="" required
                            class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="return_date" class="block font-bold text-gray-900">Tanggal Return</label>
                        <input type="date" id="return_date" name="return_date" value="" required
                            class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="return_time" class="block font-bold text-gray-900">Waktu Return</label>
                        <input type="time" id="return_time" name="return_time" value="" required
                            class="w-full border-b border-gray-300 pt-1 text-base text-gray-600 focus:border-red-500 focus:outline-none">
                    </div>


                    <div class="rounded-lg bg-red-50 p-6">
                        <div class="mb-3 flex justify-between">
                            <p class="text-base font-semibold text-gray-700">Harga per hari:</p>
                            <p class="text-base font-bold text-gray-900" id="price-per-day">Rp
                                {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                        </div>
                        <div class="mb-3 flex justify-between">
                            <p class="text-base font-semibold text-gray-700">Durasi sewa:</p>
                            <p class="text-base font-bold text-gray-900" id="rental-duration">0 hari</p>
                        </div>
                        <hr class="my-4 border-gray-300">
                        <div class="flex justify-between">
                            <p class="text-xl font-extrabold text-gray-900">Total Pembayaran:</p>
                            <p class="text-xl font-extrabold text-red-600" id="total-payment">Rp 0</p>
                        </div>
                    </div>
                    <input type="hidden" name="total_payment" id="total_payment_input" value="0">
                    <input type="hidden" name="rental_days" id="rental_days_input" value="0">

                </div>
            </div>

        </form>
    </div>

    <script>
        const pricePerDay = {{ $car->price_per_day }};
        const pickupDateInput = document.getElementById('pickup_date');
        const returnDateInput = document.getElementById('return_date');
        const rentalDurationEl = document.getElementById('rental-duration');
        const totalPaymentEl = document.getElementById('total-payment');
        const totalPaymentInput = document.getElementById('total_payment_input');
        const rentalDaysInput = document.getElementById('rental_days_input');

        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        function calculateTotal() {
            const pickupDate = new Date(pickupDateInput.value);
            const returnDate = new Date(returnDateInput.value);

            if (pickupDateInput.value && returnDateInput.value && returnDate >= pickupDate) {
                // Hitung selisih hari
                const timeDiff = returnDate.getTime() - pickupDate.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                // Minimal 1 hari
                const rentalDays = dayDiff === 0 ? 1 : dayDiff;

                // Hitung total
                const total = pricePerDay * rentalDays;

                // Update tampilan
                rentalDurationEl.textContent = rentalDays + ' hari';
                totalPaymentEl.textContent = formatRupiah(total);
                totalPaymentInput.value = total;
                rentalDaysInput.value = rentalDays;
            } else {
                // Reset jika tanggal tidak valid
                rentalDurationEl.textContent = '0 hari';
                totalPaymentEl.textContent = 'Rp 0';
                totalPaymentInput.value = 0;
                rentalDaysInput.value = 0;
            }
        }

        // Event listeners untuk update otomatis
        pickupDateInput.addEventListener('change', calculateTotal);
        returnDateInput.addEventListener('change', calculateTotal);

        // Set minimum date untuk pickup (hari ini)
        const today = new Date().toISOString().split('T')[0];
        pickupDateInput.setAttribute('min', today);

        // Set minimum date untuk return berdasarkan pickup
        pickupDateInput.addEventListener('change', function() {
            returnDateInput.setAttribute('min', this.value);
            if (returnDateInput.value && returnDateInput.value < this.value) {
                returnDateInput.value = '';
            }
        });
    </script>

</body>

</html>
