<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Add New Car for Rental</title>
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

        .admin-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-width: 1px;
            border-color: #e5e7eb;
        }

        .image-upload {
            width: 100%;
            height: 200px;
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload:hover {
            border-color: #9ca3af;
            background-color: #f9fafb;
        }

        .toggle-btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-btn.active {
            background-color: #22c55e;
            color: white;
        }

        .toggle-btn.inactive {
            background-color: #e5e7eb;
            color: #6b7280;
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
                    <p class="text-xs text-red-200">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>

        <nav class="space-y-1">
            <a href="/" class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Home
            </a>
            <a href="/admin/general-report"
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                General Report
            </a>
            <a href="/admin/add-new-car"
                class="block border-l-4 border-white bg-red-700 px-4 py-3 text-lg font-medium transition duration-150">
                Add New Car
            </a>
            <a href="/admin/car-list"
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Edit Existing Car
            </a>
            <a href="/logout"
                class="absolute bottom-0 block w-full px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Logout
            </a>
        </nav>
    </div>

    <div class="main-content p-8">
        <h1 class="mb-10 text-4xl font-extrabold text-gray-800">Add New Car for Rental</h1>

        {{-- tampilkan error --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-100 p-4 text-red-700">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/admin/add-new-car" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-3 gap-8">
                <!-- Left Column - Form Fields -->
                <div class="col-span-2 space-y-6">

                    <!-- Car Name -->
                    <div class="admin-card">
                        <label class="mb-4 block text-2xl font-bold text-gray-800">Car Name</label>
                        <input type="text" name="name" placeholder="Input Name" required
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-transparent focus:ring-2 focus:ring-red-500">
                    </div>

                    <!-- Price -->
                    <div class="admin-card">
                        <label class="mb-4 block text-2xl font-bold text-gray-800">Price</label>
                        <div class="relative">
                            <input type="number" name="price" placeholder="Input Price" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-transparent focus:ring-2 focus:ring-red-500">
                            <span class="absolute right-4 top-3 font-medium text-gray-500">Rp. Per hari</span>
                        </div>
                    </div>

                    <!-- Spesifikasi -->
                    <div class="admin-card">
                        <h2 class="mb-6 text-2xl font-bold text-gray-800">Spesifikasi</h2>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Transmisi -->
                            <div>
                                <div class="mb-3 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-600">
                                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M7 19h6v-2H7v2zm0-4h10v-2H7v2zm0-6v2h14V9H7zm0-4h14V3H7v2z" />
                                        </svg>
                                    </div>
                                    <label class="text-lg font-semibold text-gray-800">Transmisi</label>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="button" onclick="setTransmission('automatic')"
                                        class="toggle-btn active" id="btn-automatic">Automatic</button>
                                    <button type="button" onclick="setTransmission('manual')"
                                        class="toggle-btn inactive" id="btn-manual">Manual</button>
                                </div>
                                <input type="hidden" name="transmission" id="transmission" value="automatic">
                            </div>

                            <!-- Bagasi -->
                            <div>
                                <div class="mb-3 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-600">
                                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17 6h-2V3H9v3H7c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2 0 .55.45 1 1 1s1-.45 1-1h6c0 .55.45 1 1 1s1-.45 1-1c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM9 5h6v1H9V5zm8 14H7V8h10v11z" />
                                        </svg>
                                    </div>
                                    <label class="text-lg font-semibold text-gray-800">Bagasi</label>
                                </div>
                                <input type="number" name="baggage" placeholder="Input Number" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-transparent focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- Tempat Duduk -->
                            <div>
                                <div class="mb-3 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-600">
                                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4 18v3h3v-3h10v3h3v-6H4v3zm15-8h3v3h-3v-3zM2 10h3v3H2v-3zm15 3H7V5c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2v8z" />
                                        </svg>
                                    </div>
                                    <label class="text-lg font-semibold text-gray-800">Tempat duduk</label>
                                </div>
                                <input type="number" name="seats" placeholder="Input Number" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-transparent focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- Bahan Bakar -->
                            <div>
                                <div class="mb-3 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-600">
                                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M19.77 7.23l.01-.01-3.72-3.72L15 4.56l2.11 2.11c-.94.36-1.61 1.26-1.61 2.33 0 1.38 1.12 2.5 2.5 2.5.36 0 .69-.08 1-.21v7.21c0 .55-.45 1-1 1s-1-.45-1-1V14c0-1.1-.9-2-2-2h-1V5c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v16h10v-7.5h1.5v5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V9c0-.69-.28-1.32-.73-1.77zM12 10H6V5h6v5z" />
                                        </svg>
                                    </div>
                                    <label class="text-lg font-semibold text-gray-800">Bahan Bakar</label>
                                </div>
                                <select name="fuel_type" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-transparent focus:ring-2 focus:ring-red-500">
                                    <option value="">Select Fuel Type</option>
                                    <option value="bensin">Bensin</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>

                            <!-- Warna -->
                            <div>
                                <div class="mb-3 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-300">
                                        <span class="text-2xl text-gray-600">?</span>
                                    </div>
                                    <label class="text-lg font-semibold text-gray-800">Warna</label>
                                </div>
                                <input type="color" name="color" required
                                    class="h-12 w-full rounded-lg border border-gray-300 px-2 py-1 focus:border-transparent focus:ring-2 focus:ring-red-500">
                            </div>


                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="/admin/edit-car"
                            class="rounded-lg bg-gray-300 px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit"
                            class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">
                            Save Car
                        </button>
                    </div>
                </div>

                <!-- Right Column - Image Uploads -->
                <div class="space-y-6">
                    <div class="admin-card">
                        <label class="image-upload" for="image1">
                            <div class="text-center">
                                <svg class="mx-auto mb-2 h-16 w-16 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-lg text-gray-500">Add Image</span>
                            </div>
                        </label>
                        <input type="file" id="image1" name="images[]" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'preview1')">
                        <img id="preview1" class="mt-3 hidden h-48 w-full rounded-lg object-cover">
                    </div>

                    <div class="admin-card">
                        <label class="image-upload" for="image2">
                            <div class="text-center">
                                <svg class="mx-auto mb-2 h-16 w-16 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-lg text-gray-500">Add Image</span>
                            </div>
                        </label>
                        <input type="file" id="image2" name="images[]" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'preview2')">
                        <img id="preview2" class="mt-3 hidden h-48 w-full rounded-lg object-cover">
                    </div>

                    <div class="admin-card">
                        <label class="image-upload" for="image3">
                            <div class="text-center">
                                <svg class="mx-auto mb-2 h-16 w-16 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span class="text-lg text-gray-500">Add Image</span>
                            </div>
                        </label>
                        <input type="file" id="image3" name="images[]" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'preview3')">
                        <img id="preview3" class="mt-3 hidden h-48 w-full rounded-lg object-cover">
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{--
        JavaScript untuk Toggle Buttons dan Preview Gambar
        Menangani interaksi UI pada form tambah mobil
    --}}
    <script>
        /**
         * Set jenis transmisi dan update tampilan tombol
         * @param {string} type - Jenis transmisi ('automatic' atau 'manual')
         */
        function setTransmission(type) {
            // Set value hidden input untuk dikirim ke server
            document.getElementById('transmission').value = type;

            // Update tampilan tombol Automatic
            document.getElementById('btn-automatic').classList.toggle('active', type === 'automatic');
            document.getElementById('btn-automatic').classList.toggle('inactive', type !== 'automatic');

            // Update tampilan tombol Manual
            document.getElementById('btn-manual').classList.toggle('active', type === 'manual');
            document.getElementById('btn-manual').classList.toggle('inactive', type !== 'manual');
        }

        /**
         * Preview gambar sebelum upload
         * @param {HTMLInputElement} input - Input file yang berisi gambar
         * @param {string} previewId - ID elemen img untuk menampilkan preview
         */
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);

            // Cek apakah ada file yang dipilih
            if (input.files && input.files[0]) {
                // FileReader untuk membaca file sebagai Data URL
                const reader = new FileReader();

                // Callback saat file selesai dibaca
                reader.onload = function(e) {
                    // Set src img dengan Data URL dari file
                    preview.src = e.target.result;
                    // Tampilkan preview (hilangkan class 'hidden')
                    preview.classList.remove('hidden');
                }

                // Mulai membaca file sebagai Data URL (base64)
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
