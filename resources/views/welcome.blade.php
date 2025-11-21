<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S4B Rent Car - Drive Your Way</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Tambahan untuk gradien overlay dari sebelumnya */
        .hero-overlay {
            background: linear-gradient(to right, rgba(0, 0, 0, 1) 40%, rgba(0, 0, 0, 0) 100%);
        }

        /* Efek Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-100">

    {{-- Icon WhatsApp --}}
    <a href="https://wa.me/+6285520950976" target="_blank"
        class="fixed bottom-6 right-6 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-green-500 shadow-lg transition-transform duration-300 hover:scale-105">

        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-6 w-6 text-white" viewBox="0 0 16 16">
            <path
                d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
        </svg>
    </a>

    <nav class="fixed z-10 w-full bg-red-600 py-4">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

            <a href="/" class="flex items-center text-xl font-bold tracking-widest text-red-600">
                <div class="rounded bg-white px-2 py-1 shadow-lg">
                    <span class="text-sm font-black italic">S4B</span>
                </div>
                <span class="ml-2 hidden text-xs font-semibold uppercase text-white sm:block">Rent Car Service</span>
            </a>

            <div class="flex items-center space-x-6 font-medium text-white">
                <a href="/" class="transition duration-300">Home</a>
                <a href="#about-us" class="transition duration-300">About Us</a>
                <a href="#vision-mission" class="transition duration-300">Visi & Misi</a>
                <a href="#menu-mobil" class="transition duration-300">Menu</a>
                <a href="#contact" class="transition duration-300">Contact</a>

                <a href="/login" class="flex items-center space-x-1 transition duration-300">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>
                        @auth
                            Dashboard
                        @else
                            Login
                        @endauth
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <header class="relative h-screen w-full overflow-hidden">
        <div class="absolute inset-0 bg-black bg-cover bg-center"
            style="background-image: url('images/image-1763205858233.png'); background-opacity: 0.7;">

            {{-- <div class="absolute inset-0 bg-black bg-opacity-30"></div> --}}

            {{-- <div class="hero-overlay absolute inset-0"></div> --}}
        </div>

        <div class="absolute left-0 top-0 flex h-full w-full items-center">
            <div class="mx-auto flex w-full max-w-7xl justify-between px-4 sm:px-6 lg:px-8">

                <div class="flex h-full w-full flex-col justify-center p-4 text-white md:w-1/2">
                    <p class="text-6xl font-extrabold leading-none tracking-tight sm:text-7xl lg:text-8xl">
                        Drive Your Way
                    </p>
                    <a href="/#menu-mobil"
                        class="mt-8 w-max transform rounded bg-red-600 px-8 py-3 font-semibold text-white shadow-xl transition duration-300 hover:scale-105 hover:bg-red-700">
                        Book Now
                    </a>
                </div>

                <div class="absolute bottom-10 right-10 hidden md:block">
                    <span class="text-5xl font-black text-white lg:text-7xl"
                        style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                        TOYOTA CAMRY
                    </span>
                </div>

            </div>
        </div>
    </header>

    </header>

    <section id="about-us" class="bg-gray-100 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-blue-100 bg-white shadow-lg">
                <div class="flex flex-col lg:flex-row">

                    <div class="space-y-4 p-4 lg:w-1/2 lg:p-8">

                        <div class="overflow-hidden rounded-lg border-4 border-blue-500 shadow-md">
                            <img src="images/image-1763181313533.png" alt="Logo S4B Sukses Abadi Bersama di Billboard"
                                class="h-auto w-full object-cover">
                        </div>

                        <div class="flex space-x-4">
                            <div class="w-1/2 overflow-hidden rounded-lg shadow-md">
                                <img src="images/image-1763205871540.png" alt="Logo S4B di Gedung"
                                    class="h-auto w-full object-cover">
                            </div>
                            <div class="w-1/2 overflow-hidden rounded-lg shadow-md">
                                <img src="images/image-1763205883183.png" alt="Deretan Mobil Rental S4B"
                                    class="h-auto w-full object-cover">
                            </div>
                        </div>

                    </div>

                    <div class="p-8 lg:w-1/2 lg:p-12">
                        <h2 class="mb-6 text-4xl font-bold text-gray-800">Tentang PT. Sukses Abadi Bersama</h2>
                        <div class="space-y-4 text-justify text-gray-600">
                            <p>
                                **PT. Sukses Abadi Bersama** adalah perusahaan jasa rental mobil yang berkomitmen
                                memberikan layanan transportasi yang **aman, nyaman, dan terpercaya**. Sejak berdiri,
                                kami terus berupaya menghadirkan armada kendaraan yang terawat, pilihan mobil yang
                                beragam, serta pelayanan ramah dan profesional untuk memenuhi kebutuhan perjalanan
                                pribadi, bisnis, maupun keperluan khusus lainnya.
                            </p>
                            <p>
                                Dengan dukungan tim yang berpengalaman dan sistem pemesanan yang mudah, kami ingin
                                memastikan setiap pelanggan mendapatkan pengalaman berkendara yang menyenangkan, tepat
                                waktu, dan sesuai anggaran. **Kepercayaan pelanggan adalah prioritas kami**, sehingga
                                kualitas layanan dan keamanan selalu menjadi fokus utama.
                            </p>
                            <p>
                                Baik untuk perjalanan harian, liburan keluarga, perjalanan dinas, atau acara spesial,
                                **PT. Sukses Abadi Bersama** siap menjadi partner transportasi yang dapat diandalkan.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    </section>

    <section id="vision-mission" class="bg-gray-100 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl bg-red-600 p-8 text-white shadow-2xl md:p-12">

                <div class="mb-10 text-center">
                    <h2 class="relative inline-block pb-2 text-5xl font-extrabold">
                        Visi & Misi
                        <span class="absolute bottom-0 left-0 right-0 h-1 bg-blue-400"></span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-12">

                    <div>
                        <h3 class="mb-4 text-4xl font-bold">Visi Kami</h3>
                        <p class="text-lg leading-relaxed text-red-100">
                            Menjadi perusahaan rental mobil terpercaya yang memberikan layanan transportasi terbaik,
                            aman, dan nyaman, serta menjadi pilihan utama pelanggan di seluruh Indonesia.
                        </p>
                    </div>

                    <div>
                        <h3 class="mb-4 text-4xl font-bold">Misi Kami</h3>
                        <p class="text-lg leading-relaxed text-red-100">
                            Menyediakan armada kendaraan yang selalu bersih, terawat, dan siap digunakan dan memberikan
                            pelayanan ramah, cepat, dan profesional demi kepuasan pelanggan.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </section>

    </section>

    <section id="menu-mobil" class="bg-white py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-12 text-center text-4xl font-extrabold text-gray-800 lg:text-5xl">
                Pilih Kendaraan Anda
            </h2>

            @if ($cars->count() > 0)
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($cars as $car)
                        @php
                            $images = json_decode($car->images);
                            $firstImage =
                                $images && count($images) > 0
                                    ? asset('storage/' . $images[0])
                                    : 'https://via.placeholder.com/400x300?text=No+Image';
                        @endphp

                        <div
                            class="transform rounded-lg border border-gray-200 bg-white p-4 shadow-md transition duration-300 hover:scale-[1.01] hover:border-4 hover:border-blue-500 hover:shadow-xl">
                            <div class="rounded-lg bg-white p-4">

                                <h3 class="mb-4 text-center text-xl font-bold">{{ $car->name }}</h3>

                                <div class="mb-4 flex items-center space-x-4">
                                    <div class="w-1/2">
                                        <img src="{{ $firstImage }}" alt="{{ $car->name }}"
                                            class="h-32 w-full rounded object-cover">
                                    </div>

                                    <div class="w-1/2 text-right">
                                        <p class="text-sm font-semibold text-gray-800">Rp
                                            {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                                        <p class="mb-2 text-sm text-gray-500">Per hari</p>
                                        <p class="text-sm font-medium text-green-600">Pembatalan Gratis</p>

                                        @if ($car->is_available)
                                            <a href="{{ url('/car-detail/' . $car->id) }}"
                                                class="mt-2 block w-full rounded bg-red-600 py-1.5 text-center text-sm font-semibold text-white transition hover:bg-red-700">
                                                Lihat Tawaran
                                            </a>
                                        @else
                                            <button disabled
                                                class="mt-2 block w-full cursor-not-allowed rounded bg-gray-400 py-1.5 text-center text-sm font-semibold text-white opacity-70">
                                                Sedang Disewa
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <div class="rounded-full bg-red-600 p-1 text-white">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
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
                                                    d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
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
                                            <p class="text-xs text-gray-500">Ya/Tidak</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <p class="text-xl text-gray-500">Belum ada mobil tersedia</p>
                </div>
            @endif

        </div>
    </section>

    </section>

    <section id="contact" class="bg-gray-900 py-16 text-white lg:py-24"
        style="background-image: url('URL_GAMBAR_BACKGROUND_GELAP'); background-size: cover; background-attachment: fixed;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-12 text-center text-4xl font-extrabold lg:text-5xl">
                Contacts
            </h2>

            <div class="grid grid-cols-1 gap-12 border-t border-gray-700 pt-8 md:grid-cols-3">

                <div>
                    <h3 class="mb-6 text-xl font-bold text-red-500">Call Center</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xl font-semibold">+62 812-xxxx-xxxx</p>
                            <p class="text-sm text-gray-400">admin</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold">+62 812-xxxx-xxxx</p>
                            <p class="text-sm text-gray-400">admin</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold">+62 812-xxxx-xxxx</p>
                            <p class="text-sm text-gray-400">admin</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="mb-6 text-xl font-bold text-red-500">Address</h3>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Alamat :</span> Jl.Jalanin aja dulu</p>
                        <p><span class="font-semibold">Zip :</span> 50111</p>
                        <p><span class="font-semibold">Kota :</span> Semarang</p>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="#" class="text-2xl text-gray-400 transition duration-200 hover:text-white">
                            💬
                        </a>
                        <a href="#" class="text-2xl text-gray-400 transition duration-200 hover:text-white">
                            📘
                        </a>
                        <a href="#" class="text-2xl text-gray-400 transition duration-200 hover:text-white">
                            🐦
                        </a>
                        <a href="#" class="text-2xl text-gray-400 transition duration-200 hover:text-white">
                            📸
                        </a>
                        <a href="#" class="text-2xl text-gray-400 transition duration-200 hover:text-white">
                            ➕
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="mb-6 text-xl font-bold text-red-500">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="#" class="block transition duration-200 hover:text-red-500">Homepage</a>
                        <a href="#about-us" class="block transition duration-200 hover:text-red-500">Tentang Kami</a>
                        <a href="#menu-mobil" class="block transition duration-200 hover:text-red-500">Pilihan
                            Kendaraan</a>
                        <a href="/login" class="block transition duration-200 hover:text-red-500">Login</a>
                    </div>
                </div>

            </div>

            <div class="mt-12 border-t border-gray-800 pt-4 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} PT. Sukses Abadi Bersama. All Rights Reserved.
            </div>

        </div>
    </section>

    </section>

    <section id="admin-area" class="hidden bg-gray-100 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="mb-10 text-4xl font-extrabold text-gray-800">Admin Dashboard (Simulasi)</h1>

            <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
                    <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-800">45</p>
                    <p class="mt-2 text-xs text-green-500">+12% Bulan Lalu</p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
                    <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-800">Rp 65 Jt</p>
                    <p class="mt-2 text-xs text-red-500">-5% Bulan Lalu</p>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
                    <p class="text-sm font-medium text-gray-500">Mobil Tersedia</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-800">18/20</p>
                    <p class="mt-2 text-xs text-blue-500">2 unit disewa</p>
                </div>
            </div>

        </div>
    </section>

</body>

</html>

</body>

</html>

</body>

</html>

</body>

</html>

</body>

</html>

</body>

</html>
