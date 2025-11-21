<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | S4B Rent Car</title>
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

        .profile-card {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-width: 1px;
            border-color: #e5e7eb;
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
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Riwayat Pesanan
            </a>
            <a href="/user/profile"
                class="block border-l-4 border-white bg-red-700 px-4 py-3 text-lg font-medium transition duration-150">
                Profil Saya
            </a>
            <a href="/logout"
                class="absolute bottom-0 block w-full px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Logout
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="p-8">
            <h1 class="mb-10 text-4xl font-extrabold text-gray-800">Profil Saya</h1>

            {{-- tampilkan success message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

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

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Left Column - Profile Info -->
                <div class="profile-card">
                    <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Informasi Profil</h2>
                        <button onclick="toggleEdit()" id="btn-edit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700">
                            Edit Profil
                        </button>
                    </div>

                    <form action="/user/profile" method="POST" id="profile-form">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Username -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Username</label>
                                <input type="text" name="username"
                                    value="{{ old('username', auth()->user()->username) }}" readonly id="input-username"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-600 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- Name -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    readonly id="input-name"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-600 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    readonly id="input-email"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-600 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">No. Telepon</label>
                                <input type="tel" name="phone_number"
                                    value="{{ old('phone_number', auth()->user()->phone_number) }}" readonly
                                    id="input-phone"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-600 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Alamat</label>
                                <textarea name="address" rows="3" readonly id="input-address"
                                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-600 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('address', auth()->user()->address) }}</textarea>
                            </div>

                            <!-- Submit Buttons (Hidden by default) -->
                            <div class="hidden space-x-4" id="btn-actions">
                                <button type="button" onclick="cancelEdit()"
                                    class="rounded-lg bg-gray-300 px-6 py-3 font-semibold text-gray-700 transition hover:bg-gray-400">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Column - Change Password -->
                <div class="profile-card">
                    <h2 class="mb-6 border-b border-gray-200 pb-4 text-2xl font-bold text-gray-800">Ubah Password</h2>

                    <form action="/user/change-password" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Current Password -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Password Lama</label>
                                <input type="password" name="current_password" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <!-- New Password -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Password Baru</label>
                                <input type="password" name="new_password" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label class="mb-2 block text-lg font-bold text-gray-900">Konfirmasi Password
                                    Baru</label>
                                <input type="password" name="new_password_confirmation" required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>

                            <button type="submit"
                                class="w-full rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{--
        JavaScript untuk Toggle Edit Mode
        Mengaktifkan/menonaktifkan mode edit profil
    --}}
    <script>
        /**
         * Fungsi untuk mengaktifkan mode edit
         * Mengubah input dari readonly menjadi editable
         */
        function toggleEdit() {
            // Ambil semua input field yang akan diedit
            const inputs = [
                document.getElementById('input-username'),
                document.getElementById('input-name'),
                document.getElementById('input-email'),
                document.getElementById('input-phone'),
                document.getElementById('input-address')
            ];

            const btnEdit = document.getElementById('btn-edit');
            const btnActions = document.getElementById('btn-actions');

            // Loop semua input dan aktifkan mode edit
            inputs.forEach(input => {
                // Hapus atribut readonly agar input bisa diedit
                input.removeAttribute('readonly');

                // Ubah styling dari disabled ke enabled
                input.classList.remove('bg-gray-100', 'text-gray-600'); // Hapus style readonly
                input.classList.add('bg-white', 'text-gray-900'); // Tambah style editable
            });

            // Sembunyikan tombol "Edit Profil"
            btnEdit.classList.add('hidden');

            // Tampilkan tombol "Simpan" dan "Batal"
            btnActions.classList.remove('hidden');
            btnActions.classList.add('flex');
        }

        /**
         * Fungsi untuk membatalkan edit
         * Reload halaman untuk reset semua perubahan
         */
        function cancelEdit() {
            // Reload halaman untuk membatalkan semua perubahan
            location.reload();
        }
    </script>

</body>

</html>
