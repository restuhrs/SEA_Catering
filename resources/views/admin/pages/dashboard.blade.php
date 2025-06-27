@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-green-800">Admin Dashboard</h1>

    <!-- Date Range Filter -->
    <div id="reports" class="bg-white p-4 rounded-lg shadow mb-8">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Filter by Date Range</h2>

            <form method="GET" class="flex flex-wrap gap-4">

                <input type="date" name="start_date" value="{{ $start }}"
                    class="border px-2 py-2 rounded-xl w-fit sm:w-60 md:w-52">

                <input type="date" name="end_date" value="{{ $end }}"
                    class="border px-2 py-2 rounded-xl w-fit sm:w-60 md:w-52">

                    <button type="submit"
                        class="flex items-center justify-center px-4 py-2 rounded-xl bg-gradient-to-r from-green-400 to-green-600 text-white hover:from-green-600 hover:to-green-700 transition">
                        <i class="fas fa-search text-white text-xl"></i>
                    </button>
            </form>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-gray-700">New Subscriptions</h3>

            <!-- Total New -->
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $newSubscriptions }}</p>
            <p class="text-sm text-gray-500">Total in Range</p>

            <!-- Active & Inactive in Range (Side by side) -->
            <div class="flex justify-center gap-6 mt-2">
                <!-- Active -->
                <div>
                    <p class="text-2xl font-semibold text-green-600">{{ $activeNewSubscriptions->count() }}</p>
                    <p class="text-sm text-green-700">Active</p>
                </div>

                <!-- Inactive -->
                <div>
                    <p class="text-2xl font-semibold text-red-500">{{ $inactiveNewSubscriptions->count() }}</p>
                    <p class="text-sm text-red-600">Inactive</p>
                </div>
            </div>
        </div>


        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-gray-700">Monthly Revenue</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-gray-700">Reactivations</h3>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $reactivations }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h3 class="text-lg font-semibold text-gray-700">Active Subscriptions</h3>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $activeSubscriptions }}</p>
            <p class="text-sm text-gray-500">Total until {{ \Carbon\Carbon::parse($latestDeliveryDate)->format('d M Y') }}</p>
        </div>
    </div>

    <!-- Subscription Chart -->
    <div id="subscription-chart" class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Subscription Chart</h2>
        <div class="flex justify-center">
        <div class="w-full md:w-[80%] h-[200px] md:h-[400px]">
            <canvas id="subscriptionsChart" class="w-full h-full"></canvas>
        </div>
    </div>
    </div>

    <!-- Recent Subscriptions Table -->
    <div class="bg-white p-6 rounded-lg shadow">

        <!-- Header & Search Row -->
        <div id="recent-subscriptions" class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Recent Subscriptions</h2>

            <!-- Search bar with icon -->
            <div class="relative self-end w-fit md:w-fit">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
                <input
                    type="text"
                    id="subscriptionSearch"
                    placeholder="Search..."
                    class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-xl placeholder-gray-400"
                    onkeyup="filterSubscriptions()"
                >
            </div>
        </div>

        <!-- Scroll wrapper -->
        <div class="overflow-x-auto">
            <table class="min-w-[800px] table-auto border">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-4 border">Name</th>
                        <th class="p-4 border">Phone</th>
                        <th class="p-4 border">Plan</th>
                        <th class="p-4 border">Total Price</th>
                        <th class="p-4 border">Status</th>
                        <th class="p-4 border">Ends On</th>
                        <th class="p-4 border">Delivery Dates</th>
                    </tr>
                </thead>
                <tbody id="subscriptionTableBody">
                    @forelse($subscriptions as $sub)
                        <tr>
                            <td class="p-4 border whitespace-nowrap">{{ $sub->full_name }}</td>
                            <td class="p-4 border whitespace-nowrap">{{ $sub->phone }}</td>
                            <td class="p-4 border whitespace-nowrap">{{ $sub->plan }}</td>
                            <td class="p-4 border whitespace-nowrap">Rp{{ number_format($sub->total_price, 0, ',', '.') }}</td>
                            <td class="p-4 border whitespace-nowrap">{{ $sub->status }}</td>
                            <td class="p-4 border whitespace-nowrap">
                                @php
                                    $lastDate = collect($sub->delivery_days)->max();
                                @endphp
                                @if($lastDate)
                                    {{ \Carbon\Carbon::parse($lastDate)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-4 border whitespace-nowrap">
                                @php
                                    $formattedDates = array_map(function($date) {
                                        $carbon = \Carbon\Carbon::parse($date);
                                        return $carbon->format('l') . ' (' . $carbon->format('d/m/y') . ')';
                                    }, $sub->delivery_days);
                                @endphp
                                {{ implode(', ', $formattedDates) }}
                            </td>
                        </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500">No subscriptions found.</td>
                            </tr>
                        @endforelse

                        <!-- no result row -->
                        <tr id="noResultRow" class="hidden">
                            <td colspan="7" class="p-4 text-center text-gray-500">No results found.</td>
                        </tr>
                </tbody>
            </table>

            <!-- paginate -->
            <div class="flex justify-between items-center mt-4 text-sm text-gray-600" id="paginationInfo"></div>
            <div class="flex justify-end mt-2" id="paginationControls"></div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- chart subs -->
<script>
    const ctx = document.getElementById('subscriptionsChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Subscription',
                    data: {!! json_encode($activeChartData) !!},
                    fill: true,
                    backgroundColor: 'rgba(34,197,94,0.2)',
                    borderColor: 'rgba(34,197,94,1)',
                    tension: 0.3
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

<!-- search bar -->
<script>
    function filterSubscriptions() {
        const input = document.getElementById('subscriptionSearch');
        const filter = input.value.toLowerCase();
        const table = document.querySelector('table');
        const trs = table.querySelectorAll('tbody tr');

        trs.forEach(tr => {
            const text = tr.textContent.toLowerCase();
            tr.style.display = text.includes(filter) ? '' : 'none';
        });
    }
</script>

<!-- paginate & seacrh bar -->
<script>
    let allRows = [];
    let currentRows = [];
    const perPage = 5;
    let currentPage = 1;

    function renderTablePage(page) {
        const start = (page - 1) * perPage;
        const end = start + perPage;

        // Tampilkan/hilangkan baris yang sedang dicari
        currentRows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });

        // Tampilkan/hidden "no result" row
        const noResultRow = document.getElementById('noResultRow');
        if (currentRows.length === 0) {
            if (noResultRow) noResultRow.classList.remove('hidden');
        } else {
            if (noResultRow) noResultRow.classList.add('hidden');
        }

        // Update info pagination
        document.getElementById('paginationInfo').innerHTML = `
            Showing ${currentRows.length === 0 ? 0 : Math.min(start + 1, currentRows.length)} to ${Math.min(end, currentRows.length)} of ${currentRows.length} entries
        `;

        const totalPages = Math.ceil(currentRows.length / perPage);
        const paginationControls = document.getElementById('paginationControls');
        paginationControls.innerHTML = '';

        if (totalPages > 1) {
            const nav = document.createElement('nav');
            nav.className = 'flex items-center space-x-1';

            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '&laquo;';
            prevBtn.className = `px-3 py-1 rounded-full border ${page === 1 ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'hover:bg-green-100 text-green-600'}`;
            prevBtn.disabled = page === 1;
            prevBtn.onclick = () => renderTablePage(currentPage - 1);
            nav.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `w-8 h-8 rounded-full border text-sm ${
                    i === page ? 'bg-green-600 text-white' : 'text-gray-600 hover:bg-green-100'
                }`;
                btn.onclick = () => renderTablePage(i);
                nav.appendChild(btn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.innerHTML = '&raquo;';
            nextBtn.className = `px-3 py-1 rounded-full border ${page === totalPages ? 'bg-gray-200 text-gray-400 cursor-not-allowed' : 'hover:bg-green-100 text-green-600'}`;
            nextBtn.disabled = page === totalPages;
            nextBtn.onclick = () => renderTablePage(currentPage + 1);
            nav.appendChild(nextBtn);

            paginationControls.appendChild(nav);
        }

        currentPage = page;
    }

    function filterSubscriptions() {
        const filter = document.getElementById('subscriptionSearch').value.toLowerCase();

        currentRows = allRows.filter(row => {
            const match = row.textContent.toLowerCase().includes(filter);
            row.style.display = match ? '' : 'none';
            return match;
        });

        renderTablePage(1);
    }

    document.addEventListener('DOMContentLoaded', () => {
        allRows = Array.from(document.querySelectorAll('#subscriptionTableBody tr')).filter(row => !row.id || row.id !== 'noResultRow');
        currentRows = [...allRows];
        renderTablePage(1);
    });
</script>

@endpush
