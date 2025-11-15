<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $car->name }} | S4B Rent Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100">

    <div class="mx-auto max-w-6xl px-4 pb-16 sm:px-6 lg:px-8">

        <body class="min-h-screen bg-gray-100">

            <div class="mx-auto max-w-6xl px-4 pt-8 sm:px-6 lg:px-8">
                <button onclick="window.history.back()"
                    class="flex items-center font-medium text-gray-600 transition duration-200 hover:text-red-600">
                    <svg class="mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </button>
            </div>

            <div class="mx-auto max-w-6xl px-4 pb-16 sm:px-6 lg:px-8">

                <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">

                    <div class="rounded-xl bg-white p-8 shadow-2xl lg:p-12">

                        <div class="flex flex-col gap-10 lg:flex-row">
                            <div class="lg:w-3/5">
                                @php
                                    $images = json_decode($car->images);
                                    $mainImage =
                                        $images && count($images) > 0
                                            ? asset('storage/' . $images[0])
                                            : 'https://via.placeholder.com/800x600?text=No+Image';
                                @endphp
                                <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 shadow-lg">
                                    <img src="{{ $mainImage }}" alt="{{ $car->name }}"
                                        class="h-auto w-full object-cover" id="main-image">
                                </div>

                                <div class="flex justify-start space-x-4">
                                    @if ($images && count($images) > 0)
                                        @foreach ($images as $index => $image)
                                            <div class="{{ $index === 0 ? 'border-2 border-red-600' : 'border border-gray-300' }} thumbnail h-24 w-24 cursor-pointer overflow-hidden rounded-lg border transition hover:border-red-600"
                                                onclick="changeImage('{{ asset('storage/' . $image) }}', this)">
                                                <img src="{{ asset('storage/' . $image) }}"
                                                    alt="Thumbnail {{ $index + 1 }}"
                                                    class="h-full w-full object-cover">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="lg:w-2/5">

                                <h1 class="text-4xl font-extrabold text-gray-900">{{ $car->name }}</h1>
                                <p class="mt-2 text-2xl font-semibold text-gray-800">Rp
                                    {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                                <p class="mb-8 text-sm text-gray-500">Per hari</p>

                                <h2 class="mb-4 text-2xl font-bold text-gray-900">Spesifikasi</h2>

                                <div class="grid grid-cols-2 gap-x-8 gap-y-6 text-sm">

                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full bg-red-600 p-1 text-white">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                            </svg>
                                        </div>
                                        <div class="leading-none">
                                            <p class="font-medium">Transmisi</p>
                                            <p class="text-xs text-gray-500">{{ ucfirst($car->transmission) }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full bg-red-600 p-1 text-white">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                            </svg>
                                        </div>
                                        <div class="leading-none">
                                            <p class="font-medium">Bagasi</p>
                                            <p class="text-xs text-gray-500">{{ $car->baggage }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full bg-red-600 p-1 text-white">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                        </div>
                                        <div class="leading-none">
                                            <p class="font-medium">Tempat duduk</p>
                                            <p class="text-xs text-gray-500">{{ $car->seats }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full bg-red-600 p-1 text-white">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="leading-none">
                                            <p class="font-medium">Bahan Bakar</p>
                                            <p class="text-xs text-gray-500">{{ ucfirst($car->fuel_type) }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full p-1 text-white"
                                            style="background-color: {{ $car->color }}">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="leading-none">
                                            <p class="font-medium">Warna</p>
                                            <p class="text-xs text-gray-500">{{ $car->color }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full bg-red-600 p-1 text-white">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="leading-none">
                                            <p class="font-medium">Pengemudi</p>
                                            <p class="text-xs text-gray-500">{{ $car->driver ? 'Ya' : 'Tidak' }}</p>
                                        </div>
                                    </div>

                                </div>

                                <a href="{{ url('/order/' . $car->id) }}"
                                    class="mt-8 block w-full rounded-lg bg-red-600 py-3 text-center text-lg font-semibold text-white shadow-lg transition duration-300 hover:bg-red-700">PESAN</a>

                            </div>
                        </div>

                    </div>

                </div>

                {{--
                    JavaScript untuk Image Gallery
                    Mengubah gambar utama saat thumbnail diklik
                --}}
                <script>
                    /**
                     * Fungsi untuk mengganti gambar utama dan update border thumbnail
                     * @param {string} imageUrl - URL gambar yang akan ditampilkan
                     * @param {HTMLElement} element - Elemen thumbnail yang diklik
                     */
                    function changeImage(imageUrl, element) {
                        // Update gambar utama dengan gambar dari thumbnail yang diklik
                        document.getElementById('main-image').src = imageUrl;

                        // Hapus border aktif dari semua thumbnail
                        // querySelectorAll() mengambil semua elemen dengan class 'thumbnail'
                        document.querySelectorAll('.thumbnail').forEach(thumb => {
                            thumb.classList.remove('border-2', 'border-red-600'); // Hapus border tebal merah
                            thumb.classList.add('border', 'border-gray-300'); // Tambah border tipis abu-abu
                        });

                        // Tambahkan border aktif ke thumbnail yang diklik
                        element.classList.remove('border', 'border-gray-300'); // Hapus border abu-abu
                        element.classList.add('border-2', 'border-red-600'); // Tambah border tebal merah
                    }
                </script>
        </body>

</html>
