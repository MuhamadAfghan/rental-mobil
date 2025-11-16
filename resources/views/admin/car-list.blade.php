<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Car List</title>
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

        .car-image {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
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
            <a href="/admin/general-report"
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                General Report
            </a>
            <a href="/admin/add-new-car"
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Add New Car
            </a>
            <a href="/admin/car-list"
                class="block border-l-4 border-white bg-red-700 px-4 py-3 text-lg font-medium transition duration-150">
                Edit Existing Car
            </a>
            <a href="/logout"
                class="absolute bottom-0 block w-full px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
                Logout
            </a>
        </nav>
    </div>

    <div class="main-content p-8">
        <div class="mb-10 flex items-center justify-between">
            <h1 class="text-4xl font-extrabold text-gray-800">Car List</h1>
            <a href="/admin/add-new-car"
                class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">
                + Add New Car
            </a>
        </div>

        {{-- tampilkan success message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="admin-card">
            @if ($cars->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Image</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Car Name</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Price/Day</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Transmission</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Seats</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Fuel Type</th>
                                <th class="px-4 py-3 text-left text-sm font-bold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cars as $car)
                                <tr class="border-b border-gray-100 transition hover:bg-gray-50">
                                    <td class="px-4 py-4">
                                        @php
                                            $images = json_decode($car->images);
                                            $firstImage = $images && count($images) > 0 ? $images[0] : null;
                                        @endphp
                                        @if ($firstImage)
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $car->name }}"
                                                class="car-image">
                                        @else
                                            <div
                                                class="car-image flex items-center justify-center bg-gray-200 text-gray-400">
                                                No Image
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-gray-800">{{ $car->name }}</td>
                                    <td class="px-4 py-4 text-gray-600">Rp
                                        {{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                                            {{ ucfirst($car->transmission) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600">{{ $car->seats }} Seats</td>
                                    <td class="px-4 py-4 text-gray-600">{{ ucfirst($car->fuel_type) }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex space-x-2">
                                            <a href="/admin/edit-car/{{ $car->id }}"
                                                class="rounded-lg bg-yellow-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-yellow-600">
                                                Edit
                                            </a>
                                            <form action="/admin/delete-car/{{ $car->id }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this car?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-12 text-center">
                    <svg class="mx-auto mb-4 h-24 w-24 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mb-4 text-xl font-semibold text-gray-600">No cars available</p>
                    <a href="/admin/add-new-car"
                        class="inline-block rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">
                        Add Your First Car
                    </a>
                </div>
            @endif
        </div>
    </div>

</body>

</html>
