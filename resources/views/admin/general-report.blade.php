<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | General Report</title>
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

        table {
            font-size: 0.75rem;
        }

        th,
        td {
            padding: 0.5rem;
            white-space: nowrap;
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
            <a href="/admin/report"
                class="block border-l-4 border-white bg-red-700 px-4 py-3 text-lg font-medium transition duration-150">
                General Report
            </a>
            <a href="/admin/add-new-car"
                class="block px-4 py-3 text-lg font-medium transition duration-150 hover:bg-red-700">
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
        <h1 class="mb-10 text-4xl font-extrabold text-gray-800">General Report</h1>

        @if (session('success'))
            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="admin-card overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Username</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No
                            Whatsapp</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Mobil
                            Pesanan</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Lokasi Pick-up</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Tanggal Pick-up</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Waktu
                            Pick-up</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Tanggal Return</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Waktu
                            Return</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Dengan Sopir</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">SO
                            Number</th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Status
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">

                    @forelse ($data as $report)
                        <tr>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->user->username }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->user->email }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->user->phone_number }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->car->name }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->pickup_location }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->pickup_date }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->pickup_time }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->return_date }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->return_time }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">
                                {{ $report->with_driver == 1 ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-3 py-2 text-xs text-gray-900">{{ $report->so_number }}</td>
                            <td class="px-3 py-2">
                                @if ($report->status === 'paid' && $report->is_confirmed)
                                    <span
                                        class="inline-flex rounded-full bg-green-500 px-3 py-1 text-xs font-semibold text-white">
                                        Paid</span>
                                @elseif ($report->status === 'paid' && !$report->is_confirmed)
                                    <span
                                        class="inline-flex rounded-full bg-green-500 px-3 py-1 text-xs font-semibold text-white">
                                        Paid</span>
                                @elseif ($report->status === 'unpaid')
                                    <span
                                        class="inline-flex rounded-full bg-yellow-500 px-3 py-1 text-xs font-semibold text-white">
                                        Unpaid</span>
                                @elseif ($report->status === 'cancelled')
                                    <span
                                        class="inline-flex rounded-full bg-red-500 px-3 py-1 text-xs font-semibold text-white">
                                        Cancelled</span>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                @if ($report->status != 'paid')
                                    -
                                @elseif ($report->is_confirmed)
                                    <span
                                        class="inline-flex rounded-full bg-green-500 px-3 py-1 text-xs font-semibold text-white">
                                        Confirmed</span>
                                @else
                                    <form action="/admin/confirm-rental/{{ $report->id }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex rounded-full bg-blue-500 px-3 py-1 text-xs font-semibold text-white transition duration-150 hover:bg-blue-600">
                                            Confirm
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="px-3 py-2 text-center text-xs text-gray-500">Belum ada data
                                laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
