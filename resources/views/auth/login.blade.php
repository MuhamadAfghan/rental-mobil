<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | S4B Rent Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex min-h-screen items-center justify-center bg-red-600 p-4">

    <div class="w-full max-w-sm rounded-xl bg-white p-8 shadow-2xl">

        <h2 class="mb-8 text-center text-3xl font-bold">Login</h2>

        {{-- Menampilkan error apabila akun tidak valid --}}
        @error('email')
            <div class="mb-4 text-sm text-red-600">{{ $message }}</div>
        @enderror

        <form method="POST" action="/login">
            @csrf <div class="mb-5">
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                    Username / Email
                </label>
                <input type="text" id="email" name="email" placeholder="Masukkan Username atau Email" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 transition duration-150 focus:border-red-500 focus:ring-red-500">
            </div>

            <div class="mb-6">
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                    Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Password" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 pr-10 transition duration-150 focus:border-red-500 focus:ring-red-500">
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full transform rounded-lg bg-red-600 py-3 font-semibold text-white shadow-md transition duration-300 hover:scale-[1.01] hover:bg-red-700">
                Login
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">Belum punya akun?</p>
            <a href="/register" class="text-sm font-medium text-red-600 transition duration-150 hover:text-red-800">
                Create an account
            </a>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function(e) {
            e.preventDefault();
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Anda bisa menambahkan logika untuk mengubah ikon mata di sini jika perlu
        });
    </script>

</body>

</html>
